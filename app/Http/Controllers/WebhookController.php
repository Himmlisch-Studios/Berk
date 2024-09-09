<?php

namespace App\Http\Controllers;

use App\Git\GitProvider;
use App\Jobs\DeployJob;
use App\Models\App;
use App\Models\Deployment;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WebhookController extends Controller
{
    public function __invoke(Request $request, App $app)
    {
        abort_unless($app->exists, 404);

        /** @var GitProvider */
        $provider = $app->provider;

        try {
            $deployment = $provider->construct()->webhook($app, $request);
        } catch (ValidationException $th) {
            return response([
                'success' => false,
                'message' => $th->getMessage(),
            ], 400);
        }


        if (!$deployment instanceof Deployment) {
            return [
                'success' => true,
                'message' => $deployment
            ];
        }

        $deployment->load('app');

        DeployJob::dispatch($deployment);

        return [
            'success' => true,
            'message' => 'Deployment created!',
            'deployment' => $deployment
        ];
    }
}
