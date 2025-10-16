<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Password::defaults()],
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'role' => 'required|in:customer,supplier',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'role' => $request->role,
                'is_active' => 1, // Set as active by default
                'notifications' => true,
                'email_notifications' => true,
            ]);

            Auth::login($user);

            // Redirect based on user role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Registration successful! Welcome to our car rental system.');
            } elseif ($user->isSupplier()) {
                return redirect()->route('supplier.dashboard')->with('success', 'Registration successful! Welcome to our car rental system.');
            } else {
                return redirect()->route('cars.index')->with('success', 'Registration successful! Welcome to our car rental system.');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }
    }
}
