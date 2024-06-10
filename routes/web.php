<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CashFlowController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/manage-user', [ProfileController::class, 'manageUser'])->name('users.manage');


    Route::get('/', [CashFlowController::class, 'index'])->name('dashboard');
    // Routes for handling cash masuk (incoming cash)
    Route::get('/kas-masuk', [CashFlowController::class, 'createMasuk'])->name('cashflows.createMasuk');
    Route::post('/kas-masuk', [CashFlowController::class, 'storeMasuk'])->name('cashflows.storeMasuk');

    // Routes for handling cash keluar (outgoing cash)
    Route::get('/kas-keluar', [CashFlowController::class, 'createKeluar'])->name('cashflows.createKeluar');
    Route::post('/kas-keluar', [CashFlowController::class, 'storeKeluar'])->name('cashflows.storeKeluar');

    //route kas group
    Route::get('/kas-masuk-group', [CashFlowController::class, 'showGroup'])->name('cashflows.group');
    Route::get('/lap-akun', [CashFlowController::class, 'showReport'])->name('report');

    //kelola kas
    Route::get('/jenis-kas', [CashFlowController::class, 'manageTypeCash']);
    Route::post('/store-jenis-kas', [CashFlowController::class, 'storeTypeCash'])->name('typecash.store');

    // route Invoice
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
});




require __DIR__ . '/auth.php';
