<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VideoController;
use App\Models\PrivacyPolicy;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    // Admin routes for managing news
    Route::apiResource('ads', AdController::class);
    Route::post('/ads/{id}', [AdController::class, 'update']);

    Route::apiResource('news', NewsController::class);
    Route::post('/news/{id}', [NewsController::class, 'update']);

    Route::apiResource('policy', NewsController::class);
    Route::post('/policy/{id}', [NewsController::class, 'update']);

    Route::apiResource('people', PeopleController::class);
    Route::post('/people/{id}', [PeopleController::class, 'update']);

    Route::get('/settings', [SettingsController::class, 'getSettings']); // Public route to retrieve settings
    Route::post('/settings', [SettingsController::class, 'updateSettings'])->middleware('auth:sanctum'); // Protected route to update settings

});
