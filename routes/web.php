<?php

use App\Http\Controllers\Web\AuthPageController;
use App\Http\Controllers\Web\FeaturePageController;
use App\Http\Controllers\Web\PollController;
use App\Http\Controllers\Web\ProfilePageController;
use App\Http\Middleware\AuthVerifyMiddleware;
use App\Http\Middleware\isAuthOrNotMiddleware;
use App\Http\Middleware\LoggedUserAuthPageRestrictionMiddleware;
use App\Http\Middleware\VisitorLogMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([isAuthOrNotMiddleware::class])->group(function () {
    Route::get('/', function () {
        return view('components.client.landing.layout');
    })->name('index');

    Route::get('/profile', [ProfilePageController::class, 'profile'])->name('profilePage');
    Route::get('/profile/@{username?}', [ProfilePageController::class, 'profile'])->name('userProfilePage');
    Route::get('/poll/{poll_uid}', [FeaturePageController::class, 'viewPoll'])->name('pollPage')->middleware([VisitorLogMiddleware::class]);
    Route::get('/poll/private/{poll_uid}', [PollController::class, 'viewPrivatePoll'])->name('privatePollPage')->middleware('signed');
    Route::get('/polls/feed', [FeaturePageController::class, 'pollFeed'])->name('pollFeed');
});

Route::get('/create-poll', [FeaturePageController::class, 'createPoll'])->name('createPage')->middleware([AuthVerifyMiddleware::class]);

Route::middleware([LoggedUserAuthPageRestrictionMiddleware::class])->group(function () {
    Route::get('/login', [AuthPageController::class, 'login'])->name('loginPage');
    Route::get('/register', [AuthPageController::class, 'register'])->name('registerPage');
    Route::get('/verify-process', [AuthPageController::class, 'verifyMail'])->name('verifyProcess');
    Route::get('/forgot-password', [AuthPageController::class, 'forgot'])->name('forgotPwdPage');
});
