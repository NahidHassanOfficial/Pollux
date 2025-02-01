<?php
namespace App\Http\Controllers\API\Auth;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $request->validated();
        User::create($request->validated());

        return Response::success();
    }

    public function verifyEmail($username)
    {
        if (! request()->hasValidSignature()) {
            return Response::failed('Invalid Signature');
        }

        $user                 = User::where('username', $username)->firstOrFail();
        $user->email_verified = 1;
        $user->save();

        return Response::success('Email verified successfully');
    }

}
