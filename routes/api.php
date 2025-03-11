<?php

use App\Http\Controllers\ArenaController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::post('arena', [ArenaController::class, 'store']);
Route::post('arena/{arena}/timeslot', [ArenaController::class, 'createTimeslot']);
Route::post('booking/{timeslot}', [BookingController::class, 'store']);
Route::post('booking/{booking}/confirm', [BookingController::class, 'confirmBooking']);
