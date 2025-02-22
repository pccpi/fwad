<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\VoteController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('polls', PollController::class);
    Route::post('/votes/{option}', [VoteController::class, 'store']);
});
