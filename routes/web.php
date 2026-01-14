<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/userlogin', [UserController::class, 'showlogin'])->name('userlogin');
Route::post('/userlogin', [UserController::class, 'login'])->name('loginuser');

Route::get('/usersignup', [UserController::class, 'showsignup'])->name('usersignup');
Route::post('/usersignup', [UserController::class, 'store'])->name('usersignup.create');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');