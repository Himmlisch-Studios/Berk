<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;
// use WeblaborMx\TallUtils\Models\WithActivityLog;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SearchableTrait;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $searchable = [
        'columns' => [
            'name' => 10,
        ],
    ];

    /*
     * Setup
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /*
     * Attributes
     */

    protected function email(): Attribute
    {
        // Always ensure normalization of emails
        return Attribute::make(
            get: fn($value) => strtolower(trim($value)),
            set: fn($value) => strtolower(trim($value))
        );
    }

    protected function avatar(): Attribute
    {
        return Attribute::get(function () {
            if ($this->photo) {
                return $this->photo;
            }

            $md5 = md5($this->email);

            return "https://api.dicebear.com/9.x/thumbs/png?seed={$md5}&size=120";
        })->shouldCache();
    }
}
