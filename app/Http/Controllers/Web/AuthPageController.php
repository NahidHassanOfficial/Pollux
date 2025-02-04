<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class AuthPageController extends Controller
{
    public function login()
    {
        return view('components.auth.login');
    }
    public function register()
    {
        return view('components.auth.register');
    }public function forgot()
    {
        return view('components.auth.forgot');
    }public function otp()
    {
        return view('components.auth.otp');
    }public function verifyMail()
    {
        return view('components.auth.verify-mail');
    }
}
