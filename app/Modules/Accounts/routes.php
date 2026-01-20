<?php

use Illuminate\Support\Facades\Route;

Route::prefix('apps/accounts')->name('apps.accounts.')->group(function () {
    Route::get('/', [\App\Modules\Accounts\Controllers\AccountAppController::class, 'index'])->name('index');
});
