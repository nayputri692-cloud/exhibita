@extends('layouts.app')
@section('content')
<div class="page-wrap">
  <div style="margin-bottom: 20px;">
    <a href="{{ route('kurasi') }}" style="color: var(--gray); font-weight: 600; text-decoration: none;">← Kembali ke Daftar Kurasi</a>
  </div>

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
    
    <!-- Kolom Kiri: Gambar -->
    <div>
      @if($k->gambar)
        <img src="{{ asset('uploads/' . $k->gambar) }}" style="width: 100%; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
      @else
        <div style="width:100%; aspect-ratio:4/3; background:#eee; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:60px;">🖼️</div>
      @endif
    </div>

    <!-- Kolom Kanan: Detail & Form Penilaian -->
    <div>
      <span class="badge-status {{ $k->status === 'ACCEPTED' ? 'badge-accepted' : ($k->status === 'REJECTED' ? 'badge-rejected' : 'badge-pending') }}">
        {{ $k->status }}
      </span>
      <h1 style="font-size: 32px; color: var(--primary); margin: 12px 0;">{{ $k->judul }}</h1>
      <p style="color: var(--gray); margin-bottom: 20px;">
        Oleh: <strong>{{ $k->peserta_name }}</strong> <br>
        Event: {{ $k->event_nama ?? '-' }} <br>
        Medium: {{ $k->medium }} | Kategori: {{ $k->kategori }}
      </p>

      <div style="background: #F9FAFB; padding: 20px; border-radius: 12px; margin-bottom: 24px; font-size: 15px; line-height: 1.8;">
        {!! nl2br(e($k->deskripsi)) !!}
      </div>

      <!-- Form Aksi -->
      @if($k->status === 'SUBMITTED')
        <div style="border-top: 1px solid #eee; padding-top: 24px;">
          <h3 style="margin-bottom: 16px;">Keputusan Kurasi</h3>
          
          <form method="POST" action="{{ route('review-kurasi', $k->id) }}" style="margin-bottom: 16px; display: flex; gap: 10px;">
            @csrf
            <input type="hidden" name="action" value="accept">
            <input type="text" name="booth" placeholder="Nomor Booth (mis. A-1)" required style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            <button type="submit" class="btn-sm btn-accept" style="padding: 12px 24px; font-size: 14px;">✔ Terima Karya</button>
          </form>

          <form method="POST" action="{{ route('review-kurasi', $k->id) }}" style="display: flex; gap: 10px;">
            @csrf
            <input type="hidden" name="action" value="reject">
            <input type="text" name="catatan" placeholder="Alasan penolakan..." required style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            <button type="submit" class="btn-sm btn-reject" style="padding: 12px 24px; font-size: 14px;">✖ Tolak Karya</button>
          </form>
        </div>
      @else
        <div style="background: #F3F4F6; padding: 16px; border-radius: 8px;">
          <strong>Catatan Kurasi:</strong> {{ $k->catatan ?: '-' }}<br>
          <strong>Booth:</strong> {{ $k->booth ?: '-' }}
        </div>
      @endif
    </div>

  </div>
</div>
@endsection
