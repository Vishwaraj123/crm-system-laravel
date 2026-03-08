<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Setting;
use App\DataTables\InvoiceDataTable;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(InvoiceDataTable $dataTable)
    {
        return $dataTable->render('invoices.index');
    }

    public function create()
    {
        $clients = Client::where('removed', false)->get();
        return view('invoices.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'number' => 'required|string|unique:invoices,number',
            'date' => 'required|date',
            'expired_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.itemName' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $subTotal = 0;
        foreach ($validated['items'] as $item) {
            $subTotal += $item['quantity'] * $item['price'];
        }

        $taxTotal = $subTotal * ($validated['tax_rate'] / 100);
        $total = $subTotal + $taxTotal;

        $invoice = Invoice::create([
            'client_id' => $validated['client_id'],
            'number' => $validated['number'],
            'year' => date('Y', strtotime($validated['date'])),
            'date' => $validated['date'],
            'expired_date' => $validated['expired_date'],
            'tax_rate' => $validated['tax_rate'],
            'sub_total' => $subTotal,
            'tax_total' => $taxTotal,
            'total' => $total,
            'currency' => Setting::get('default_currency', 'USD'),
            'status' => 'draft',
            'notes' => $validated['notes'],
            'created_by' => auth()->id(),
        ]);

        foreach ($validated['items'] as $item) {
            $invoice->items()->create([
                'itemName' => $item['itemName'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'items', 'payments']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $clients = Client::where('removed', false)->get();
        $invoice->load('items');
        return view('invoices.edit', compact('invoice', 'clients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'number' => 'required|string|unique:invoices,number,' . $invoice->id,
            'date' => 'required|date',
            'expired_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.itemName' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $subTotal = 0;
        foreach ($validated['items'] as $item) {
            $subTotal += $item['quantity'] * $item['price'];
        }

        $taxTotal = $subTotal * ($validated['tax_rate'] / 100);
        $total = $subTotal + $taxTotal;

        $invoice->update([
            'client_id' => $validated['client_id'],
            'number' => $validated['number'],
            'year' => date('Y', strtotime($validated['date'])),
            'date' => $validated['date'],
            'expired_date' => $validated['expired_date'],
            'tax_rate' => $validated['tax_rate'],
            'sub_total' => $subTotal,
            'tax_total' => $taxTotal,
            'total' => $total,
            'notes' => $validated['notes'],
        ]);

        $invoice->items()->delete();
        foreach ($validated['items'] as $item) {
            $invoice->items()->create([
                'itemName' => $item['itemName'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['client', 'items']);
        return view('invoices.print', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:draft,pending,sent,paid,unpaid,partially,overdue',
        ]);

        $invoice->update(['status' => $validated['status']]);

        $statusColors = [
            'draft' => '#6c757d',
            'pending' => '#ffc107',
            'sent' => '#0dcaf0',
            'paid' => '#198754',
            'unpaid' => '#dc3545',
            'partially' => '#0d6efd',
            'overdue' => '#212529',
        ];

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $invoice->status,
            'color' => $statusColors[$invoice->status] ?? '#0d6efd'
        ]);
    }
}
