<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\SocialiteController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user/{username?}', [UserController::class, 'userSearch'])->name('searchUser');

Route::middleware('throttle:5,1')->group(function () {
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    Route::get('/verify-email/{username}', [RegisterController::class, 'verifyEmail'])->name('verifyEmail')->middleware('signed');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/reset-password', [AuthController::class, 'changePassword'])->name('resetPass.post');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePass.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');
    Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('logoutAll.post');
});

Route::get('/auth/google-auth', [SocialiteController::class, 'loginGoogle'])->name('login.google');
Route::get('/auth/google-callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');

//event broadcast auth
Route::post('/broadcasting/auth', function () {
    return response()->json(['auth' => true]);
})->middleware('auth:sanctum');
