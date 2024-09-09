<?php

namespace App\Policies;

use App\Models\App;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, App $app)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, App $app)
    {
        return true;
    }

    public function delete(User $user, App $app)
    {
        return true;
    }

    public function restore(User $user, App $app)
    {
        return true;
    }

    public function forceDelete(User $user, App $app)
    {
        return true;
    }
}
