@extends('layouts.app')
@section('content')
@php
  $error = session('error');
  $success = session('success');
@endphp
<div class="page-wrap">
  <h1 class="page-title">Daftarkan Karya</h1>
  <p class="page-subtitle">Upload karya terbaikmu dan tunggu proses kurasi.</p>

  @if($error)
    <div class="alert alert-error">{{ $error }}</div>
  @endif
  @if($success)
    <div class="alert alert-success">{{ $success }}</div>
  @endif

  <form method="POST" action="{{ route('daftar-karya') }}" enctype="multipart/form-data" style="max-width:640px;">
    @csrf
    <div class="form-group">
      <label>Event</label>
      <select name="event_id" required>
        <option value="">-- Pilih Event --</option>
        @foreach($events as $e)
          <option value="{{ $e->id }}">{{ $e->nama }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Judul Karya</label>
      <input type="text" name="judul" required>
    </div>

    <div class="form-group">
      <label>Deskripsi</label>
      <textarea name="deskripsi" required></textarea>
    </div>

    <div class="form-group">
      <label>Medium</label>
      <input type="text" name="medium" placeholder="mis. Akrilik di Kanvas" required>
    </div>

    <div class="form-group">
      <label>Kategori</label>
      <select name="kategori" required>
        <option value="Seni Rupa">Seni Rupa</option>
        <option value="Film">Film</option>
        <option value="Desain">Desain</option>
      </select>
    </div>

    <div class="form-group">
      <label>Gambar Karya (JPG/PNG, max 5MB)</label>
      <input type="file" name="gambar" accept="image/jpeg,image/png" required>
    </div>

    <button type="submit" class="btn-primary">Submit Karya</button>
  </form>
</div>
@endsection
