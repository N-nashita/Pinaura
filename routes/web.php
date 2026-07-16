<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pins/{pin}', [PinController::class, 'show'])->name('pins.show');

Route::middleware('auth')->group(function () {
    Route::get('/create', [PinController::class, 'create'])->name('pins.create');
    Route::post('/pins', [PinController::class, 'store'])->name('pins.store');
    Route::post('/pins/{pin}/vibe', [PinController::class, 'vibe'])->name('pins.vibe');
    Route::post('/pins/{pin}/save', [PinController::class, 'save'])->name('pins.save');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';