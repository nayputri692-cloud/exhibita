<?php
require 'config/db.php';
require 'includes/auth.php';
requireLogin(); // Wajib login

$role = $_SESSION['user_role'];
$user_name = $_SESSION['user_name'];

include 'includes/header.php';
?>

<div class="page-wrap">
  
  <?php if ($role === 'ADMIN'): ?>
    <!-- ================= TAMPILAN ADMIN ================= -->
    <h1 class="page-title">Dashboard Admin</h1>
    <p class="page-subtitle">Selamat datang, <?= htmlspecialchars($user_name) ?>. Kelola sistem dan pengguna di sini.</p>
    
    <div class="stats-grid">
      <div class="stat-card"><div class="label">Total Pengguna</div><div class="value"><?= $conn->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'] ?></div></div>
      <div class="stat-card"><div class="label">Total Karya</div><div class="value"><?= $conn->query("SELECT COUNT(*) c FROM karya")->fetch_assoc()['c'] ?></div></div>
    </div>

    <div style="margin-top: 40px;">
      <a href="admin-users.php" class="btn-primary" style="text-decoration:none; display:inline-block;">Kelola Pengguna Sistem →</a>
    </div>

  <?php elseif ($role === 'PANITIA'): ?>
    <!-- ================= TAMPILAN PANITIA ================= -->
    <h1 class="page-title">Dashboard Panitia</h1>
    <p class="page-subtitle">Selamat datang, <?= htmlspecialchars($user_name) ?>. Kelola pameran dan kurasi karya.</p>
    
    <div class="stats-grid">
      <div class="stat-card"><div class="label">Karya Pending</div><div class="value" style="color: var(--yellow);"><?= $conn->query("SELECT COUNT(*) c FROM karya WHERE status = 'SUBMITTED'")->fetch_assoc()['c'] ?></div></div>
      <div class="stat-card"><div class="label">Karya Accepted</div><div class="value" style="color: var(--green);"><?= $conn->query("SELECT COUNT(*) c FROM karya WHERE status = 'ACCEPTED'")->fetch_assoc()['c'] ?></div></div>
    </div>

    <div style="margin-top: 40px;">
      <a href="kurasi.php" class="btn-primary" style="text-decoration:none; display:inline-block;">Buka Halaman Kurasi →</a>
    </div>

  <?php elseif ($role === 'MAHASISWA'): ?>
    <!-- ================= TAMPILAN PESERTA/MAHASISWA ================= -->
    <h1 class="page-title">Dashboard Peserta</h1>
    <p class="page-subtitle">Selamat datang, <?= htmlspecialchars($user_name) ?>. Pantau karyamu di sini.</p>
    
    <?php 
      $uid = $_SESSION['user_id'];
      $total_karya_saya = $conn->query("SELECT COUNT(*) c FROM karya WHERE user_id = $uid")->fetch_assoc()['c'];
      $acc_karya_saya = $conn->query("SELECT COUNT(*) c FROM karya WHERE user_id = $uid AND status = 'ACCEPTED'")->fetch_assoc()['c'];
    ?>

    <div class="stats-grid">
      <div class="stat-card"><div class="label">Karya Saya</div><div class="value"><?= $total_karya_saya ?></div></div>
      <div class="stat-card"><div class="label">Lolos Kurasi</div><div class="value" style="color: var(--green);"><?= $acc_karya_saya ?></div></div>
    </div>

    <div style="margin-top: 40px; display: flex; gap: 16px;">
      <a href="daftar-karya.php" class="btn-primary" style="text-decoration:none; display:inline-block;">Upload Karya Baru</a>
      <a href="karya-saya.php" class="btn-primary" style="text-decoration:none; display:inline-block; background: var(--secondary); color: #fff;">Lihat Karya Saya</a>
    </div>

  <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>