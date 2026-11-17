<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Karya;

use Illuminate\Http\Request;

class KatalogController extends Controller
{
    // ---------- katalog.php ----------
    public function index(Request $request)
    {
        $search = (string) $request->query('q', '');
        $kategori = (string) $request->query('kategori', '');

        $query = Karya::query()
            ->select('karya.*', 'users.name as peserta_name')
            ->join('users', 'karya.user_id', '=', 'users.id')
            ->where('karya.status', 'ACCEPTED');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('karya.judul', 'like', "%$search%")
                  ->orWhere('users.name', 'like', "%$search%");
            });
        }
        if ($kategori) {
            $query->where('karya.kategori', $kategori);
        }

        $result = $query->orderByDesc('karya.created_at')->get();

        return view('pages.katalog', compact('result', 'search', 'kategori'));
    }

    // ---------- detail-karya.php ----------
    public function detailKarya($id)
    {
        $id = (int) $id;

        // Tambah jumlah views setiap kali halaman dibuka
        Karya::where('id', $id)->increment('views');

        $k = Karya::query()
            ->select('karya.*', 'users.name as peserta_name')
            ->join('users', 'karya.user_id', '=', 'users.id')
            ->where('karya.id', $id)
            ->where('karya.status', 'ACCEPTED')
            ->first();

        return view('pages.detail-karya', compact('k'));
    }

    // ---------- detail-event.php ----------
    public function detailEvent($id)
    {
        $id = (int) $id;
        $event = Event::find($id);

        $result_karya = collect();
        if ($event) {
            $result_karya = Karya::query()
                ->select('karya.*', 'users.name as peserta_name')
                ->join('users', 'karya.user_id', '=', 'users.id')
                ->where('karya.event_id', $id)
                ->where('karya.status', 'ACCEPTED')
                ->get();
        }

        return view('pages.detail-event', compact('event', 'result_karya'));
    }
}
