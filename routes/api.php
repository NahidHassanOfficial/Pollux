<?php

use App\Http\Controllers\API\FingerprintStoreController;
use App\Http\Controllers\API\PollController;
use App\Http\Controllers\API\PollFeedController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\VotingController;
use App\Http\Middleware\UniqueVoterValidator;
use Illuminate\Support\Facades\Route;

require_once 'authAPI.php';

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', [ProfileController::class, 'authUser'])->name('auth.user');

    Route::post('/poll/create', [PollController::class, 'createPoll'])->name('poll.create');
    Route::post('/poll/delete', [PollController::class, 'deletePoll'])->name('poll.delete');
});

Route::get('/profile/info/{username?}', [ProfileController::class, 'profileInfo'])->name('userInfo');
Route::get('/profile/polls/{username?}', [ProfileController::class, 'userPolls'])->name('userPolls');

Route::get('/poll/{poll_uid}', [PollController::class, 'viewPoll'])->name('pollView');
Route::post('/poll/{poll_uid}/vote', [VotingController::class, 'vote'])->name('vote')->middleware(UniqueVoterValidator::class);

Route::get('/polls/feed/{filterParam?}', [PollFeedController::class, 'getPolls'])->name('getPolls');
Route::get('/polls/search', [PollFeedController::class, 'searchPoll'])->name('searchPoll');

Route::post('/store-fingerprint', [FingerprintStoreController::class, 'store']);
