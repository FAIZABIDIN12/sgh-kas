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
    Route::get('/edit-user/{id}', [ProfileController::class, 'editUser'])->name('user.edit');
    Route::put('/update-user/{id}', [ProfileController::class, 'updateUser'])->name('user.update');
    Route::delete('/delete-user/{id}', [ProfileController::class, 'destroyUser'])->name('user.destroy');


    Route::get('/', [CashFlowController::class, 'index'])->name('dashboard');
    Route::get('/edit-cash-flow/{id}', [CashFlowController::class, 'editCashFlow'])->name('cashFlow.edit');
    Route::put('/update-cash-flow/{id}', [CashFlowController::class, 'updateCashFlow'])->name('cashFlow.update');
    Route::delete('/delete-cash-flow/{id}', [CashFlowController::class, 'destroyCashFlow'])->name('cashFlow.destroy');
    // Routes for handling cash masuk (incoming cash)
    Route::get('/kas-masuk', [CashFlowController::class, 'createMasuk'])->name('cashflows.createMasuk');
    Route::post('/kas-masuk', [CashFlowController::class, 'storeMasuk'])->name('cashflows.storeMasuk');

    // Routes for handling cash keluar (outgoing cash)
    Route::get('/kas-keluar', [CashFlowController::class, 'createKeluar'])->name('cashflows.createKeluar');
    Route::post('/kas-keluar', [CashFlowController::class, 'storeKeluar'])->name('cashflows.storeKeluar');

    Route::get('/form-import-cashflow', [CashFlowController::class, 'formImportCashflow'])->name('cashflows.formImport');
    Route::post('/import-cashflow-excel', [CashFlowController::class, 'importCashFlow'])->name('cashflows.import');

    //route kas group
    Route::get('/kas-masuk-group', [CashFlowController::class, 'showGroup'])->name('cashflows.group');
    Route::get('/lap-akun', [CashFlowController::class, 'showReport'])->name('report');

    //kelola kas
    Route::get('/jenis-kas', [CashFlowController::class, 'manageTypeCash'])->name('typecash');
    Route::post('/store-jenis-kas', [CashFlowController::class, 'storeTypeCash'])->name('typecash.store');
    Route::get('/edit-jenis-kas/{id}', [CashFlowController::class, 'editTypeCash'])->name('typecash.edit');
    Route::put('/update-jenis-kas/{id}', [CashFlowController::class, 'updateTypeCash'])->name('typecash.update');
    Route::delete('/delete-jenis-kas/{id}', [CashFlowController::class, 'destroyTypeCash'])->name('typecash.destroy');
    Route::post('/import-excel', [CashFlowController::class, 'importCashType'])->name('typecash.import');

    // route Invoice
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::post('invoices/import', [InvoiceController::class, 'import'])->name('invoices.import');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
});




require __DIR__ . '/auth.php';
