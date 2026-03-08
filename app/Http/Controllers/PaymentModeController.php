<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentModes = \App\Models\PaymentMode::all();
        return view('payment_modes.index', compact('paymentModes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        \App\Models\PaymentMode::create($validated);

        return redirect()->route('payment_modes.index')->with('success', 'Payment mode created successfully.');
    }

    public function update(Request $request, \App\Models\PaymentMode $paymentMode)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $paymentMode->update($validated);

        return redirect()->route('payment_modes.index')->with('success', 'Payment mode updated successfully.');
    }

    public function destroy(\App\Models\PaymentMode $paymentMode)
    {
        $paymentMode->delete();
        return redirect()->route('payment_modes.index')->with('success', 'Payment mode deleted successfully.');
    }
}
