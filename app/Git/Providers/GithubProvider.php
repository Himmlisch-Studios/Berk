<?php

namespace App\Git\Providers;

use App\Git\GitProviderContract;
use App\Git\GitUrlParts;
use App\Git\GitUtils;
use App\Git\Validators\GithubValidator;
use App\Models\App;
use Illuminate\Http\Request;
use App\Models\Deployment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

final class GithubProvider implements GitProviderContract
{
    public const REGEX = "/^(https?:\/\/|git@)(github\.com)(?:[\/:])([a-zA-Z0-9\-\_]+)\/([a-zA-Z0-9\-\_]+)(?:\.git)?/";

    public function __construct() {}

    public function getCommitUrl(string $hash, string $org, string $repo): string
    {
        return "https://github.com/{$org}/{$repo}/commit/{$hash}";
    }

    public function extractFromUrl(string $url): GitUrlParts
    {
        preg_match(self::REGEX, $url, $matches);

        try {
            [$_, $protocol, $domain, $org, $repo] = $matches;
        } catch (\Throwable $th) {
            throw new InvalidArgumentException("Invalid URL given");
        }

        return new GitUrlParts(
            domain: $domain,
            org: $org,
            repo: $repo,
            ssh: in_array($protocol, ['git@', 'ssh://']),
        );
    }

    public function fetchAndDeploy(App $app): Deployment
    {
        $parts = $this->extractFromUrl($app->repository);

        $response = Http::asJson()
            ->accept('application/vnd.github+json')
            ->withHeader('X-GitHub-Api-Version', '2022-11-28')
            ->withHeader('Authorization', 'Bearer ' . env('GIT_PASS_' . GitUtils::formatEnvKey($parts->org), env('GIT_PASS')))
            ->get("https://api.github.com/repos/{$parts->org}/{$parts->repo}/commits/heads/{$app->branch}");

        $latestCommit = $response->json();

        if (isset($latestCommit['status'])) {
            throw_unless($latestCommit['status'] == 200, 'Github error (' . $latestCommit['status'] . '): ' . $latestCommit['message'] . '. ' . $latestCommit['documentation_url'] ?? '');
        }

        return $app->deployments()->create([
            'hash' => $latestCommit['sha'],
            'ref' => "refs/heads/{$app->branch}",
            'message' => $latestCommit['commit']['message'],
            'committer_email' => $latestCommit['commit']['committer']['email'],
            'committer_name' => $latestCommit['commit']['committer']['name'],
            'committer_username' => $latestCommit['commit']['committer']['username'] ?? null,
            'pushed_at' => now(),
            'commited_at' => Carbon::make($latestCommit['commit']['committer']['date']),
        ]);
    }

    public function webhook(App $app, Request $request): Deployment|string
    {
        throw_unless($event = $request->header('X-GitHub-Event'), ValidationException::withMessages(['Not a valid event.']));

        if ($event !== 'push') {
            throw_unless($event == 'ping', ValidationException::withMessages(['Webhook should only receive push events.']));

            return 'pong!';
        }

        app(GithubValidator::class)->validate($request, env('GITHUB_SECRET', ''));

        $data = $request->only([
            'after',
            'ref',
            'pusher.email',
            'pusher.name',
            'pusher.username',
            'head_commit',
        ]);

        throw_unless(isset($data['head_commit']), ValidationException::withMessages(['Head commit is not set']));

        if (str($data['ref'])->after('heads/')->toString() !== $app->branch) {
            return 'Ignoring branch push';
        }

        return $app->deployments()->create([
            'hash' => $data['after'],
            'ref' => $data['ref'],
            'message' => $data['head_commit']['message'],
            'committer_email' => $data['pusher']['email'],
            'committer_name' => $data['pusher']['name'],
            'committer_username' => $data['pusher']['username'] ?? null,
            'pushed_at' => now(),
            'commited_at' => Carbon::make($data['head_commit']['timestamp']),
        ]);
    }
}
