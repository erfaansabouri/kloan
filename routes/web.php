<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index'])->name('home');
Route::prefix('admin')->group(function () {
    Route::prefix('management')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('admin.management.users.index');
            Route::get('/show/{id}', [\App\Http\Controllers\UserController::class, 'show'])->name('admin.management.users.show');
            Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('admin.management.users.create');
            Route::post('/store', [\App\Http\Controllers\UserController::class, 'store'])->name('admin.management.users.store');
            Route::get('/edit/{id}', [\App\Http\Controllers\UserController::class, 'edit'])->name('admin.management.users.edit');
            Route::put('/update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('admin.management.users.update');
        });
    });
});
