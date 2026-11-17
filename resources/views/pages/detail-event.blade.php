@extends('layouts.app')
@section('content')
<div class="page-wrap">
  
  <!-- TOMBOL KEMBALI (TAMBAHAN BARU) -->
  <div style="margin-bottom: 20px;">
    <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--gray); font-weight: 600; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--gray)'">
      <span style="font-size: 20px;">←</span> Kembali ke Beranda
    </a>
  </div>

  @if(!$event)
    <div class="empty-state">
      <div class="icon">❌</div>
      <p>Event tidak ditemukan.</p>
      <a href="{{ route('home') }}" class="btn-login" style="margin-top: 20px;">Kembali ke Beranda</a>
    </div>
  @else
    
    <!-- HERO EVENT -->
    <div style="background: var(--primary); color: white; padding: 40px; border-radius: 20px; margin-bottom: 40px; box-shadow: 0 10px 30px rgba(43, 76, 126, 0.2);">
      <span style="background: var(--secondary); padding: 6px 16px; border-radius: 999px; font-weight: 700; font-size: 14px; letter-spacing: 1px;">
        TAHUN {{ $event->tanggal->format('Y') }}
      </span>
      <h1 style="font-size: 42px; margin-top: 20px; font-weight: 800; line-height: 1.2;">{{ $event->nama }}</h1>
      <p style="font-size: 18px; color: rgba(255,255,255,0.8); margin-top: 10px;">
        📍 {{ $event->lokasi }} &nbsp;|&nbsp; 📅 {{ $event->tanggal->format('d M Y') }}
      </p>
      <p style="margin-top: 20px; font-size: 16px; line-height: 1.8; max-width: 800px;">
        {!! nl2br(e($event->deskripsi)) !!}
      </p>
    </div>

    <!-- GALERI KARYA EVENT INI -->
    <h2 style="font-size: 28px; font-weight: 800; color: var(--primary); margin-bottom: 20px;">Karya yang Dipamerkan</h2>

    <div class="grid">
      @if($result_karya->isEmpty())
        <div class="empty-state" style="grid-column: 1/-1;">
          <div class="icon">🎨</div>
          <p>Belum ada karya yang lolos kurasi untuk event ini.</p>
        </div>
      @endif

      @foreach($result_karya as $k)
        <a href="{{ route('detail-karya', $k->id) }}" class="karya-card">
          @if($k->gambar)
            <img src="{{ asset('uploads/' . $k->gambar) }}" class="thumb" alt="{{ $k->judul }}">
          @else
            <div class="thumb" style="display:flex;align-items:center;justify-content:center;font-size:40px;">🖼️</div>
          @endif
          <div class="body">
            <h3>{{ $k->judul }}</h3>
            <p class="meta">Oleh: {{ $k->peserta_name }}</p>
            <span class="badge-status badge-accepted">Accepted</span>
          </div>
        </a>
      @endforeach
    </div>

  @endif
</div>
@endsection
