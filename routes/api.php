<?php

use App\Http\Controllers\API\PollController;
use App\Http\Controllers\API\PollFeedController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\VotingController;
use Illuminate\Support\Facades\Route;

require_once 'authAPI.php';

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/poll/create', [PollController::class, 'createPoll'])->name('poll.create');
    Route::post('/poll/delete', [PollController::class, 'deletePoll'])->name('poll.delete');
});

Route::get('/profile/{username}', [ProfileController::class, 'profile']);
Route::get('/profile/{username}/polls', [ProfileController::class, 'userPolls']);

Route::get('/poll/{poll_uid}', [PollController::class, 'viewPoll'])->name('pollView');
Route::post('/poll/{poll_uid}/vote', [VotingController::class, 'vote'])->name('vote');

Route::get('/polls/feed/{filterParam?}', [PollFeedController::class, 'getPolls'])->name('getPolls');
Route::get('/polls/search/{search}', [PollFeedController::class, 'searchPoll'])->name('searchPoll');
