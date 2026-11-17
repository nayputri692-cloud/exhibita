@extends('layouts.app')
@section('content')
@php
  $error = session('error');
  $success = session('success');
@endphp
<div class="page-wrap" style="padding-top: 40px;">
  <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-top: 4px solid var(--secondary);">
    
    <h1 class="page-title" style="text-align: center; margin-bottom: 8px;">Edit Profil</h1>
    <p class="page-subtitle" style="text-align: center; margin-bottom: 30px;">Perbarui informasi akun kamu di sini.</p>

    @if($error)
      <div class="alert alert-error">{{ $error }}</div>
    @endif
    @if($success)
      <div class="alert alert-success">{{ $success }}</div>
    @endif

    <form method="POST" action="{{ route('profil') }}">
      @csrf
      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="name" value="{{ $user->name }}" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" required>
      </div>

      <div class="form-group">
        <label>Password Baru (Opsional)</label>
        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
        <small style="color: var(--gray); font-size: 12px;">*Minimal 8 karakter jika ingin diganti.</small>
      </div>

      <button type="submit" class="btn-primary" style="margin-top: 10px;">Simpan Perubahan</button>
    </form>
  </div>
</div>
@endsection
