<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SkpdController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\RekonsiliasiController;


Route::get('/', function () {
    return redirect()->route('login');
});

// AUTH
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// DASHBOARD (SEMUA ROLE)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});

// ADMIN AREA (HANYA ADMIN)
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('skpd', SkpdController::class);
        Route::post('periode/generate', [PeriodeController::class, 'generate'])
            ->name('periode.generate');
        Route::resource('periode', PeriodeController::class);
        Route::resource('rekening', RekeningController::class);
});

Route::middleware(['auth'])
->prefix('rekonsiliasi')
->name('rekonsiliasi.')
->group(function () {

    // Semua role boleh lihat
    Route::get('/', [RekonsiliasiController::class, 'index'])->name('index');

    // Operator & Admin
    Route::middleware(['role:operator,admin'])->group(function () {
        Route::get('/create', [RekonsiliasiController::class, 'create'])->name('create');
        Route::post('/', [RekonsiliasiController::class, 'store'])->name('store');
        Route::get('/{rekonsiliasi}/edit', [RekonsiliasiController::class, 'edit'])->name('edit');
        Route::put('/{rekonsiliasi}', [RekonsiliasiController::class, 'update'])->name('update');
        Route::delete('/{rekonsiliasi}', [RekonsiliasiController::class, 'destroy'])->name('destroy');
    });

    Route::get('/{rekonsiliasi}', [RekonsiliasiController::class, 'show'])->name('show');


    // Validator & Admin (NANTI)
    Route::middleware(['role:validator,admin'])->group(function () {
        Route::get('/{rekonsiliasi}/validasi', [RekonsiliasiController::class, 'validasiForm'])
            ->name('validasi.form');

        Route::post('/{rekonsiliasi}/validasi', [RekonsiliasiController::class, 'validasiStore'])
            ->name('validasi.store');
    });
});
