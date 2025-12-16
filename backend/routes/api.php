<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('guests', GuestController::class);
Route::apiResource('bookings', BookingController::class);

Route::get('/bookings/{id}/guests', [BookingController::class,'getGuests']);



