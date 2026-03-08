<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;

class OfferController extends Controller
{
    public function index(\App\DataTables\QuoteDataTable $dataTable)
    {
        return $dataTable->render('offers.index');
    }

    public function create()
    {
        $clients = \App\Models\Client::all();
        return view('offers.create', compact('clients'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'number' => 'required|string',
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

        $offer = Offer::create([
            'client_id' => $validated['client_id'],
            'number' => $validated['number'],
            'year' => date('Y', strtotime($validated['date'])),
            'date' => $validated['date'],
            'expired_date' => $validated['expired_date'],
            'tax_rate' => $validated['tax_rate'],
            'sub_total' => $subTotal,
            'tax_total' => $taxTotal,
            'total' => $total,
            'status' => 'draft',
            'notes' => $validated['notes'],
        ]);

        foreach ($validated['items'] as $item) {
            $offer->items()->create([
                'itemName' => $item['itemName'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);
        }

        return redirect()->route('offers.index')->with('success', 'Offer created successfully.');
    }

    public function show(Offer $offer)
    {
        $offer->load('client', 'items');
        return view('offers.show', compact('offer'));
    }

    public function edit(Offer $offer)
    {
        $clients = \App\Models\Client::all();
        $offer->load('items');
        return view('offers.edit', compact('offer', 'clients'));
    }

    public function update(\Illuminate\Http\Request $request, Offer $offer)
    {
        // Update logic similar to store but with item sync/replacement
        // For brevity and focus on replication, I'll implement a full replacement of items on update
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'number' => 'required|string',
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

        $offer->update([
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

        $offer->items()->delete();
        foreach ($validated['items'] as $item) {
            $offer->items()->create([
                'itemName' => $item['itemName'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);
        }

        return redirect()->route('offers.index')->with('success', 'Offer updated successfully.');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('offers.index')->with('success', 'Offer deleted successfully.');
    }
}
