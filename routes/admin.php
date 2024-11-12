<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    // Admin routes for managing news
    Route::apiResource('news', NewsController::class);

    Route::get('/settings', [SettingsController::class, 'getSettings']); // Public route to retrieve settings
    Route::post('/settings', [SettingsController::class, 'updateSettings'])->middleware('auth:sanctum'); // Protected route to update settings


    // Admin routes for managing ads
    Route::apiResource('ads', AdController::class);
    Route::apiResource('videos', VideoController::class);

});
