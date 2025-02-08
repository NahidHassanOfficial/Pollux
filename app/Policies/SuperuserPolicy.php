<?php

namespace App\Policies;

use App\Models\Superuser;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SuperuserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Superuser $superuser): bool
    {
        return $superuser->isAdmin() || $superuser->isModerator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Superuser $superuser): bool
    {
        return $superuser->isAdmin() || $superuser->isModerator();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Superuser $superuser): bool
    {
        return $superuser->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Superuser $superuser): bool
    {
        return $superuser->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Superuser $superuser): bool
    {
        return $superuser->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Superuser $superuser): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Superuser $superuser): bool
    {
        return false;
    }
}
