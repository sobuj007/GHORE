<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'subscription' => 'nullable|string',
            'role' => 'required|in:admin,agent,user',
            'is_blocked' => 'boolean',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subscription' => $request->input('subscription', 'free'),
            'role' => $request->input('role'),
            'is_blocked' => $request->input('is_blocked', false),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
