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

}
