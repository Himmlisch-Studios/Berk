<?php

namespace App\Front\Resources;

use App\Models\User as Model;
use WeblaborMx\Front\Inputs;

class User extends Resource
{
    public $base_url = '/admin/users';
    public $model = Model::class;
    public $title = 'name';
    public $icon = 'users';

    public function fields()
    {
        return [
            Inputs\ID::make(),
            Inputs\Text::make('Name')->rules('required'),
            Inputs\Text::make('Email')->rules(['required', 'email']),
            Inputs\Password::make('Password')->rules(['string', 'min:8', 'nullable'])->creationRules('required'),
        ];
    }
}
