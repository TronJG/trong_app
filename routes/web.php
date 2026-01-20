<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Trang chính
Route::get('/', [DashboardController::class, 'index'])->name('home');

// App: Quản lí tài khoản (module)
Route::prefix('apps/accounts')->name('apps.accounts.')->group(function () {
    Route::get('/', [\App\Modules\Accounts\Controllers\AccountAppController::class, 'index'])->name('index');
});

Route::prefix('apps/accounts')->name('apps.accounts.')->group(function () {
    Route::get('/', [\App\Modules\Accounts\Controllers\GameAccountController::class, 'index'])->name('index');
    Route::get('/create', [\App\Modules\Accounts\Controllers\GameAccountController::class, 'create'])->name('create');
    Route::post('/', [\App\Modules\Accounts\Controllers\GameAccountController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [\App\Modules\Accounts\Controllers\GameAccountController::class, 'edit'])->name('edit');
    Route::post('/{id}', [\App\Modules\Accounts\Controllers\GameAccountController::class, 'update'])->name('update');

    Route::post('/{id}/toggle-changed', [\App\Modules\Accounts\Controllers\GameAccountController::class, 'toggleChanged'])->name('toggle');
    Route::post('/{id}/delete', [\App\Modules\Accounts\Controllers\GameAccountController::class, 'destroy'])->name('delete');

    // View nhanh: acc đến hạn đổi số nhưng chưa đổi
    Route::get('/due', [\App\Modules\Accounts\Controllers\GameAccountController::class, 'due'])->name('due');
});
Route::prefix('apps/finance')->name('apps.finance.')->group(function () {
    Route::get('/', [\App\Modules\Finance\Controllers\FinanceController::class, 'index'])->name('index'); // xem tháng hiện tại
    Route::get('/month/{ym}', [\App\Modules\Finance\Controllers\FinanceController::class, 'month'])->name('month'); // xem tháng cũ
    Route::get('/create', [\App\Modules\Finance\Controllers\FinanceController::class, 'create'])->name('create');
    Route::post('/', [\App\Modules\Finance\Controllers\FinanceController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [\App\Modules\Finance\Controllers\FinanceController::class, 'edit'])->name('edit');
    Route::post('/{id}', [\App\Modules\Finance\Controllers\FinanceController::class, 'update'])->name('update');

    Route::post('/{id}/delete', [\App\Modules\Finance\Controllers\FinanceController::class, 'destroy'])->name('delete');
});
Route::prefix('apps/consignment')->name('apps.consignment.')->group(function () {
    Route::get('/', [\App\Modules\Consignment\Controllers\ConsignmentController::class, 'index'])->name('index');
    Route::get('/create', [\App\Modules\Consignment\Controllers\ConsignmentController::class, 'create'])->name('create');
    Route::post('/', [\App\Modules\Consignment\Controllers\ConsignmentController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [\App\Modules\Consignment\Controllers\ConsignmentController::class, 'edit'])->name('edit');
    Route::post('/{id}', [\App\Modules\Consignment\Controllers\ConsignmentController::class, 'update'])->name('update');
    Route::post('/{id}/delete', [\App\Modules\Consignment\Controllers\ConsignmentController::class, 'destroy'])->name('delete');

    // Export
    Route::post('/export/txt', [\App\Modules\Consignment\Controllers\ConsignmentController::class, 'exportTxt'])->name('export.txt');
    Route::post('/export/images', [\App\Modules\Consignment\Controllers\ConsignmentController::class, 'exportImages'])->name('export.images');
});

