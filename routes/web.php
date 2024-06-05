<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CashFlowController;
use App\Http\Controllers\JenisUangMasukController;

// Route for displaying the cash flow index
Route::get('/', [CashFlowController::class, 'index'])->name('cashflows.index');

// Routes for handling cash masuk (incoming cash)
Route::get('/kas-masuk', [CashFlowController::class, 'createMasuk'])->name('cashflows.createMasuk');
Route::post('/kas-masuk', [CashFlowController::class, 'storeMasuk'])->name('cashflows.storeMasuk');

// Routes for handling cash keluar (outgoing cash)
Route::get('/kas-keluar', [CashFlowController::class, 'createKeluar'])->name('cashflows.createKeluar');
Route::post('/kas-keluar', [CashFlowController::class, 'storeKeluar'])->name('cashflows.storeKeluar');

//route kas group
Route::get('/kas-masuk-group', [CashFlowController::class, 'showGroup'])->name('cashflows.group');
Route::get('/lap-akun', [CashFlowController::class, 'showReport'])->name('report');

// route Invoice
Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoices.index');
Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');

// jenis uang masuk
// Route::post('/jenis-uang-masuk', [JenisUangMasukController::class, 'store'])->name('jenis-uang-masuk.store');
// Route::get('/lap-akun', function () {
//     return view('lap-akun');
// });

// Route::get('/invoice', function () {
//     return view('invoice');
// });
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
