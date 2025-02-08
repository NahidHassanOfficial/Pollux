<?php

namespace App\Policies;

use App\Models\Poll;
use App\Models\Superuser;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PollPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Superuser $superuser): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Superuser $superuser, Poll $poll): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Superuser $superuser): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Superuser $superuser, Poll $poll): bool
    {
        return $superuser->isAdmin() || $superuser->isModerator();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Superuser $superuser, Poll $poll): bool
    {
        return $superuser->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Superuser $superuser, Poll $poll): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Superuser $superuser, Poll $poll): bool
    {
        return false;
    }
}
