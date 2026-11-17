<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ---------- login.php ----------
    public function showLogin()
    {
        // Kalau sudah login, tendang ke beranda
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        $email = trim((string) $request->input('email'));
        $password = (string) $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // ---------- register.php ----------
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $name = trim((string) $request->input('name'));
        $email = trim((string) $request->input('email'));
        $password = (string) $request->input('password');
        $role = $request->input('role') === 'PANITIA' ? 'PANITIA' : 'MAHASISWA';

        if (mb_strlen($name) < 3) {
            return back()->with('error', 'Nama minimal 3 karakter.');
        }
        if (mb_strlen($password) < 8) {
            return back()->with('error', 'Password minimal 8 karakter.');
        }
        if (User::where('email', $email)->exists()) {
            return back()->with('error', 'Email sudah terdaftar.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            return back()->with('error', 'Format email tidak valid.');
        }

        User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make($password),
            'role'     => $role,
        ]);

        // Kalau sukses, langsung lempar ke halaman login
        return redirect()->route('login', ['registered' => 1]);
    }

    // ---------- logout.php ----------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
