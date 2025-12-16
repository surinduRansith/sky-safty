<?php

use App\Http\Controllers\backupController;


use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\quotationController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\SampleItemOrderController;
use App\Http\Controllers\StockController;
use App\Livewire\BackupButton;
use App\Livewire\CustomerCreateform;
use App\Livewire\StockCreateform;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    
    Route::get('/registration', function () {

        return view('useraccounts.registration');

    })->name('registration.page');
    

    
    Route::resource('stocks', StockController::class);
    Route::get('/quotation', [quotationController::class, 'index'])->name('quotation.create');
    Route::get('/stocks/create',StockCreateform::class)->name('stocks.create');
    Route::resource('customers', CustomerController::class);
    Route::get('/customers/create',CustomerCreateform::class)->name('customer.create');
    Route::get('/report', [reportController::class, 'index'])->name('report.show');
    Route::get('/backup', [backupController::class, 'index'])->name('backup');
    Route::get('/sampleorder', [SampleItemOrderController::class,'index'])->name('sampleorder.show');

    
    Route::resource('orders', OrderController::class);

    Route::get('/users-accounts', function () {

        return view('userlogins');

    })->name('userlogins.page');
    
});

require __DIR__ . '/auth.php';
