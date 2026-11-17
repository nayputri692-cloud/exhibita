@extends('layouts.app')
@section('content')
<div class="page-wrap">
  <h1 class="page-title">Karya Saya</h1>
  <p class="page-subtitle">Pantau status kurasi dan kelola karya kamu.</p>

  @if($result->isEmpty())
    <div class="empty-state">
      <div class="icon">📭</div>
      <p>Belum ada karya. <a href="{{ route('daftar-karya') }}" style="color:var(--orange);font-weight:600;">Daftarkan sekarang</a></p>
    </div>
  @else
    <div class="grid">
      @foreach($result as $k)
        @php
          $badge = $k->status === 'ACCEPTED' ? 'badge-accepted'
                 : ($k->status === 'REJECTED' ? 'badge-rejected' : 'badge-pending');
        @endphp
        <div class="karya-card">
          @if($k->gambar && file_exists(public_path('uploads/' . $k->gambar)))
            <img src="{{ asset('uploads/' . $k->gambar) }}" class="thumb" alt="{{ $k->judul }}">
          @else
            <div class="thumb" style="display:flex;align-items:center;justify-content:center;font-size:40px;background:#e5e7eb;color:#9ca3af;">🖼️</div>
          @endif
          
          <div class="body">
            <h3>{{ $k->judul }}</h3>
            <p class="meta">{{ $k->event_nama ?? '-' }} • {{ $k->kategori }}</p>
            <span class="badge-status {{ $badge }}">{{ $k->status }}</span>
            
            @if($k->catatan)
              <p style="font-size:13px;color:var(--gray);margin-top:8px;"><em>Catatan: {{ $k->catatan }}</em></p>
            @endif

            <!-- TOMBOL AKSI (EDIT & HAPUS) -->
            <div style="margin-top: 16px; display: flex; gap: 8px;">
              <a href="{{ route('edit-karya', $k->id) }}" class="btn-sm btn-view" style="text-decoration: none; display: inline-block;">
                 ✏️ Edit
              </a>
              <a href="#" class="btn-sm btn-reject" style="text-decoration: none; display: inline-block;" onclick="if (confirm('Yakin ingin menghapus karya ini secara permanen?')) { document.getElementById('hapus-karya-{{ $k->id }}').submit(); } return false;">
                 🗑️ Hapus
              </a>
              <form id="hapus-karya-{{ $k->id }}" method="POST" action="{{ route('karya-saya.hapus', $k->id) }}" style="display:none;">
                @csrf
                @method('DELETE')
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
