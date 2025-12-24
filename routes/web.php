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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShiftKerjaController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PengajuanIzinController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\LemburController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('login.attempt');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // === COMMON / SHARED ===
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // Shared Features with policy logic inside Controller
    Route::get('presensi/summary', [PresensiController::class, 'summary'])->name('presensi.summary');
    Route::get('pengajuan-izin', [PengajuanIzinController::class, 'index'])->name('pengajuan-izin.index');
    Route::get('lembur', [LemburController::class, 'index'])->name('lembur.index');
    Route::delete('lembur/{id}', [LemburController::class, 'destroy'])->name('lembur.destroy'); // Shared delete (own pending / admin any)

    // === ADMIN ===
    Route::middleware(['role:Super Admin,Admin'])->group(function () {

        // Masters
        Route::post('role/{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('role.toggleStatus');
        Route::resource('role', RoleController::class);

        Route::post('user/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');
        Route::resource('user', UserController::class);

        Route::post('kantor/{id}/toggle-status', [KantorController::class, 'toggleStatus'])->name('kantor.toggleStatus');
        Route::resource('kantor', KantorController::class);

        Route::post('divisi/{id}/toggle-status', [DivisiController::class, 'toggleStatus'])->name('divisi.toggleStatus');
        Route::resource('divisi', DivisiController::class);

        Route::post('jabatan/{id}/toggle-status', [JabatanController::class, 'toggleStatus'])->name('jabatan.toggleStatus');
        Route::resource('jabatan', JabatanController::class);

        Route::post('divisi-jabatan/{id}/toggle-status', [DivisiJabatanController::class, 'toggleStatus'])->name('divisi-jabatan.toggleStatus');
        Route::resource('divisi-jabatan', DivisiJabatanController::class);

        Route::post('status-pegawai/{id}/toggle-status', [StatusPegawaiController::class, 'toggleStatus'])->name('status-pegawai.toggle-status');
        Route::resource('status-pegawai', StatusPegawaiController::class);

        Route::resource('kota', KotaController::class);
        Route::resource('pegawai', PegawaiController::class);

        Route::post('shift-kerja/{id}/toggle-status', [ShiftKerjaController::class, 'toggleStatus'])->name('shift-kerja.toggleStatus');
        Route::resource('shift-kerja', ShiftKerjaController::class);

        Route::resource('hari-libur', HariLiburController::class);

        // Admin Log View
        Route::get('presensi', [PresensiController::class, 'index'])->name('presensi.index');
        Route::put('presensi/{id}', [PresensiController::class, 'update'])->name('presensi.update');

        // Approval
        Route::post('pengajuan-izin/{id}/approve', [PengajuanIzinController::class, 'approve'])->name('pengajuan-izin.approve');
        Route::post('pengajuan-izin/{id}/reject', [PengajuanIzinController::class, 'reject'])->name('pengajuan-izin.reject');

        Route::post('lembur/{id}/approve', [LemburController::class, 'approve'])->name('lembur.approve');
        Route::post('lembur/{id}/reject', [LemburController::class, 'reject'])->name('lembur.reject');
    });

    // === PEGAWAI ===
    Route::middleware(['role:Pegawai'])->group(function () {
        // Absensi Features
        Route::get('presensi/create', [PresensiController::class, 'create'])->name('presensi.create');
        Route::post('presensi', [PresensiController::class, 'store'])->name('presensi.store');
        Route::post('presensi/checkout', [PresensiController::class, 'checkOut'])->name('presensi.checkOut');

        // Pengajuan Create
        Route::get('pengajuan-izin/create', [PengajuanIzinController::class, 'create'])->name('pengajuan-izin.create');
        Route::post('pengajuan-izin', [PengajuanIzinController::class, 'store'])->name('pengajuan-izin.store');

        Route::get('lembur/create', [LemburController::class, 'create'])->name('lembur.create');
        Route::post('lembur', [LemburController::class, 'store'])->name('lembur.store');
    });
});
