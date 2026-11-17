@extends('layouts.app')
@section('content')
@php
  $error = session('error');
  $success = session('success');
@endphp
<div class="page-wrap">
  <div style="margin-bottom: 20px;">
    <a href="{{ route('karya-saya') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--gray); font-weight: 600; text-decoration: none;">
      <span style="font-size: 20px;">←</span> Kembali ke Karya Saya
    </a>
  </div>

  <h1 class="page-title">Edit Karya</h1>
  <p class="page-subtitle">Perbarui detail karyamu. Mengedit karya akan mereset status kurasi menjadi "Menunggu".</p>

  @if($error)
    <div class="alert alert-error">{{ $error }}</div>
  @endif
  @if($success)
    <div class="alert alert-success">{{ $success }}</div>
  @endif

  <form method="POST" action="{{ route('edit-karya', $karya->id) }}" enctype="multipart/form-data" style="max-width:640px;">
    @csrf
    
    <div class="form-group">
      <label>Judul Karya</label>
      <input type="text" name="judul" value="{{ $karya->judul }}" required>
    </div>

    <div class="form-group">
      <label>Deskripsi</label>
      <textarea name="deskripsi" required>{{ $karya->deskripsi }}</textarea>
    </div>

    <div class="form-group">
      <label>Medium</label>
      <input type="text" name="medium" value="{{ $karya->medium }}" required>
    </div>

    <div class="form-group">
      <label>Kategori</label>
      <select name="kategori" required>
        <option value="Seni Rupa" {{ $karya->kategori === 'Seni Rupa' ? 'selected' : '' }}>Seni Rupa</option>
        <option value="Film" {{ $karya->kategori === 'Film' ? 'selected' : '' }}>Film</option>
        <option value="Desain" {{ $karya->kategori === 'Desain' ? 'selected' : '' }}>Desain</option>
      </select>
    </div>

    <div class="form-group">
      <label>Gambar Karya (JPG/PNG, max 5MB)</label>
      @if($karya->gambar && file_exists(public_path('uploads/' . $karya->gambar)))
        <div style="margin-bottom: 10px;">
          <img src="{{ asset('uploads/' . $karya->gambar) }}" style="width: 150px; border-radius: 8px;">
          <p style="font-size: 12px; color: var(--gray);">*Biarkan kosong jika tidak ingin mengganti gambar.</p>
        </div>
      @endif
      <input type="file" name="gambar" accept="image/jpeg,image/png">
    </div>

    <button type="submit" class="btn-primary">Simpan Perubahan</button>
  </form>
</div>
@endsection
