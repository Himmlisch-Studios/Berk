<?php

namespace App\Front\Actions;

use App\Git\GitProviderContract;
use App\Jobs\DeployJob;
use App\Models\App;
use App\Models\Deployment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class Deploy extends Action
{
    public function handle()
    {
        /** @var App */
        $app = $this->object;
        /** @var GitProviderContract */
        $provider = $app->provider->construct();

        $deployment = $provider->fetchAndDeploy($app);

        DeployJob::dispatch($deployment);
    }
}
