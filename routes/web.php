<?php

use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('health', HealthCheckResultsController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    require __DIR__.'/resources/profile.php';
    require __DIR__.'/resources/role.php';
    require __DIR__.'/resources/permission.php';
    require __DIR__.'/resources/rolePermission.php';
    require __DIR__.'/resources/lov.php';
    require __DIR__.'/resources/hotel.php';
    require __DIR__.'/resources/process.php';
});
