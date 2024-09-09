<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Deployment extends Model
{
    use SearchableTrait, SoftDeletes, LogsActivity;

    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'name' => 10,
        ],
    ];

    /*
     * Setup
     */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }

    /*
     * Relationships
     */

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function errors()
    {
        return $this->hasMany(DeploymentError::class);
    }
}
