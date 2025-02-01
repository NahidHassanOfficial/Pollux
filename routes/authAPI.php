<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:5,2')->group(function () {
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    Route::post('/verify-email', [RegisterController::class, 'verifyEmail'])->name('verifyEmail.post');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/send-otp', [AuthController::class, 'sendOTP'])->name('sendOTP.post');
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('verifyOTP.post');
    Route::post('/reset-password', [AuthController::class, 'changePassword'])->name('resetPass.post');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePass.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');
    Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('logoutAll.post');
});

Route::get('/auth/google-auth', [SocialiteController::class, 'loginGoogle'])->name('login.google');
Route::get('/auth/google-callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');
