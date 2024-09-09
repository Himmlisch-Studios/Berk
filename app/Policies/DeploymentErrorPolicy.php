<?php

namespace App\Policies;

use App\Models\DeploymentError;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeploymentErrorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, DeploymentError $deploymentError)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, DeploymentError $deploymentError)
    {
        return false;
    }

    public function delete(User $user, DeploymentError $deploymentError)
    {
        return false;
    }

    public function restore(User $user, DeploymentError $deploymentError)
    {
        return false;
    }

    public function forceDelete(User $user, DeploymentError $deploymentError)
    {
        return false;
    }
}
