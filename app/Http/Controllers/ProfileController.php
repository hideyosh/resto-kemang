<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // Customer data
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
        ]);

        // Update User table
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update Customer table (related data)
        $user->customer()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
            ]
        );

        return back()->with('success', 'Profile updated successfully.');
    }
}
