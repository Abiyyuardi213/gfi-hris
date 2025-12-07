<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('role/{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('role.toggleStatus');
Route::resource('role', RoleController::class);
