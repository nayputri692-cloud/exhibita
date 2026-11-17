@extends('layouts.app')
@section('content')
<div class="page-wrap" style="padding-top: 100px;">
  <h1 class="page-title" style="color: #4A0E17;">Katalog Karya</h1>
  <p class="page-subtitle">Jelajahi karya mahasiswa yang lolos kurasi.</p>

  <form class="toolbar" method="GET" action="{{ route('katalog') }}">
    <input type="text" name="q" placeholder="Cari judul atau nama peserta..." value="{{ $search }}">
    <select name="kategori">
      <option value="">Semua Kategori</option>
      <option value="Seni Rupa" {{ $kategori === 'Seni Rupa' ? 'selected' : '' }}>Seni Rupa</option>
      <option value="Film" {{ $kategori === 'Film' ? 'selected' : '' }}>Film</option>
      <option value="Desain" {{ $kategori === 'Desain' ? 'selected' : '' }}>Desain</option>
    </select>
    <button type="submit" class="btn-login" style="border-radius: 12px; background: #4A0E17; border-color: #4A0E17;">Cari</button>
  </form>

  <div class="grid">
    @if($result->isEmpty())
      <div class="empty-state">
        <div class="icon">🔍</div>
        <p>Belum ada karya yang lolos kurasi atau tidak ada yang cocok dengan pencarian.</p>
                <a href="{{ route('home') }}" class="btn-login" style="margin-top: 20px; background: #4A0E17; border-color: #4A0E17;">Kembali ke Beranda</a>
        </a>
      </div>
    @endif

    @foreach($result as $k)
      <a href="{{ route('detail-karya', $k->id) }}" class="karya-card">
        @if($k->gambar)
          <img src="{{ asset('uploads/' . $k->gambar) }}" class="thumb" alt="{{ $k->judul }}">
        @else
          <div class="thumb" style="display:flex;align-items:center;justify-content:center;font-size:40px;">🖼️</div>
        @endif
        <div class="body">
          <h3>{{ $k->judul }}</h3>
          <p class="meta">{{ $k->peserta_name }} • {{ $k->kategori }}</p>
          <span class="badge-status badge-accepted">Accepted</span>
        </div>
      </a>
    @endforeach
  </div>
</div>
@endsection
