<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashbooardController;
use App\Http\Controllers\Admin\ExperiencesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AppoimentsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', [DashbooardController::class, 'index'])->name('dashboard');

        //settings
        Route::get('settings', [SettingsController::class, 'create'])->name('settings.create');
        Route::post('settings/save-hero', [SettingsController::class, 'saveHero'])->name('settings.save-hero');
        Route::post('settings/save-about', [SettingsController::class, 'saveAbout'])->name('settings.save-about');
        Route::post('settings/save-contact', [SettingsController::class, 'saveContact'])->name('settings.save-contact');

        //appoiments
        Route::resource('appoiments', AppoimentsController::class);
        Route::get('updateStatus', [AppoimentsController::class, 'updateStatus'])->name('appoiments.updateStatus');

        //categories
        Route::resource('categories', CategoriesController::class);

        //experiences
        Route::resource('experiences', ExperiencesController::class);
    });
