<?php

use App\Http\Controllers\Public;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('auth/register', \App\Http\Controllers\Auth\RegisterController::class);

Route::post('/login', [\App\Http\Controllers\Auth\RegisterController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('owner')->group(function () {

        // No owner/user grouping, for now, will do it later with more routes
        Route::get(
            'properties',
            [\App\Http\Controllers\Owner\PropertyController::class, 'index']
        );

        Route::post(
            'properties',
            [\App\Http\Controllers\Owner\PropertyController::class, 'store']
        );

        Route::post(
            'properties/{property}/photos',
            [\App\Http\Controllers\Owner\PropertyPhotoController::class, 'store']
        );

        Route::post(
            'properties/{property}/photos/{photo}/reorder/{newPosition}',
            [\App\Http\Controllers\Owner\PropertyPhotoController::class, 'reorder']
        );
    });

    // Route::prefix('user')->group(function () {
    //     Route::get(
    //         'bookings',
    //         [\App\Http\Controllers\User\BookingController::class, 'index']
    //     );
    // });

    Route::prefix('user')->group(function () {
        Route::resource('bookings', \App\Http\Controllers\User\BookingController::class);
    });

    Route::post('/logout', [\App\Http\Controllers\Auth\RegisterController::class, 'logout']);
});

Route::get('search', Public\PropertySearchController::class);
Route::get('properties/{property}', Public\PropertyController::class);
Route::get('apartments/{apartment}', Public\ApartmentController::class);
