<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    // ---------- profil.php ----------
    public function edit()
    {
        $user = Auth::user();

        return view('pages.profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $name = trim((string) $request->input('name'));
        $email = trim((string) $request->input('email'));
        $new_password = (string) $request->input('password');

        if (mb_strlen($name) < 3) {
            return back()->with('error', 'Nama minimal 3 karakter.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Format email tidak valid.');
        }

        // Cek apakah email sudah dipakai user lain
        if (User::where('email', $email)->where('id', '!=', $user->id)->exists()) {
            return back()->with('error', 'Email sudah digunakan oleh akun lain.');
        }

        $data = ['name' => $name, 'email' => $email];

        if (!empty($new_password)) {
            if (mb_strlen($new_password) < 8) {
                return back()->with('error', 'Password baru minimal 8 karakter.');
            }
            $data['password'] = Hash::make($new_password);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
