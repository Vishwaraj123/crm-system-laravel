<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    $stats = [
        'clients' => \App\Models\Client::count(),
        'leads' => \App\Models\Lead::count(),
        'proposals' => \App\Models\Proposal::count(),
        'payments' => \App\Models\Payment::count(),
        'payment_modes' => \App\Models\PaymentMode::count(),
        'recent_proposals' => \App\Models\Proposal::with('client')->latest()->take(5)->get(),
        'recent_leads' => \App\Models\Lead::latest()->take(5)->get(),
    ];
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::resource('clients', ClientController::class);
    Route::resource('leads', LeadController::class);
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
