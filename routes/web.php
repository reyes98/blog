<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashbooardController;
use App\Http\Controllers\Admin\ExperiencesController;
use App\Http\Controllers\Admin\SettingsController;
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
        Route::get('settings', [SettingsController::class, 'create'])->name('settings.create');
        Route::post('settings/save-hero', [SettingsController::class, 'saveHero'])->name('settings.save-hero');
        Route::post('settings/save-about', [SettingsController::class, 'saveAbout'])->name('settings.save-about');
        Route::post('settings/save-contact', [SettingsController::class, 'saveContact'])->name('settings.save-contact');
        Route::resource('categories', CategoriesController::class);
        Route::resource('experiences', ExperiencesController::class);
    });
