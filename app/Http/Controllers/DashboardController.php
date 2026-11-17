<?php

namespace App\Http\Controllers;

use App\Models\Karya;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ---------- dashboard.php ----------
    public function __invoke()
    {
        $user = Auth::user();
        $data = ['role' => $user->role, 'user_name' => $user->name];

        if ($user->role === 'ADMIN') {
            $data['total_users'] = User::count();
            $data['total_karya'] = Karya::count();
        } elseif ($user->role === 'PANITIA') {
            $data['karya_pending']  = Karya::where('status', 'SUBMITTED')->count();
            $data['karya_accepted'] = Karya::where('status', 'ACCEPTED')->count();
        } elseif ($user->role === 'MAHASISWA') {
            $data['total_karya_saya'] = Karya::where('user_id', $user->id)->count();
            $data['acc_karya_saya']   = Karya::where('user_id', $user->id)->where('status', 'ACCEPTED')->count();
        }

        return view('pages.dashboard', $data);
    }
}
