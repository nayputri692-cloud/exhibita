@extends('layouts.app')
@section('content')
<div class="page-wrap">
  
  @if($role === 'ADMIN')
    <!-- ================= TAMPILAN ADMIN ================= -->
    <h1 class="page-title">Dashboard Admin</h1>
    <p class="page-subtitle">Selamat datang, {{ $user_name }}. Kelola sistem dan pengguna di sini.</p>
    
    <div class="stats-grid">
      <div class="stat-card"><div class="label">Total Pengguna</div><div class="value">{{ $total_users }}</div></div>
      <div class="stat-card"><div class="label">Total Karya</div><div class="value">{{ $total_karya }}</div></div>
    </div>

    <div style="margin-top: 40px;">
      <a href="{{ route('admin-users') }}" class="btn-primary" style="text-decoration:none; display:inline-block;">Kelola Pengguna Sistem →</a>
    </div>

  @elseif($role === 'PANITIA')
    <!-- ================= TAMPILAN PANITIA ================= -->
    <h1 class="page-title">Dashboard Panitia</h1>
    <p class="page-subtitle">Selamat datang, {{ $user_name }}. Kelola pameran dan kurasi karya.</p>
    
    <div class="stats-grid">
      <div class="stat-card"><div class="label">Karya Pending</div><div class="value" style="color: var(--yellow);">{{ $karya_pending }}</div></div>
      <div class="stat-card"><div class="label">Karya Accepted</div><div class="value" style="color: var(--green);">{{ $karya_accepted }}</div></div>
    </div>

    <div style="margin-top: 40px;">
      <a href="{{ route('kurasi') }}" class="btn-primary" style="text-decoration:none; display:inline-block;">Buka Halaman Kurasi →</a>
    </div>

  @elseif($role === 'MAHASISWA')
    <!-- ================= TAMPILAN PESERTA/MAHASISWA ================= -->
    <h1 class="page-title">Dashboard Peserta</h1>
    <p class="page-subtitle">Selamat datang, {{ $user_name }}. Pantau karyamu di sini.</p>

    <div class="stats-grid">
      <div class="stat-card"><div class="label">Karya Saya</div><div class="value">{{ $total_karya_saya }}</div></div>
      <div class="stat-card"><div class="label">Lolos Kurasi</div><div class="value" style="color: var(--green);">{{ $acc_karya_saya }}</div></div>
    </div>

    <div style="margin-top: 40px; display: flex; gap: 16px;">
      <a href="{{ route('daftar-karya') }}" class="btn-primary" style="text-decoration:none; display:inline-block;">Upload Karya Baru</a>
      <a href="{{ route('karya-saya') }}" class="btn-primary" style="text-decoration:none; display:inline-block; background: var(--secondary); color: #fff;">Lihat Karya Saya</a>
    </div>

  @endif

</div>
@endsection
