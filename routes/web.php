<?php

use App\Http\Controllers\Web\AuthPageController;
use App\Http\Middleware\isAuthOrNotMiddleware;
use App\Http\Middleware\LoggedUserAuthPageRestrictionMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([isAuthOrNotMiddleware::class])->group(function () {
    Route::get('/', function () {
        return view('components.client.landing.layout');
    })->name('index');
});

Route::middleware([LoggedUserAuthPageRestrictionMiddleware::class])->group(function () {
    Route::get('/login', [AuthPageController::class, 'login'])->name('loginPage');
    Route::get('/register', [AuthPageController::class, 'register'])->name('registerPage');
    Route::get('/verify-process', [AuthPageController::class, 'verifyMail'])->name('verifyProcess');
    Route::get('/forgot-password', [AuthPageController::class, 'forgot'])->name('forgotPwdPage');
});
