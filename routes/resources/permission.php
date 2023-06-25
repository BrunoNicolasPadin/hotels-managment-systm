<?php

use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::resource('permissions', PermissionController::class)->except(['show']);