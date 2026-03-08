<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::resource('clients', ClientController::class);
    Route::resource('proposals', \App\Http\Controllers\ProposalController::class);
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);
    Route::get('invoices/{invoice}/print', [\App\Http\Controllers\InvoiceController::class, 'print'])->name('invoices.print');
    Route::patch('invoices/{invoice}/status', [\App\Http\Controllers\InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');
    Route::resource('payments', \App\Http\Controllers\PaymentController::class);
    Route::resource('payment-modes', \App\Http\Controllers\PaymentModeController::class);
    Route::resource('admin', \App\Http\Controllers\AdminController::class);

    // Universal Settings
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
