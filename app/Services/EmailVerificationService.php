<?php
namespace App\Services;

use App\Notifications\EmailVerifyNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class EmailVerificationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public static function sendMail($user)
    {
        $signedURL = URL::temporarySignedRoute('verifyEmail', now()->addMinutes(5), ['username' => $user->username]);
        Notification::send($user, new EmailVerifyNotification($signedURL));
    }

}
