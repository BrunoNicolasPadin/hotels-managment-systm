<?php

use App\Http\Controllers\LovController;
use Illuminate\Support\Facades\Route;

Route::resource('lovs', LovController::class)->except(['show']);
