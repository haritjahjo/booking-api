<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Owner\PropertyController;

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

Route::post('auth/register', RegisterController::class);

Route::middleware('auth:sanctum')->group(function() {
    // No owner/user grouping, for now, will do it later with more routes
    Route::get('owner/properties',
        [PropertyController::class, 'index']);
    Route::get('user/bookings',
        [BookingController::class, 'index']);
});