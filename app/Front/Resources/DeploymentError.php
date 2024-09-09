<?php

namespace App\Front\Resources;

use WeblaborMx\Front\Inputs;
use App\Front\Inputs as Custom;
use App\Models\DeploymentError as Model;
use App\Front\Resources\Resource;

class DeploymentError extends Resource
{
    public $base_url = '/admin/deployment_errors';
    public $model = Model::class;
    public $icon = 'bug-ant';
    public $title = 'id';
    public $showOnMenu = false;

    public function fields()
    {
        return [
            Inputs\ID::make(),
            Inputs\Textarea::make('Stdout'),
            Inputs\Textarea::make('Stderr'),
            Inputs\DateTime::make('Created At'),
        ];
    }
}
