<?php
namespace App\Observers;

use App\Jobs\WelcomeMailJob;
use App\Models\User;
use App\Services\EmailVerificationService;

class RegistrationObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if (! $user->email_verified) {
            EmailVerificationService::sendMail($user);
        }

        dispatch(new WelcomeMailJob((Object) $user));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
