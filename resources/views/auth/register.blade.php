@php $error = session('error'); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar — EXHIBITA</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="login-body">

  <div class="login-wrapper" style="height: auto; min-height: 600px;">
    
    <!-- SISI KIRI: GAMBAR -->
    <div class="login-image">
      <img src="{{ asset('img/galeri.jpg') }}" alt="Galeri Seni">
    </div>

    <!-- SISI KANAN: FORM REGISTER -->
    <div class="login-form-box" style="padding: 40px;">
      <h2 style="margin-bottom: 20px;">Buat Akun Baru</h2>

      @if($error)
        <div class="alert alert-error" style="background: rgba(220,38,38,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3); margin-bottom: 15px;">
          {{ $error }}
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="input-group" style="margin-bottom: 15px;">
          <label>Nama Lengkap</label>
          <input type="text" name="name" placeholder="Nama kamu" required>
        </div>

        <div class="input-group" style="margin-bottom: 15px;">
          <label>Email</label>
          <input type="email" name="email" placeholder="nama@email.com" required>
        </div>
        
        <div class="input-group" style="margin-bottom: 15px;">
          <label>Password</label>
          <input type="password" name="password" placeholder="Minimal 8 karakter" required>
        </div>

        <div class="input-group" style="margin-bottom: 25px;">
          <label>Daftar Sebagai</label>
          <select name="role">
            <option value="MAHASISWA">Mahasiswa / Peserta</option>
            <option value="PANITIA">Panitia / Organizer</option>
          </select>
        </div>

        <button type="submit" class="btn-glass">Daftar Sekarang</button>
      </form>

      <div class="login-links" style="margin-top: 25px;">
        <a href="{{ route('login') }}">Sudah punya akun? <strong>Login di sini</strong></a>
      </div>
    </div>

  </div>

</body>
</html>
