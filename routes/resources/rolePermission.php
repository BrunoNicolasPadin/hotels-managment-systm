<?php

use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('roles/{id}/assigned-permissions')->group(function () {
    Route::resource('assigned-permissions', PermissionController::class)->except(['show', 'edit', 'update']);
});

