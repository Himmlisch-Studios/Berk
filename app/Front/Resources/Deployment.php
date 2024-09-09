<?php

namespace App\Front\Resources;

use App\Front\Inputs\WireInput;
use WeblaborMx\Front\Inputs;
use App\Models\Deployment as Model;
use App\Front\Resources\Resource;
use WeblaborMx\Front\Components\Panel;

class Deployment extends Resource
{
    public $base_url = '/admin/deployments';
    public $model = Model::class;
    public $icon = 'rectangle-stack';
    public $title = 'id';
    public $showOnMenu = false;

    public function fields()
    {
        return [
            Inputs\ID::make(),
            Inputs\BelongsTo::make('App'),
            Inputs\Text::make('Hash'),
            Inputs\Text::make('Ref')->hideFromIndex(),
            Inputs\Textarea::make('Message'),
            Inputs\DateTime::make('Pushed At')->setWidth('1/2')->hideFromIndex(),
            Inputs\DateTime::make('Created At')->setWidth('1/2')->hideFromIndex(),
            Inputs\DateTime::make('Processed At')->setWidth('1/2'),
            Inputs\DateTime::make('Failed At')->setWidth('1/2'),

            Panel::make('Committer Info', [
                Inputs\Text::make(isset($this->related_object) ? 'Committer Name' : 'Name', 'committer_name'),
                Inputs\Text::make('Username', 'committer_username')->hideFromIndex(),
                Inputs\Text::make('Email', 'committer_email')->hideFromIndex(),
            ]),

            Inputs\HasMany::make('DeploymentError', 'errors')->setTitle('Errors'),
        ];
    }
}
