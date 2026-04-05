<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SpaOwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SpaController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SpaCategoryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::get('/about', function () {
    return view('about');
})->name('about');

// Experiences Page
Route::get('/experiences', function () {
    return view('experiences');
})->name('experiences');

// Treatment Pages
Route::get('/treatments/celestial-floatation', function () {
    return view('treatments.celestial-floatation');
})->name('treatment.celestial-floatation');

Route::get('/treatments/mud-ritual', function () {
    return view('treatments.mud-ritual');
})->name('treatment.mud-ritual');

Route::get('/treatments/hydromassage', function () {
    return view('treatments.hydromassage');
})->name('treatment.hydromassage');

Route::get('/userlogin', [UserController::class, 'showlogin'])->name('userlogin');
Route::post('/userlogin', [UserController::class, 'login'])->name('loginuser');

Route::get('/choose-role', [UserController::class, 'showRoleSelection'])->name('role.selection');
Route::get('/usersignup', [UserController::class, 'showsignup'])->name('usersignup');
Route::post('/usersignup', [UserController::class, 'store'])->name('usersignup.create');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
    Route::get('/spa-owners', [AdminController::class, 'spaOwners'])->name('spa_owners');
    Route::get('/spa-owners/{user}', [AdminController::class, 'showSpaOwner'])->name('spa_owner_show');
    Route::post('/spas/{spa}/approve', [AdminController::class, 'approveSpa'])->name('spa.approve');
    Route::post('/spas/{spa}/disapprove', [AdminController::class, 'disapproveSpa'])->name('spa.disapprove');
    Route::get('/services', [AdminController::class, 'services'])->name('services');

    // Spa Categories CRUD
    Route::get('/categories', [SpaCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [SpaCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [SpaCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{spaCategory}/edit', [SpaCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{spaCategory}', [SpaCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{spaCategory}', [SpaCategoryController::class, 'destroy'])->name('categories.destroy');
});

// Spa Owner Routes
Route::middleware(['auth', 'role:spa_owner'])->prefix('spa-owner')->name('spa_owner.')->group(function () {
    Route::get('/dashboard', [SpaOwnerController::class, 'dashboard'])->name('dashboard');

    // Spa management
    Route::get('/spas/create', [SpaController::class, 'create'])->name('spas.create');
    Route::get('/spa/edit', [SpaOwnerController::class, 'editSpa'])->name('spa.edit');
    Route::put('/spa', [SpaOwnerController::class, 'updateSpa'])->name('spa.update');

    // Services CRUD
    Route::get('/services', [SpaOwnerController::class, 'services'])->name('services');
    Route::get('/services/create', [SpaOwnerController::class, 'createService'])->name('services.create');
    Route::post('/services', [SpaOwnerController::class, 'storeService'])->name('services.store');
    Route::get('/services/{service}/edit', [SpaOwnerController::class, 'editService'])->name('services.edit');
    Route::put('/services/{service}', [SpaOwnerController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{service}', [SpaOwnerController::class, 'destroyService'])->name('services.destroy');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'ownerBookings'])->name('bookings');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');

    // Other pages
    Route::get('/payments', [SpaOwnerController::class, 'payments'])->name('payments');
    Route::get('/reviews', [SpaOwnerController::class, 'reviews'])->name('reviews');
    Route::get('/customers', [SpaOwnerController::class, 'customers'])->name('customers');
    Route::get('/settings', [SpaOwnerController::class, 'settings'])->name('settings');
    Route::put('/settings', [SpaOwnerController::class, 'updateSettings'])->name('settings.update');
});

// Spa Routes (public and authenticated)
Route::get('/spas', [SpaController::class, 'index'])->name('spas.index');
Route::get('/spas/{spa}', [SpaController::class, 'show'])->name('spas.show');
Route::post('/spas', [SpaController::class, 'store'])->name('spas.store')->middleware(['auth', 'role:spa_owner']);

// Customer Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/services', [CustomerController::class, 'services'])->name('services');
    Route::get('/bookings', [BookingController::class, 'myBookings'])->name('bookings');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Booking submission (customer only)
Route::post('/spas/{spa}/book', [BookingController::class, 'store'])
    ->name('bookings.store')
    ->middleware(['auth', 'role:customer']);

// Payment routes (customer only) — static routes BEFORE the dynamic {booking} route
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/payment/esewa/check', [PaymentController::class, 'check'])->name('esewa.check');
    Route::post('/payment/{booking}/choose-at-spa', [PaymentController::class, 'choosePayAtSpa'])->name('payment.chooseAtSpa');
    Route::get('/payment/{booking}/pay', [PaymentController::class, 'pay'])->name('payment.pay');
});

// Review routes (customer only)
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::post('/spas/{spa}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/spas/{spa}/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
