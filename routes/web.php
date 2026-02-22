<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SpaOwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/userlogin', [UserController::class, 'showlogin'])->name('userlogin');
Route::post('/userlogin', [UserController::class, 'login'])->name('loginuser');

Route::get('/choose-role', [UserController::class, 'showRoleSelection'])->name('role.selection');
Route::get('/usersignup', [UserController::class, 'showsignup'])->name('usersignup');
Route::post('/usersignup', [UserController::class, 'store'])->name('usersignup.create');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
});

// Spa Owner Routes
Route::middleware(['auth', 'role:spa_owner'])->prefix('spa-owner')->name('spa_owner.')->group(function () {
    Route::get('/dashboard', [SpaOwnerController::class, 'dashboard'])->name('dashboard');
    Route::get('/spas/create', [SpaController::class, 'create'])->name('spas.create');
});

// Spa Routes (public and authenticated)
Route::get('/spas', [SpaController::class, 'index'])->name('spas.index');
Route::get('/spas/{spa}', [SpaController::class, 'show'])->name('spas.show');
Route::post('/spas', [SpaController::class, 'store'])->name('spas.store')->middleware(['auth', 'role:spa_owner']);

// Customer Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
});
