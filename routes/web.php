<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CashFlowController;
use App\Http\Controllers\BcaCashflowController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/manage-user', [ProfileController::class, 'manageUser'])->name('users.manage');
    Route::get('/edit-user/{id}', [ProfileController::class, 'editUser'])->name('user.edit');
    Route::put('/update-user/{id}', [ProfileController::class, 'updateUser'])->name('user.update');
    Route::delete('/delete-user/{id}', [ProfileController::class, 'destroyUser'])->name('user.destroy');


    Route::get('/', [CashFlowController::class, 'index'])->name('dashboard');
    Route::get('/cash-flow', [CashFlowController::class, 'cashflow'])->name('cashflow');
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

    //bca cashflow
    Route::get('/bca_cashflows', [BcaCashflowController::class, 'index'])->name('bca_cashflows.index');
    Route::get('/kas-masuk-bca', [BcaCashflowController::class, 'createMasuk'])->name('bca_cashflows.createMasuk');
    Route::post('/kas-masuk-bca', [BcaCashflowController::class, 'storeMasuk'])->name('bca_cashflows.storeMasuk');
    Route::get('/kas-keluar-bca', [BcaCashflowController::class, 'createKeluar'])->name('bca_cashflows.createKeluar');
    Route::post('/kas-keluar-bca', [BcaCashflowController::class, 'storeKeluar'])->name('bca_cashflows.storeKeluar');
    Route::get('/bca-cashflows', [BcaCashflowController::class, 'index'])->name('bca_cashflows.index');
    Route::get('/bca-cashflows/upload', [BcaCashflowController::class, 'BcaCashFlowsUpload'])->name('bca_cashflows.upload');
    Route::post('/bca-cashflows/import', [BcaCashflowController::class, 'BcaCashFlowsImport'])->name('bca_cashflows.import');
    Route::get('/bca-cash-type', [BcaCashflowController::class, 'CashType'])->name('bca_cashflows.type');
    Route::post('/bca-cash-type/add', [BcaCashflowController::class, 'CashTypeStore'])->name('bca_cashflows.type.store');
    Route::delete('/bca-cash-type/delete/{id}', [BcaCashflowController::class, 'CashTypeDestroy'])->name('bca_cashflows.type.destroy');
    Route::post('/bca-cash-type/import', [BcaCashflowController::class, 'CashTypeImport'])->name('bca_cashflows.type.import');
    Route::get('/bca-cash-type/edit/{id}', [BcaCashflowController::class, 'CashTypeEdit'])->name('bca_cashflows.type.edit');
    Route::put('/bca-cash-type/update/{id}', [BcaCashflowController::class, 'CashTypeUpdate'])->name('bca_cashflows.type.update');
});




require __DIR__ . '/auth.php';
