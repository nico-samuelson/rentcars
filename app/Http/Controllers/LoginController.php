<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('user.login', [
            'title' => 'Login'
        ]);
    }

    public function loginAdmin() {
        return view('admin.login', [
            'title' => 'Employee Login'
        ]);
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'min:8',  
        ]);

        if (Auth::attempt($credentials, $request->remember_me)) {
            session()->regenerate();
            return redirect()->intended('/');
        }
        
        if (Auth::guard('admin')->attempt($credentials)) {
            session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('loginError', 'Wrong email or password!')->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}