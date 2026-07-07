<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PinController;

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
     Route::get('/grid', fn () => view('grid', ['pageTitle' => 'Grid']))->name('grid');
    Route::get('/create', [PinController::class, 'create'])->name('pins.create');
    Route::post('/pins', [PinController::class, 'store'])->name('pins.store');
    Route::get('/boards', fn () => view('boards', ['pageTitle' => 'Boards']))->name('boards.index');
    Route::get('/account', fn () => view('account', ['pageTitle' => 'Account']))->name('profile.show');
    Route::get('/settings', fn () => view('settings', ['pageTitle' => 'Settings']))->name('profile.settings');
});

require __DIR__.'/auth.php';
