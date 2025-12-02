<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\MotherController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\GrowthStandardController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\GrowthChartController;
use App\Http\Controllers\UserController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Resources dengan middleware role (uncomment saat production)
    // Route::middleware(['role:admin,puskesmas,kader'])->group(function () {
    Route::resource('posyandu', PosyanduController::class);
    Route::resource('mothers', MotherController::class);
    Route::resource('children', ChildController::class);
    Route::resource('measurements', MeasurementController::class);
    Route::resource('users', UserController::class);

    // Growth chart (WHO) per anak
    Route::get('/children/{child}/growth-chart', [GrowthChartController::class, 'show'])->name('growth-chart.show');

    // Recipes - semua user bisa lihat
    Route::resource('recipes', RecipeController::class)->only(['index', 'show']);

    // Recipes management - hanya admin dan puskesmas
    Route::middleware(['role:admin,puskesmas'])->group(function () {
        Route::resource('recipes', RecipeController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    });

    Route::resource('growth-standards', GrowthStandardController::class)->only(['index', 'show']);
    // });
});

// Offline page (accessible without auth)
Route::view('/offline', 'offline')->name('offline');
