<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcessController;

Route::resource('processes', ProcessController::class)->only('index', 'store', 'show', 'destroy');
