<?php

namespace App\Front\Resources;

use App\Front\Actions\Deploy;
use WeblaborMx\Front\Inputs;
use App\Front\Inputs as Custom;
use App\Models\App as Model;
use App\Front\Resources\Resource;
use App\Git\GitProvider;
use App\Rules\DomainRule;
use App\Rules\UserUnixDirectoryRule;
use Illuminate\Validation\ValidationException;
use WeblaborMx\Front\Components\Panel;

class App extends Resource
{
    public $base_url = '/admin/apps';
    public $model = Model::class;
    public $icon = 'server-stack';
    public $title = 'label';

    public function fields()
    {
        return [
            Inputs\ID::make(),
            Inputs\Text::make('Webhook Url')
                ->onlyOnDetail(),
            Inputs\Text::make('Label')
                ->placeholder('My App')
                ->rules(['required', 'string', 'max:255']),
            Inputs\Text::make('Domain')
                ->placeholder('app.mydomain.com')
                ->rules(['required', new DomainRule, 'unique:apps,domain'])
                ->hideWhenUpdating(),
            Inputs\Text::make('Directory')
                ->placeholder('/var/www/my-project/public_html')
                ->rules(['required', new UserUnixDirectoryRule]),
            Custom\Enum::make('Provider', 'provider', GitProvider::class)
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->default(GitProvider::Github->value),
            Inputs\Text::make('Repository')
                ->placeholder('https://github.com/organization/repository-name')
                ->hideWhenUpdating()
                ->rules(['required']),
            Inputs\Text::make('Branch')
                ->placeholder('master')
                ->default('master')
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->rules(['required', 'max:64']),
            Inputs\Boolean::make('Enable')
                ->hideFromIndex()
                ->rules(['boolean']),

            Inputs\DateTime::make('Created At')
                ->setWidth('1/2')
                ->onlyOnDetail(),
            Inputs\DateTime::make('Updated At')
                ->setWidth('1/2')
                ->onlyOnDetail(),

            Panel::make('Deployment Script', [
                Custom\Flask::make('Script'),
                Inputs\Boolean::make('Enable Script'),
            ])->hideWhenCreating()
                ->hideFromIndex(),

            Inputs\HasMany::make('Deployment'),
            Inputs\HasMany::make('DeploymentError')->setTitle('Errors'),
        ];
    }

    public function processDataBeforeSaving($data)
    {
        $gitProvider = GitProvider::from($data['provider']);

        try {
            $gitProvider->construct()->extractFromUrl($data['repository']);
        } catch (\InvalidArgumentException $_) {
            throw ValidationException::withMessages(['repository' => __('validation.regex', ['attribute' => 'repository'])]);
        }

        return parent::processDataBeforeSaving($data);
    }

    public function actions()
    {
        return [
            Deploy::class
        ];
    }
}
