<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', [UserController::class, 'show']);

Route::get('/settings', [SettingsController::class, 'getSettings']); // Public route to retrieve settings
Route::post('/settings', [SettingsController::class, 'updateSettings'])->middleware('auth:sanctum'); // Protected route to update settings
