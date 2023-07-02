<?php

use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Route;

Route::resource('hotels', HotelController::class);
Route::put('hotels/{id}/restore', [HotelController::class, 'restore'])->name('hotels.restore');
