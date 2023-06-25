<?php

use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('roles/{id}')->group(function () {
    Route::resource('permissions', PermissionController::class)->except(['show']);
});
