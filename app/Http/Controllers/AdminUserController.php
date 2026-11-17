<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    // ---------- admin-users.php ----------
    public function index()
    {
        $users = User::orderByDesc('created_at')->get();

        return view('admin.users', compact('users'));
    }

    // Proses Ubah Role
    public function updateRole(Request $request)
    {
        $role_baru = (string) $request->input('role');

        if (in_array($role_baru, ['ADMIN', 'PANITIA', 'MAHASISWA'], true)) {
            User::where('id', (int) $request->input('user_id'))->update(['role' => $role_baru]);
        }

        return redirect()->route('admin-users')->with('pesan', 'Role pengguna berhasil diubah.');
    }

    // Proses Hapus User
    public function destroy($id)
    {
        $id = (int) $id;

        if ($id !== Auth::id()) { // Cegah admin hapus diri sendiri
            User::where('id', $id)->delete();
            return redirect()->route('admin-users')->with('pesan', 'Pengguna berhasil dihapus.');
        }

        return redirect()->route('admin-users');
    }
}
