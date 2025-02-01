<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function userSearch($username)
    {
        $user = User::whereUsername($username)->count();
        if ($user) {
            return 1;
        } else {
            return 0;
        }
    }
}
