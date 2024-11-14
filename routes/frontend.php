<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['record.view'])->prefix('front')->group(function () {
    // Public routes for viewing news
    Route::get('news', [NewsController::class, 'index']);
    Route::get('news/{id}', [NewsController::class, 'show']);

    // Public routes for viewing ads
    Route::get('ads', [AdController::class, 'index']);
    Route::get('ads/{id}', [AdController::class, 'show']);

    Route::get('videos', [VideoController::class, 'index']);
    Route::get('videos/{id}', [VideoController::class, 'show']);

    Route::get('people', [PeopleController::class, 'index']);
    Route::get('people/{id}', [PeopleController::class, 'show']);
});
