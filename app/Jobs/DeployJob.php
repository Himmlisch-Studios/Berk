<?php

namespace App\Jobs;

use App\Git\GitProviderContract;
use App\Models\App;
use App\Models\Deployment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\File;
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
        $envs = [
            'HOME' => env('HOME'),
            'GIT_TERMINAL_PROMPT' => 0,
            'REPO' => $app->repository,
            'BRANCH' => $app->branch,
            'REF' => $deployment->ref,
            'GIT_USER' => env('GIT_USER'),
            'GIT_PASS' => env('GIT_PASS'),
        ];

        $stdout = [];
        $stderr = [];
        $stdCollection = function ($type, $buffer) use (&$stdout, &$stderr): void {
            if (Process::ERR === $type) {
                array_push($stderr, $buffer);
            } else {
                array_push($stdout, $buffer);
            }
        };

        if (!File::isDirectory($cwd)) {
            $msg = "Directory {$cwd} doesn\'t exists";
            $this->deployError($msg, $stdout, [$msg]);
        }

        $gitConfig = 'git -c credential.helper=\'!f() { sleep 1; echo "username=${GIT_USER}"; echo "password=${GIT_PASS}"; }; f\'';

        if (File::isEmptyDirectory($cwd)) {
            $pull = Process::fromShellCommandline($gitConfig . ' clone "${:REPO}" .', $cwd);
        } else {
            $pull = Process::fromShellCommandline($gitConfig . ' pull "${:REPO}" "${:REF}" -f', $cwd);
        }

        try {
            $pull->run($stdCollection, $envs);
        } catch (\Throwable $th) {
            $this->deployError($th, $stdout, $stderr);
        }

        if ($this->job->hasFailed()) return;

        if (!$pull->isSuccessful()) {
            $this->deployError('Couldn\'t pull the git repository', $stdout, $stderr);
        }

        if ($this->job->hasFailed()) return;

        if ($app->enable_script) {
            $lines = str($app->script)->explode("\n");

            $singleLine = $lines->map(fn($v) => trim($v))->filter()->join(' && ');

            logger()->info($singleLine);

            $userScript = Process::fromShellCommandline($singleLine, $cwd, $envs);

            try {
                $userScript->run($stdCollection);
            } catch (\Throwable $th) {
                $this->deployError($th, $stdout, $stderr);
            }

            if ($this->job->hasFailed()) return;

            if (!$userScript->isSuccessful()) {
                $this->deployError('User script was unsucessful', $stdout, $stderr);
            }
        }

        if ($this->job->hasFailed()) return;

        $this->deployment->processed_at = now();
        $this->deployment->save();
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
