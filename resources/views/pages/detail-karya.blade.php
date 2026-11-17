@extends('layouts.app')
@section('content')
<div class="page-wrap">
    <!-- TOMBOL KEMBALI -->
  <div style="margin-bottom: 20px;">
    <a href="javascript:history.back()" style="display: inline-flex; align-items: center; gap: 8px; color: var(--gray); font-weight: 600; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--gray)'">
      <span style="font-size: 20px;">←</span> Kembali
    </a>
  </div>
  @if(!$k)
    <div class="empty-state"><div class="icon">❌</div><p>Karya tidak ditemukan atau belum dipublikasikan.</p></div>
  @else
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:start;">
      <div>
        @if($k->gambar)
          <img src="{{ asset('uploads/' . $k->gambar) }}" style="width:100%;border-radius:16px;aspect-ratio:4/3;object-fit:cover;">
        @else
          <div style="width:100%;aspect-ratio:4/3;background:#e5e7eb;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:80px;">🖼️</div>
        @endif
      </div>
      <div>
        <span class="badge-status badge-accepted">Accepted</span>
        <h1 style="font-size:28px;margin:12px 0 8px;">{{ $k->judul }}</h1>
        <p style="color:var(--gray);margin-bottom:16px;">Oleh {{ $k->peserta_name }}</p>
        <p style="margin-bottom:16px;">{!! nl2br(e($k->deskripsi)) !!}</p>
        <p><strong>Medium:</strong> {{ $k->medium }}</p>
        <p><strong>Kategori:</strong> {{ $k->kategori }}</p>
        <p><strong>Booth:</strong> {{ $k->booth ?: '-' }}</p>
        <a href="{{ route('katalog') }}" class="btn-cta" style="margin-top:24px;display:inline-block;">← Kembali</a>
      </div>
    </div>
  @endif
</div>
@endsection
