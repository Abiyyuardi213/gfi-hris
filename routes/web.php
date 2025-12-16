<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('role/{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('role.toggleStatus');
Route::resource('role', RoleController::class);

Route::resource('kantor', KantorController::class);
Route::post('kantor/{id}/toggle-status', [KantorController::class, 'toggleStatus']);

Route::resource('divisi', DivisiController::class);
Route::post('divisi/{id}/toggle-status', [DivisiController::class, 'toggleStatus']);

Route::post('user/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');
Route::resource('user', UserController::class);

Route::resource('kota', KotaController::class);
