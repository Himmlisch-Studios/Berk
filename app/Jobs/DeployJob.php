<?php

namespace App\Jobs;

use App\Git\GitUtils;
use App\Models\App;
use App\Models\Deployment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Symfony\Component\Process\Process;

class DeployJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        readonly public Deployment $deployment
    ) {}

    public function handle(): void
    {
        $deployment = $this->deployment;
        /** @var App */
        $app = $deployment->app;
        $cwd = $app->directory;

        $gitPassKey = $this->gitPass();
        $envs = [
            // System env
            'HOME' => env('HOME'),
            'COMPOSER_HOME' => env('COMPOSER_HOME', DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . exec('whoami') . DIRECTORY_SEPARATOR . '.composer'),
            // Git env
            'GIT_USER' => env('GIT_USER'),
            $gitPassKey => env($gitPassKey),
            'GIT_TERMINAL_PROMPT' => 0,
            // App env
            'REPO' => $app->repository,
            'BRANCH' => $app->branch,
            'REF' => $deployment->ref,
        ];

        $stdout = [];
        $stderr = [];
        $stdCollection = function ($type, $buffer) use (&$stdout, &$stderr): void {
            if (Process::ERR === $type) {
                array_push($stderr, $this->censor($buffer));
            } else {
                array_push($stdout, $this->censor($buffer));
            }
        };

        if (!$this->checkExists($cwd)) {
            $msg = "Directory {$cwd} doesn\'t exists";
            $this->deployError($msg, $stdout, [$msg]);
            return;
        }

        $gitCmd = $this->gitCommand();

        if ($this->checkIsEmpty($cwd)) {
            $pull = Process::fromShellCommandline($gitCmd . ' clone "${:REPO}" .', $cwd);
        } else {
            $pull = Process::fromShellCommandline($gitCmd . ' pull "${:REPO}" "${:REF}" -f', $cwd);
        }

        try {
            $pull->run($stdCollection, $envs);
        } catch (\Throwable $th) {
            $this->deployError($th, $stdout, $stderr);
            return;
        }

        if ($this->job->hasFailed()) return;

        if (!$pull->isSuccessful()) {
            $this->deployError('Couldn\'t pull the git repository', $stdout, $stderr);
            return;
        }

        if ($this->job->hasFailed()) return;

        if ($app->enable_script) {
            $lines = str($app->script)->explode("\n");

            $singleLine = $lines->map(fn($v) => trim($v))->filter()->join(' && ');

            logger()->info($singleLine);

            $userScript = Process::fromShellCommandline($singleLine, $cwd);

            try {
                $userScript->run($stdCollection, $envs);
            } catch (\Throwable $th) {
                $this->deployError($th, $stdout, $stderr);
                return;
            }

            if ($this->job->hasFailed()) return;

            if (!$userScript->isSuccessful()) {
                $this->deployError('User script was unsucessful', $stdout, $stderr);
                return;
            }
        }

        if ($this->job->hasFailed()) return;

        $this->deployment->processed_at = now();
        $this->deployment->save();
    }

    private function censor(mixed $output): string
    {
        return str_replace([
            env($this->gitPass())
        ], '****************', $output);
    }

    private function gitPass(): string
    {
        $provider = $this->deployment->app->provider->construct();
        $gitUrl = $provider->extractFromUrl($this->deployment->app->repository);

        $orgKey = GitUtils::formatEnvKey($gitUrl->org);

        $gitPassKey = 'GIT_PASS_' . $orgKey;

        return isset($_ENV[$gitPassKey]) ? $gitPassKey : 'GIT_PASS';
    }

    private function gitCommand(): string
    {
        return 'git -c credential.helper=\'!f() { sleep 1; echo "username=${GIT_USER}"; echo "password=${' . $this->gitPass() . '}"; }; f\'';
    }

    private function checkIsEmpty($dir): bool
    {
        $process = Process::fromShellCommandline('ls | wc -l', $dir);
        $process->run();

        throw_unless($process->isSuccessful(), $process->getErrorOutput());

        return trim($process->getOutput()) == 0;
    }

    private function checkExists($dir): bool
    {
        $process = Process::fromShellCommandline('test -d "${:DIRPATH}" && echo "1"', null, [...$_ENV, 'DIRPATH' => $dir]);
        $process->run();

        return trim($process->getOutput()) == true;
    }

    private function deployError(\Throwable|string|null $exception, array $stdout, array $stderr)
    {
        logger()->info(json_encode([
            'stdout' => implode("\n", $stdout),
            'stderr' => implode("\n", $stderr)
        ]));

        $this->deployment->errors()->create([
            'stdout' => implode("\n", $stdout),
            'stderr' => implode("\n", $stderr)
        ]);
        $this->deployment->failed_at = now();
        $this->deployment->save();

        $this->fail($exception);
    }
}
