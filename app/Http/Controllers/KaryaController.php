<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Karya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryaController extends Controller
{
    /**
     * Validasi & simpan file gambar ke public/uploads (sama seperti kode lama:
     * hanya JPG/PNG, maksimal 5MB). Mengembalikan [namaFile|null, error|null].
     */
    private function simpanGambar(Request $request): array
    {
        $file = $request->file('gambar');

        if (!$file || !$file->isValid()) {
            return [null, 'Gagal mengupload gambar.'];
        }

        if (!in_array($file->getMimeType(), ['image/jpeg', 'image/png'], true)) {
            return [null, 'Hanya JPG/PNG yang diizinkan.'];
        }
        if ($file->getSize() > 5 * 1024 * 1024) {
            return [null, 'Maksimal 5MB.'];
        }

        // Ekstensi diambil dari isi file (bukan dari nama file kiriman user)
        $nama = uniqid('karya_') . '.' . $file->extension();
        $file->move(public_path('uploads'), $nama);

        return [$nama, null];
    }

    private function hapusGambar(?string $gambar): void
    {
        if (!empty($gambar) && file_exists(public_path('uploads/' . $gambar))) {
            unlink(public_path('uploads/' . $gambar));
        }
    }

    // ---------- daftar-karya.php ----------
    public function create()
    {
        // Ambil event published
        $events = Event::where('status', 'PUBLISHED')->orderByDesc('tanggal')->get(['id', 'nama']);

        return view('karya.daftar', compact('events'));
    }

    public function store(Request $request)
    {
        $event_id = (int) $request->input('event_id');
        $judul = trim((string) $request->input('judul'));
        $deskripsi = trim((string) $request->input('deskripsi'));
        $medium = trim((string) $request->input('medium'));
        $kategori = (string) $request->input('kategori');

        if (!$request->hasFile('gambar')) {
            return back()->with('error', 'Gambar wajib diupload.');
        }
        if (!Event::whereKey($event_id)->exists()) {
            return back()->with('error', 'Event tidak valid.');
        }
        if ($judul === '' || $deskripsi === '' || $medium === '' || $kategori === '') {
            return back()->with('error', 'Semua kolom wajib diisi.');
        }

        [$gambar, $error] = $this->simpanGambar($request);
        if ($error) {
            return back()->with('error', $error);
        }

        Karya::create([
            'event_id'  => $event_id,
            'user_id'   => Auth::id(),
            'judul'     => $judul,
            'deskripsi' => $deskripsi,
            'medium'    => $medium,
            'kategori'  => $kategori,
            'gambar'    => $gambar,
        ]);

        return back()->with('success', 'Karya berhasil didaftarkan! Menunggu kurasi panitia.');
    }

    // ---------- karya-saya.php ----------
    public function index()
    {
        $result = Karya::query()
            ->select('karya.*', 'events.nama as event_nama')
            ->leftJoin('events', 'karya.event_id', '=', 'events.id')
            ->where('karya.user_id', Auth::id())
            ->orderByDesc('karya.created_at')
            ->get();

        return view('karya.saya', compact('result'));
    }

    public function destroy($id)
    {
        $data = Karya::where('id', (int) $id)->where('user_id', Auth::id())->first();

        if ($data) {
            $this->hapusGambar($data->gambar);
            $data->delete();
        }

        return redirect()->route('karya-saya');
    }

    // ---------- edit-karya.php ----------
    private function karyaMilikSaya($id): ?Karya
    {
        return Karya::where('id', (int) $id)->where('user_id', Auth::id())->first();
    }

    public function edit($id)
    {
        $karya = $this->karyaMilikSaya($id);

        // Jika karya tidak ditemukan atau bukan milik user ini
        if (!$karya) {
            return redirect()->route('karya-saya');
        }

        return view('karya.edit', compact('karya'));
    }

    public function update(Request $request, $id)
    {
        $karya = $this->karyaMilikSaya($id);
        if (!$karya) {
            return redirect()->route('karya-saya');
        }

        $judul = trim((string) $request->input('judul'));
        $deskripsi = trim((string) $request->input('deskripsi'));
        $medium = trim((string) $request->input('medium'));
        $kategori = (string) $request->input('kategori');
        $gambar_baru = $karya->gambar; // Default pakai gambar lama

        if ($judul === '' || $deskripsi === '' || $medium === '' || $kategori === '') {
            return back()->with('error', 'Semua kolom wajib diisi.');
        }

        // Cek kalau user upload gambar baru
        if ($request->hasFile('gambar')) {
            [$nama, $error] = $this->simpanGambar($request);
            if ($error) {
                return back()->with('error', $error);
            }
            $this->hapusGambar($karya->gambar); // Hapus gambar lama kalau ada
            $gambar_baru = $nama;
        }

        // Update database, kembalikan status ke SUBMITTED agar dikurasi ulang
        $karya->update([
            'judul'     => $judul,
            'deskripsi' => $deskripsi,
            'medium'    => $medium,
            'kategori'  => $kategori,
            'gambar'    => $gambar_baru,
            'status'    => 'SUBMITTED',
            'catatan'   => null,
        ]);

        return back()->with('success', 'Karya berhasil diperbarui! Status dikembalikan ke SUBMITTED untuk kurasi ulang.');
    }
}
