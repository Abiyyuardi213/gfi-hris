<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\DivisiJabatanController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusPegawaiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('role/{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('role.toggleStatus');
Route::resource('role', RoleController::class);

Route::post(
    'status-pegawai/{id}/toggle-status',
    [StatusPegawaiController::class, 'toggleStatus']
)->name('status-pegawai.toggle-status');
Route::resource('status-pegawai', StatusPegawaiController::class);

Route::post('divisi-jabatan/{id}/toggle-status', [DivisiJabatanController::class, 'toggleStatus'])->name('divisi-jabatan.toggleStatus');
Route::resource('divisi-jabatan', DivisiJabatanController::class);

Route::post('kantor/{id}/toggle-status', [KantorController::class, 'toggleStatus'])->name('kantor.toggleStatus');
Route::resource('kantor', KantorController::class);

Route::post('divisi/{id}/toggle-status', [DivisiController::class, 'toggleStatus'])->name('divisi.toggleStatus');
Route::resource('divisi', DivisiController::class);

Route::post('jabatan/{id}/toggle-status', [JabatanController::class, 'toggleStatus'])->name('jabatan.toggleStatus');
Route::resource('jabatan', JabatanController::class);

Route::post('user/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');
Route::resource('user', UserController::class);

Route::resource('kota', KotaController::class);
