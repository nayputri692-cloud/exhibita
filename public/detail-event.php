<?php
require 'config/db.php';
require 'includes/auth.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data event
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

include 'includes/header.php';
?>

<div class="page-wrap">
  
  <!-- TOMBOL KEMBALI (TAMBAHAN BARU) -->
  <div style="margin-bottom: 20px;">
    <a href="index.php" style="display: inline-flex; align-items: center; gap: 8px; color: var(--gray); font-weight: 600; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--gray)'">
      <span style="font-size: 20px;">←</span> Kembali ke Beranda
    </a>
  </div>

  <?php if (!$event): ?>
    <div class="empty-state">
      <div class="icon">❌</div>
      <p>Event tidak ditemukan.</p>
      <a href="index.php" class="btn-login" style="margin-top: 20px;">Kembali ke Beranda</a>
    </div>
  <?php else: ?>
    
    <!-- HERO EVENT -->
    <div style="background: var(--primary); color: white; padding: 40px; border-radius: 20px; margin-bottom: 40px; box-shadow: 0 10px 30px rgba(43, 76, 126, 0.2);">
      <span style="background: var(--secondary); padding: 6px 16px; border-radius: 999px; font-weight: 700; font-size: 14px; letter-spacing: 1px;">
        TAHUN <?= date('Y', strtotime($event['tanggal'])) ?>
      </span>
      <h1 style="font-size: 42px; margin-top: 20px; font-weight: 800; line-height: 1.2;"><?= htmlspecialchars($event['nama']) ?></h1>
      <p style="font-size: 18px; color: rgba(255,255,255,0.8); margin-top: 10px;">
        📍 <?= htmlspecialchars($event['lokasi']) ?> &nbsp;|&nbsp; 📅 <?= date('d M Y', strtotime($event['tanggal'])) ?>
      </p>
      <p style="margin-top: 20px; font-size: 16px; line-height: 1.8; max-width: 800px;">
        <?= nl2br(htmlspecialchars($event['deskripsi'])) ?>
      </p>
    </div>

    <!-- GALERI KARYA EVENT INI -->
    <h2 style="font-size: 28px; font-weight: 800; color: var(--primary); margin-bottom: 20px;">Karya yang Dipamerkan</h2>
    
    <?php
    // Ambil karya yang ikut event ini dan statusnya ACCEPTED
    $stmt_karya = $conn->prepare("SELECT karya.*, users.name AS peserta_name FROM karya 
                                  JOIN users ON karya.user_id = users.id 
                                  WHERE karya.event_id = ? AND karya.status = 'ACCEPTED'");
    $stmt_karya->bind_param('i', $id);
    $stmt_karya->execute();
    $result_karya = $stmt_karya->get_result();
    ?>

    <div class="grid">
      <?php if ($result_karya->num_rows === 0): ?>
        <div class="empty-state" style="grid-column: 1/-1;">
          <div class="icon">🎨</div>
          <p>Belum ada karya yang lolos kurasi untuk event ini.</p>
        </div>
      <?php endif; ?>

      <?php while ($k = $result_karya->fetch_assoc()): ?>
        <a href="detail-karya.php?id=<?= $k['id'] ?>" class="karya-card">
          <?php if ($k['gambar']): ?>
            <img src="uploads/<?= htmlspecialchars($k['gambar']) ?>" class="thumb" alt="<?= htmlspecialchars($k['judul']) ?>">
          <?php else: ?>
            <div class="thumb" style="display:flex;align-items:center;justify-content:center;font-size:40px;">🖼️</div>
          <?php endif; ?>
          <div class="body">
            <h3><?= htmlspecialchars($k['judul']) ?></h3>
            <p class="meta">Oleh: <?= htmlspecialchars($k['peserta_name']) ?></p>
            <span class="badge-status badge-accepted">Accepted</span>
          </div>
        </a>
      <?php endwhile; ?>
    </div>

  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>