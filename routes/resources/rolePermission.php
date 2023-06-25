<?php

use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('roles/{id}')->group(function () {
    Route::resource('assigned-permissions', RolePermissionController::class)->except(['show', 'edit', 'update']);
});
