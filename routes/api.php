<?php

use App\Http\Controllers\Api\AppoimentController;
use App\Http\Controllers\Api\ContactMeController;
use App\Http\Controllers\Api\ExperiencesController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Registered API routes for backend app
|
*/

// experiences
Route::get('experiences', [ExperiencesController::class, 'index']);
Route::get('experiences/{experience:slug}', [ExperiencesController::class, 'show']);

//settings 
Route::get('settings', [SettingsController::class, 'index']);

//contact
Route::post('contact-me', [ContactMeController::class, 'store']);

//appoiment
Route::post('appoiment', [AppoimentController::class, 'store']);