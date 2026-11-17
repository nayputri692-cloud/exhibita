<?php
require 'config/db.php';
require 'includes/auth.php';

// Kalau sudah login, tendang ke beranda
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['role'];

    if ($user['role'] === 'MAHASISWA') {
      header('Location: dashboard.php');
    } else {
      header('Location: dashboard.php');
    }
    exit;
  }
  $error = 'Email atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — EXHIBITA</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">

  <div class="login-wrapper">
    
    <!-- SISI KIRI: FOTO GALERI -->
    <div class="login-image">
      <!-- Pastikan gambar galeri.jpg ada di folder img/ -->
      <img src="img/galeri.jpg" alt="Galeri Seni">
    </div>

    <!-- SISI KANAN: FORM LOGIN (GLASSMORPHISM) -->
    <div class="login-form-box">
      <h2>Login</h2>

      <?php if ($error): ?>
        <div class="alert alert-error" style="background: rgba(220,38,38,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3);">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

            <?php if (isset($_GET['registered'])): ?>
        <div class="alert" style="background: rgba(22,163,74,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3); margin-bottom: 20px;">
          Pendaftaran berhasil! Silakan login dengan akun barumu.
        </div>
      <?php endif; ?>
      
      <form method="POST">
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
        <a href="register.php">Create an account</a>
        <a href="#">Forgot password</a>
      </div>
    </div>

  </div>

</body>
</html>