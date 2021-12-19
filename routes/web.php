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

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index'])->name('home')->middleware(['auth']);
Route::get('/login', [\App\Http\Controllers\LoginController::class, 'show'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::prefix('management')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('admin.management.users.index');
            Route::get('/show/{id}', [\App\Http\Controllers\UserController::class, 'show'])->name('admin.management.users.show');
            Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('admin.management.users.create');
            Route::post('/store', [\App\Http\Controllers\UserController::class, 'store'])->name('admin.management.users.store');
            Route::get('/edit/{id}', [\App\Http\Controllers\UserController::class, 'edit'])->name('admin.management.users.edit');
            Route::put('/update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('admin.management.users.update');
        });
        Route::prefix('sites')->group(function () {
            Route::get('/', [\App\Http\Controllers\SiteController::class, 'index'])->name('admin.management.sites.index');
            Route::get('/show/{id}', [\App\Http\Controllers\SiteController::class, 'show'])->name('admin.management.sites.show');
            Route::get('/create', [\App\Http\Controllers\SiteController::class, 'create'])->name('admin.management.sites.create');
            Route::post('/store', [\App\Http\Controllers\SiteController::class, 'store'])->name('admin.management.sites.store');
            Route::get('/edit/{id}', [\App\Http\Controllers\SiteController::class, 'edit'])->name('admin.management.sites.edit');
            Route::put('/update/{id}', [\App\Http\Controllers\SiteController::class, 'update'])->name('admin.management.sites.update');
        });
        Route::prefix('loan_types')->group(function () {
            Route::get('/', [\App\Http\Controllers\LoanTypeController::class, 'index'])->name('admin.management.loan_types.index');
            Route::get('/show/{id}', [\App\Http\Controllers\LoanTypeController::class, 'show'])->name('admin.management.loan_types.show');
            Route::get('/create', [\App\Http\Controllers\LoanTypeController::class, 'create'])->name('admin.management.loan_types.create');
            Route::post('/store', [\App\Http\Controllers\LoanTypeController::class, 'store'])->name('admin.management.loan_types.store');
            Route::get('/edit/{id}', [\App\Http\Controllers\LoanTypeController::class, 'edit'])->name('admin.management.loan_types.edit');
            Route::put('/update/{id}', [\App\Http\Controllers\LoanTypeController::class, 'update'])->name('admin.management.loan_types.update');
        });
        Route::prefix('sub_loan_types')->group(function () {
            Route::get('/', [\App\Http\Controllers\SubLoanTypeController::class, 'index'])->name('admin.management.sub_loan_types.index');
            Route::get('/show/{id}', [\App\Http\Controllers\SubLoanTypeController::class, 'show'])->name('admin.management.sub_loan_types.show');
            Route::get('/create', [\App\Http\Controllers\SubLoanTypeController::class, 'create'])->name('admin.management.sub_loan_types.create');
            Route::post('/store', [\App\Http\Controllers\SubLoanTypeController::class, 'store'])->name('admin.management.sub_loan_types.store');
            Route::get('/edit/{id}', [\App\Http\Controllers\SubLoanTypeController::class, 'edit'])->name('admin.management.sub_loan_types.edit');
            Route::put('/update/{id}', [\App\Http\Controllers\SubLoanTypeController::class, 'update'])->name('admin.management.sub_loan_types.update');
        });

        Route::prefix('monthly_saving')->group(function () {
            Route::get('/edit', [\App\Http\Controllers\MonthlySavingController::class, 'edit'])->name('admin.management.monthly_saving.edit');
            Route::put('/update', [\App\Http\Controllers\MonthlySavingController::class, 'update'])->name('admin.management.monthly_saving.update');
        });
    });
});
