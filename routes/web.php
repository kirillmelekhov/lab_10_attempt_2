<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CreativeTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderCabinetController;
use App\Http\Controllers\MasterClassController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/creative-types/{creativeType:slug}', [CreativeTypeController::class, 'show'])
    ->name('creative-types.show');

Route::middleware('auth')->group(function (): void {
    Route::get('/master-classes/{masterClass}/confirm-booking', [BookingController::class, 'confirm'])
        ->name('master-classes.confirm-booking');
    Route::post('/master-classes/{masterClass}/book', [BookingController::class, 'store'])
        ->name('master-classes.book');
    Route::post('/master-classes/{masterClass}/cancel-booking', [BookingController::class, 'cancel'])
        ->name('master-classes.cancel-booking');
});

Route::middleware(['auth', 'leader'])->group(function (): void {
    Route::get('/cabinet', LeaderCabinetController::class)->name('leader.cabinet');
    Route::get('/master-classes/create', [MasterClassController::class, 'create'])->name('master-classes.create');
    Route::post('/master-classes', [MasterClassController::class, 'store'])->name('master-classes.store');
    Route::get('/master-classes/{masterClass}/edit', [MasterClassController::class, 'edit'])->name('master-classes.edit');
    Route::put('/master-classes/{masterClass}', [MasterClassController::class, 'update'])->name('master-classes.update');
});
