<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.index', compact('users'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        
        User::create($validated);
        return redirect()->route('admin.index')->with('success', 'User created successfully.');
    }

    public function show(User $admin)
    {
        return view('admin.show', ['user' => $admin]);
    }

    public function edit(User $admin)
    {
        return view('admin.edit', ['user' => $admin]);
    }

    public function update(UpdateUserRequest $request, User $admin)
    {
        $validated = $request->validated();
        if (!empty($validated['password'])) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);
        return redirect()->route('admin.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.index')->with('error', 'You cannot delete yourself.');
        }
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }
}
