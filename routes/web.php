<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupplierController;

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Profile routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::put('/profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.settings.update');
});

// Public routes
Route::get('/', function () {
    return redirect()->route('cars.index');
});

// Admin routes (protected by admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Supplier management
    Route::get('/suppliers', [AdminController::class, 'suppliers'])->name('suppliers');
    Route::get('/suppliers/create', [AdminController::class, 'createSupplier'])->name('suppliers.create');
    Route::post('/suppliers', [AdminController::class, 'storeSupplier'])->name('suppliers.store');
    Route::get('/suppliers/{supplier}/edit', [AdminController::class, 'editSupplier'])->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', [AdminController::class, 'updateSupplier'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [AdminController::class, 'deleteSupplier'])->name('suppliers.delete');
    
    // Car management
    Route::get('/cars', [AdminController::class, 'cars'])->name('cars');
    Route::get('/cars/create', [AdminController::class, 'createCar'])->name('cars.create');
    Route::post('/cars', [AdminController::class, 'storeCar'])->name('cars.store');
    Route::get('/cars/{car}/edit', [AdminController::class, 'editCar'])->name('cars.edit');
    Route::put('/cars/{car}', [AdminController::class, 'updateCar'])->name('cars.update');
    Route::delete('/cars/{car}', [AdminController::class, 'deleteCar'])->name('cars.delete');
    Route::post('/cars/{car}/approve', [AdminController::class, 'approveCar'])->name('cars.approve');
    Route::post('/cars/{car}/reject', [AdminController::class, 'rejectCar'])->name('cars.reject');
    
    // Booking management
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::put('/bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.update-status');
});

// Supplier routes (protected by supplier middleware)
Route::middleware(['auth', 'supplier'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/dashboard', [SupplierController::class, 'dashboard'])->name('dashboard');
    
    // Car management
    Route::get('/cars', [SupplierController::class, 'cars'])->name('cars');
    Route::get('/cars/create', [SupplierController::class, 'createCar'])->name('cars.create');
    Route::post('/cars', [SupplierController::class, 'storeCar'])->name('cars.store');
    Route::get('/cars/{car}/edit', [SupplierController::class, 'editCar'])->name('cars.edit');
    Route::put('/cars/{car}', [SupplierController::class, 'updateCar'])->name('cars.update');
    Route::delete('/cars/{car}', [SupplierController::class, 'deleteCar'])->name('cars.delete');
    
    // Booking management
    Route::get('/bookings', [SupplierController::class, 'bookings'])->name('bookings');
    Route::put('/bookings/{booking}/status', [SupplierController::class, 'updateBookingStatus'])->name('bookings.update-status');
    
    // Availability check
    Route::post('/check-availability', [SupplierController::class, 'checkAvailability'])->name('check-availability');
    Route::get('/availability/calendar', [SupplierController::class, 'availabilityCalendar'])->name('availability.calendar');
    Route::get('/availability/data', [SupplierController::class, 'getAvailabilityData'])->name('availability.data');
});

// Public routes
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
Route::post('/cars/{car}/book', [CarController::class, 'book'])->name('cars.book');
Route::post('/cars/{car}/check-availability', [CarController::class, 'checkAvailability'])->name('cars.check-availability');
