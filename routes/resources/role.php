<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::resource('roles', RoleController::class);
Route::delete('roles/massive-destroy', [RoleController::class, 'massiveDestroy'])->name('roles.massiveDestroy');