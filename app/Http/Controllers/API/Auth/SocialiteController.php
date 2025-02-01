<?php
namespace App\Http\Controllers\API\Auth;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

    protected function uniqueUsername($name)
    {
        $username     = preg_replace('/\s+/', '', strtolower($name));
        $baseUsername = $username;
        $counter      = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public function loginGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    public function handleGoogleCallback()
    {
        $googleProfile = Socialite::driver('google')->stateless()->user();
        $userMatched   = User::where('google_id', $googleProfile->id)->first();
        $userModel     = $userMatched;

        if (! $userMatched) {
            $user = User::where('email', $googleProfile->email)->first();
            if ($user) {
                $user->update(['google_id' => $googleProfile->id, 'profile_img' => $googleProfile->avatar]);
                $userModel = $user;
            } else {
                $userName = $this->uniqueUsername($googleProfile->name);
                $user     = User::create([
                    'username'       => $userName,
                    'email'          => $googleProfile->email,
                    'google_id'      => $googleProfile->id,
                    'profile_img'    => $googleProfile->avatar,
                    'email_verified' => 1,
                ]);
                $userModel = $user;
            }
        }

        $token = $userModel->createToken('auth_token', ['*'], now()->addWeek())->plainTextToken;

        return Response::success($token);
    }
}
