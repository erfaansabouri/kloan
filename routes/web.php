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

Route::get('/user-loans-export', [\App\Http\Controllers\Controller::class, 'userLoanExport'])->name('export.user_loan');
Route::get('/all-user-loans-export', [\App\Http\Controllers\Controller::class, 'allUserLoansExport'])->name('export.all_user_loans');
Route::get('/user-loan-types-export', [\App\Http\Controllers\Controller::class, 'userLoanTypesExport'])->name('export.user_loan_types');


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
        Route::prefix('user_loan')->group(function () {
            Route::get('/', [\App\Http\Controllers\UserLoanController::class, 'index'])->name('admin.management.user_loan.index');
            Route::get('/completed', [\App\Http\Controllers\UserLoanController::class, 'completedIndex'])->name('admin.management.user_loan.completed_index');
            Route::get('/total-received-loans', [\App\Http\Controllers\UserLoanController::class, 'totalReceivedLoans'])->name('admin.management.user_loan.total_received_loans');
            Route::get('/two-month-diff', [\App\Http\Controllers\UserLoanController::class, 'twoMonthDiff'])->name('admin.management.user_loan.two_month_diff');
            Route::get('/create', [\App\Http\Controllers\UserLoanController::class, 'create'])->name('admin.management.user_loan.create');
            Route::post('/store', [\App\Http\Controllers\UserLoanController::class, 'store'])->name('admin.management.user_loan.store');
            Route::get('/show/{id}', [\App\Http\Controllers\UserLoanController::class, 'show'])->name('admin.management.user_loan.show');
            Route::get('/edit/{id}', [\App\Http\Controllers\UserLoanController::class, 'edit'])->name('admin.management.user_loan.edit');
            Route::put('/update/{id}', [\App\Http\Controllers\UserLoanController::class, 'update'])->name('admin.management.user_loan.update');
            Route::put('/archive/{id}', [\App\Http\Controllers\UserLoanController::class, 'archive'])->name('admin.management.user_loan.archive');
        });
        Route::prefix('installments')->group(function () {
            Route::get('kosroorat', [\App\Http\Controllers\InstallmentController::class, 'kosoorat'])->name('admin.management.installments.kosoorat');
            Route::get('receive-from-all-users', [\App\Http\Controllers\InstallmentController::class, 'receiveInstallmentsOfAllUsersCreate'])->name('admin.management.installments.receive_from_all_users_create');
            Route::post('receive-from-all-users', [\App\Http\Controllers\InstallmentController::class, 'receiveInstallmentsOfAllUsersStore'])->name('admin.management.installments.receive_from_all_users_store');
            Route::delete('destroy/{id}', [\App\Http\Controllers\InstallmentController::class, 'destroy'])->name('admin.management.installments.destroy');
            Route::get('edit/{id}', [\App\Http\Controllers\InstallmentController::class, 'edit'])->name('admin.management.installments.edit');
            Route::put('update/{id}', [\App\Http\Controllers\InstallmentController::class, 'update'])->name('admin.management.installments.update');
        });
        Route::prefix('savings')->group(function () {
            Route::get('receive-from-all-users', [\App\Http\Controllers\SavingController::class, 'receiveFromAllUsersCreate'])->name('admin.management.savings.receive_from_all_users_create');
            Route::post('receive-from-all-users', [\App\Http\Controllers\SavingController::class, 'receiveFromAllUsersStore'])->name('admin.management.savings.receive_from_all_users_store');
            Route::get('user', [\App\Http\Controllers\SavingController::class, 'user'])->name('admin.management.savings.user');
            Route::get('edit/{id}', [\App\Http\Controllers\SavingController::class, 'edit'])->name('admin.management.savings.edit');
            Route::put('update/{id}', [\App\Http\Controllers\SavingController::class, 'update'])->name('admin.management.savings.update');
        });
    });
});
