<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarApiController;
use App\Http\Controllers\Api\BookingApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API routes
Route::prefix('v1')->group(function () {
    // Car listings
    Route::get('/cars', [CarApiController::class, 'index']);
    Route::get('/cars/{car}', [CarApiController::class, 'show']);
    Route::post('/cars/{car}/check-availability', [CarApiController::class, 'checkAvailability']);
    
    // Booking endpoints (public for non-authenticated users)
    Route::post('/cars/{car}/book', [CarApiController::class, 'book']);
});

// Protected API routes
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/bookings', [BookingApiController::class, 'index']);
    Route::get('/bookings/{booking}', [BookingApiController::class, 'show']);
    Route::post('/bookings/{booking}/cancel', [BookingApiController::class, 'cancel']);
});
