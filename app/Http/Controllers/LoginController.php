<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // redirect berdasarkan role
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect('/dashboard');
            } elseif ($role === 'petugas') {
                return redirect('/dashboard');
            } elseif ($role === 'owner') {
                return redirect('/dashboard');
            } else {
                Auth::logout();
                return redirect('/login')->withErrors('Role tidak valid');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
