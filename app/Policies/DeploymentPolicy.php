<?php

namespace App\Policies;

use App\Models\Deployment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeploymentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Deployment $deployment)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Deployment $deployment)
    {
        return false;
    }

    public function delete(User $user, Deployment $deployment)
    {
        return false;
    }

    public function restore(User $user, Deployment $deployment)
    {
        return false;
    }

    public function forceDelete(User $user, Deployment $deployment)
    {
        return false;
    }
}
