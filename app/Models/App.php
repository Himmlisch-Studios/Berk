<?php

namespace App\Models;

use App\Git\GitProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/** @property GitProvider $provider */
class App extends Model
{
    use SearchableTrait, LogsActivity, HasUuids;

    protected $guarded = ['webhook_id'];
    protected $searchable = [
        'columns' => [
            'name' => 10,
        ],
    ];

    /*
     * Setup
     */

    public function uniqueIds()
    {
        return ['webhook_id'];
    }

    protected function casts()
    {
        return [
            'provider' => GitProvider::class,
            'enable' => 'boolean',
            'enable_script' => 'boolean',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }

    /*
     * Relationships
     */

    public function deployments()
    {
        return $this->hasMany(Deployment::class);
    }

    public function deployment_errors()
    {
        return $this->hasManyThrough(DeploymentError::class, Deployment::class);
    }

    /*
     * Attributes
     */

    protected function webhookUrl(): Attribute
    {
        return Attribute::get(fn() => route('git.webhook', ['app' => $this]));
    }
}
