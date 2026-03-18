<?php

use App\Http\Controllers\RolePermission\{PermissionController, RoleController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::middleware(['auth', 'role:core|admin'])->group(function () { // Septa
    Route::get('/user', [UserController::class, 'index'])
        ->name('user.index');
    //->middleware('can:view-users')
    Route::post('/user/store', [UserController::class, 'store'])
        ->name('user.store');
    Route::patch('/user/update/{id}', [UserController::class, 'update'])
        ->name('user.update');
});

Route::middleware(['auth', 'role:core'])->group(function () { // Rofi
    Route::resource('permission', PermissionController::class)->except(['create, edit, show']);
    Route::resource('role', RoleController::class)->except(['create, edit, show']);
});

Route::middleware(['auth', 'role:core|admin'])->group(function () { // Rahman
    Route::get('/karyawan', [UserController::class, 'index'])->name('karyawan');
});
