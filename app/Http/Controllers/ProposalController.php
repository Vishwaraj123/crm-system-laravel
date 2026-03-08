<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function index(\App\DataTables\ProposalDataTable $dataTable)
    {
        return $dataTable->render('proposals.index');
    }

    public function create()
    {
        $clients = \App\Models\Client::all();
        return view('proposals.create', compact('clients'));
    }

    public function store(Request $request)
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

        $proposal = Proposal::create([
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
            $proposal->items()->create([
                'itemName' => $item['itemName'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);
        }

        return redirect()->route('proposals.index')->with('success', 'Proposal created successfully.');
    }

    public function show(Proposal $proposal)
    {
        $proposal->load('client', 'items');
        return view('proposals.show', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        $clients = \App\Models\Client::all();
        $proposal->load('items');
        return view('proposals.edit', compact('proposal', 'clients'));
    }

    public function update(Request $request, Proposal $proposal)
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

        $proposal->update([
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

        $proposal->items()->delete();
        foreach ($validated['items'] as $item) {
            $proposal->items()->create([
                'itemName' => $item['itemName'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);
        }

        return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully.');
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->delete();
        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully.');
    }
}
