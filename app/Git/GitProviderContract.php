<?php

namespace App\Git;

use App\Models\App;
use App\Models\Deployment;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

interface GitProviderContract
{
    public function getCommitUrl(string $hash, string $repo, string $org): string;

    public function extractFromUrl(string $url): GitUrlParts;

    /** @throws ValidationException */
    public function fetchAndDeploy(App $app): Deployment;

    /** @throws ValidationException */
    public function webhook(App $app, Request $request): Deployment|string;
}
