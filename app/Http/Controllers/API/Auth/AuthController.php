<?php
namespace App\Http\Controllers\API\Auth;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailVerificationService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        try {
            request()->validate([
                'email'    => 'required|email',
                'password' => 'required|string',
                'remember' => 'required|boolean',
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }

        $user = User::where('email', request()->email)->select('id', 'username', 'email', 'password', 'email_verified')->first();
        if ($user) {

            if (Hash::check(request()->password, $user->password)) {

                if (! $user->email_verified) {
                    EmailVerificationService::sendMail($user);
                    return Response::failed('Email not verified, please verify your email first.');
                }

                if (request()->remember === 1) {
                    $token = $user->createToken('auth_token', ['*'], now()->addMonth())->plainTextToken;
                } else {
                    $token = $user->createToken('auth_token', ['*'], now()->addDay())->plainTextToken;
                }

                return response()->json(['status' => 'success', 'auth_token' => $token]);
            }
        }
        return Response::failed('Invalid email or password!');
    }

    public function logout()
    {
        $isDeleted = request()->user()->currentAccessToken()->delete();
        if ($isDeleted) {
            return Response::success('Logged out successfully');
        } else {
            return Response::error();
        }
    }

    public function logoutAll()
    {
        $isDeleted = request()->user()->tokens()->delete();
        if ($isDeleted) {
            return Response::success('Logged out successfully');
        } else {
            return Response::error();
        }
    }
}
