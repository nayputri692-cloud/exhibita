<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$u = isset($_SESSION['user_id']) ? [
  'name' => $_SESSION['user_name'],
  'role' => $_SESSION['user_role'],
] : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EXHIBITA</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
  <!-- LOGO: Jika login arahkan ke dashboard, jika belum ke index -->
 <a href="<?= $u ? 'dashboard.php' : 'index.php' ?>" class="logo" style="color: #4A0E17 !important; font-size: 26px; font-weight: 900; letter-spacing: -0.5px;">EXHIBITA</a>
  
  <div class="nav-links">
    <?php if (!$u): ?>
      <!-- Publik -->
    <?php else: ?>
      <!-- Sudah Login -->
      <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Beranda</a>
      <a href="katalog.php" class="<?= basename($_SERVER['PHP_SELF']) == 'katalog.php' ? 'active' : '' ?>">Katalog Publik</a>
      
      <?php if ($u['role'] === 'MAHASISWA'): ?>
        <a href="daftar-karya.php" class="<?= basename($_SERVER['PHP_SELF']) == 'daftar-karya.php' ? 'active' : '' ?>">Daftar Karya</a>
        <a href="karya-saya.php" class="<?= basename($_SERVER['PHP_SELF']) == 'karya-saya.php' ? 'active' : '' ?>">Karya Saya</a>
      <?php elseif ($u['role'] === 'PANITIA'): ?>
        <a href="kurasi.php" class="<?= basename($_SERVER['PHP_SELF']) == 'kurasi.php' ? 'active' : '' ?>">Kurasi</a>
      <?php elseif ($u['role'] === 'ADMIN'): ?>
        <a href="kurasi.php" class="<?= basename($_SERVER['PHP_SELF']) == 'kurasi.php' ? 'active' : '' ?>">Kurasi</a>
        <a href="admin-users.php" class="<?= basename($_SERVER['PHP_SELF']) == 'admin-users.php' ? 'active' : '' ?>">Kelola User</a>
      <?php endif; ?>
    <?php endif; ?>
  </div>
  <!-- ... sisa kode nav-right tetap sama ... -->

    <div class="nav-right">
        <?php if ($u): ?>
      <!-- Teks Halo -->
      <a href="profil.php" style="font-size:14px; color: #4A0E17; margin-right:12px; font-weight:700; text-decoration:none;">
        Halo, <?= htmlspecialchars($u['name']) ?>
      </a>
      <!-- Tombol Logout -->
      <a href="logout.php" style="background: #4A0E17; color: #ffffff; padding: 10px 24px; border-radius: 999px; font-weight: 700; text-decoration: none; display: inline-block;">Logout</a>
    <?php else: ?>
      <!-- Tombol Login -->
      <a href="login.php" style="background: #4A0E17; color: #ffffff; padding: 10px 24px; border-radius: 999px; font-weight: 700; text-decoration: none; display: inline-block;">Login</a>
    <?php endif; ?>
  </div>
</nav>