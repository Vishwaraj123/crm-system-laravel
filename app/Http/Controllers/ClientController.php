<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(\App\DataTables\ClientDataTable $dataTable)
    {
        return $dataTable->render('clients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();
        $validated['enabled'] = $request->has('enabled');

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client): View
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        $validated = $request->validated();
        $validated['enabled'] = $request->has('enabled');

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        // Instead of hard delete, you could implement soft deletes or use the 'removed' flag
        $client->update(['removed' => true]);

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    /**
     * Remove multiple resources from storage.
     */
    public function bulkDelete(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No clients selected.']);
        }

        Client::whereIn('id', $ids)->update(['removed' => true]);

        return response()->json(['success' => true, 'message' => 'Selected clients deleted successfully.']);
    }
}
