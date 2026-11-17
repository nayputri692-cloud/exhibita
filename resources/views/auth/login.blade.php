@php $error = session('error'); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — EXHIBITA</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="login-body">

  <div class="login-wrapper">
    
    <!-- SISI KIRI: FOTO GALERI -->
    <div class="login-image">
      <!-- Pastikan gambar galeri.jpg ada di folder img/ -->
      <img src="{{ asset('img/galeri.jpg') }}" alt="Galeri Seni">
    </div>

    <!-- SISI KANAN: FORM LOGIN (GLASSMORPHISM) -->
    <div class="login-form-box">
      <h2>Login</h2>

      @if($error)
        <div class="alert alert-error" style="background: rgba(220,38,38,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3);">
          {{ $error }}
        </div>
      @endif

      @if(request()->has('registered'))
        <div class="alert" style="background: rgba(22,163,74,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3); margin-bottom: 20px;">
          Pendaftaran berhasil! Silakan login dengan akun barumu.
        </div>
      @endif
      
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group">
          <label>Email</label>
          <input type="email" name="email" placeholder="admin@exhibita.id" required>
        </div>
        
        <div class="input-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-glass">Login</button>
      </form>

      <div class="login-links">
        <a href="{{ route('register') }}">Create an account</a>
        <a href="#">Forgot password</a>
      </div>
    </div>

  </div>

</body>
</html>
