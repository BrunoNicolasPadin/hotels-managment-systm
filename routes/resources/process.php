<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcessController;

Route::resource('process', ProcessController::class)->only('index', 'store', 'show');
