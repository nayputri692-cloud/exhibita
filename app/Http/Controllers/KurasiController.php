<?php

namespace App\Http\Controllers;

use App\Models\Karya;
use Illuminate\Http\Request;

class KurasiController extends Controller
{
    // ---------- kurasi.php ----------
    public function index(Request $request)
    {
        $filter = (string) $request->query('status', '');

        $query = Karya::query()
            ->select('karya.*', 'users.name as peserta_name', 'events.nama as event_nama')
            ->join('users', 'karya.user_id', '=', 'users.id')
            ->leftJoin('events', 'karya.event_id', '=', 'events.id');

        if ($filter) {
            $query->where('karya.status', $filter);
        }

        $result = $query->orderByDesc('karya.created_at')->get();

        return view('kurasi.index', compact('result', 'filter'));
    }

    // ---------- review-kurasi.php (tampil) ----------
    public function show($id)
    {
        $k = Karya::query()
            ->select('karya.*', 'users.name as peserta_name', 'events.nama as event_nama')
            ->join('users', 'karya.user_id', '=', 'users.id')
            ->leftJoin('events', 'karya.event_id', '=', 'events.id')
            ->where('karya.id', (int) $id)
            ->first();

        if (!$k) {
            return redirect()->route('kurasi');
        }

        return view('kurasi.review', compact('k'));
    }

    // ---------- review-kurasi.php (proses aksi) ----------
    public function decide(Request $request, $id)
    {
        $id = (int) $id;
        $action = $request->input('action');

        if ($action === 'accept') {
            $booth = trim((string) $request->input('booth', ''));
            Karya::where('id', $id)->update([
                'status'  => 'ACCEPTED',
                'booth'   => $booth,
                'catatan' => 'Karya diterima.',
            ]);
        } elseif ($action === 'reject') {
            $catatan = trim((string) $request->input('catatan', ''));
            if ($catatan) {
                Karya::where('id', $id)->update([
                    'status'  => 'REJECTED',
                    'catatan' => $catatan,
                ]);
            }
        }

        return redirect()->route('kurasi');
    }
}
