<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\PaymentMode;
use App\DataTables\PaymentDataTable;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index(PaymentDataTable $dataTable)
    {
        return $dataTable->render('payments.index');
    }

    public function print(Payment $payment)
    {
        $payment->load(['client', 'invoice']);
        $pdf = Pdf::loadView('payments.print', compact('payment'));
        return $pdf->download('Payment_' . $payment->number . '.pdf');
    }

    public function create()
    {
        $clients = Client::where('removed', false)->get();
        $invoices = Invoice::where('status', '!=', 'paid')->get();
        $paymentModes = PaymentMode::where('enabled', true)->get();
        return view('payments.create', compact('clients', 'invoices', 'paymentModes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|unique:payments,number',
            'invoice_id' => 'required|exists:invoices,id',
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_mode' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $payment = Payment::create([
            'number' => $validated['number'],
            'invoice_id' => $validated['invoice_id'],
            'client_id' => $validated['client_id'],
            'date' => $validated['date'],
            'amount' => $validated['amount'],
            'payment_mode' => $validated['payment_mode'],
            'notes' => $validated['notes'],
            'created_by' => auth()->id(),
        ]);

        // Update invoice paid amount and status
        $invoice = Invoice::find($validated['invoice_id']);
        $invoice->paid += $validated['amount'];

        if ($invoice->paid >= $invoice->total) {
            $invoice->status = 'paid';
        } elseif ($invoice->paid > 0) {
            $invoice->status = 'partially';
        }

        $invoice->save();

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['client', 'invoice']);
        return view('payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        // Revert invoice paid amount
        $invoice = $payment->invoice;
        $invoice->paid -= $payment->amount;

        if ($invoice->paid <= 0) {
            $invoice->status = 'pending';
        } elseif ($invoice->paid < $invoice->total) {
            $invoice->status = 'partially';
        }
        $invoice->save();

        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
