<?php
require 'config/db.php';
require 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $role = $_POST['role'] === 'PANITIA' ? 'PANITIA' : 'MAHASISWA';

  if (strlen($name) < 3) $error = 'Nama minimal 3 karakter.';
  elseif (strlen($password) < 8) $error = 'Password minimal 8 karakter.';
  else {
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param('s', $email);
    $check->execute();
    if ($check->get_result()->fetch_assoc()) {
      $error = 'Email sudah terdaftar.';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
      $stmt->bind_param('ssss', $name, $email, $hash, $role);
      if ($stmt->execute()) {
        // Kalau sukses, langsung lempar ke halaman login
        header('Location: login.php?registered=1');
        exit;
      } else {
        $error = 'Gagal mendaftar: ' . $conn->error;
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar — EXHIBITA</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">

  <div class="login-wrapper" style="height: auto; min-height: 600px;">
    
    <!-- SISI KIRI: GAMBAR -->
    <div class="login-image">
      <img src="img/galeri.jpg" alt="Galeri Seni">
    </div>

    <!-- SISI KANAN: FORM REGISTER -->
    <div class="login-form-box" style="padding: 40px;">
      <h2 style="margin-bottom: 20px;">Buat Akun Baru</h2>

      <?php if ($error): ?>
        <div class="alert alert-error" style="background: rgba(220,38,38,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3); margin-bottom: 15px;">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST">
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
        <a href="login.php">Sudah punya akun? <strong>Login di sini</strong></a>
      </div>
    </div>

  </div>

</body>
</html>