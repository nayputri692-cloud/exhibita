@extends('layouts.app')
@section('content')
<div class="page-wrap">
  <h1 class="page-title">Jadwal Event</h1>
  <p class="page-subtitle">Jadwal pameran dan showcase karya mahasiswa.</p>
  
  <div class="empty-state">
    <div class="icon">📅</div>
    <p>Belum ada jadwal event saat ini.</p>
    <a href="{{ route('home') }}" class="btn-login" style="margin-top: 20px;">Kembali ke Beranda</a>
  </div>
</div>
@endsection
