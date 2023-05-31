<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function index() {
        return view('user.register', [
            'title' => "Sign Up"
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'min:8', 'max:20'],
            'password_confirm' => ['required', 'same:password'],
            'birth_date' => ['required', 'date', 'before:today'],
        ]);

        unset($validated['password_confirm']);
        $validated['password'] = bcrypt($validated['password']);
        $validated['is_blacklisted'] = 0;

        $user = User::create($validated);
        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Registration succeed! Please login');
    }
}
