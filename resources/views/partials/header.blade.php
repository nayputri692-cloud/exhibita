@php
  $authUser = Auth::user();
  $u = $authUser ? [
    'name' => $authUser->name,
    'role' => $authUser->role,
  ] : null;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>EXHIBITA</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<nav class="navbar">
  <!-- LOGO: Jika login arahkan ke dashboard, jika belum ke index -->
 <a href="{{ $u ? route('dashboard') : route('home') }}" class="logo" style="color: #4A0E17 !important; font-size: 26px; font-weight: 900; letter-spacing: -0.5px;">EXHIBITA</a>
  
  <div class="nav-links">
    @if(!$u)
      <!-- Publik -->
    @else
      <!-- Sudah Login -->
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Beranda</a>
      <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') ? 'active' : '' }}">Katalog Publik</a>
      
      @if($u['role'] === 'MAHASISWA')
        <a href="{{ route('daftar-karya') }}" class="{{ request()->routeIs('daftar-karya') ? 'active' : '' }}">Daftar Karya</a>
        <a href="{{ route('karya-saya') }}" class="{{ request()->routeIs('karya-saya') ? 'active' : '' }}">Karya Saya</a>
      @elseif($u['role'] === 'PANITIA')
        <a href="{{ route('kurasi') }}" class="{{ request()->routeIs('kurasi') ? 'active' : '' }}">Kurasi</a>
      @elseif($u['role'] === 'ADMIN')
        <a href="{{ route('kurasi') }}" class="{{ request()->routeIs('kurasi') ? 'active' : '' }}">Kurasi</a>
        <a href="{{ route('admin-users') }}" class="{{ request()->routeIs('admin-users') ? 'active' : '' }}">Kelola User</a>
      @endif
    @endif
  </div>
  <!-- ... sisa kode nav-right tetap sama ... -->

    <div class="nav-right">
        @if($u)
      <!-- Teks Halo -->
      <a href="{{ route('profil') }}" style="font-size:14px; color: #4A0E17; margin-right:12px; font-weight:700; text-decoration:none;">
        Halo, {{ $u['name'] }}
      </a>
      <!-- Tombol Logout -->
      <a href="{{ route('logout') }}" style="background: #4A0E17; color: #ffffff; padding: 10px 24px; border-radius: 999px; font-weight: 700; text-decoration: none; display: inline-block;">Logout</a>
    @else
      <!-- Tombol Login -->
      <a href="{{ route('login') }}" style="background: #4A0E17; color: #ffffff; padding: 10px 24px; border-radius: 999px; font-weight: 700; text-decoration: none; display: inline-block;">Login</a>
    @endif
  </div>
</nav>
