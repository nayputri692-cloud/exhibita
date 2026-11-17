<?php
require 'config/db.php';
require 'includes/auth.php';

$id = (int)($_GET['id'] ?? 0);
// Tambah jumlah views setiap kali halaman dibuka
$conn->query("UPDATE karya SET views = views + 1 WHERE id = $id");
$stmt = $conn->prepare("SELECT karya.*, users.name AS peserta_name FROM karya
                        JOIN users ON karya.user_id = users.id
                        WHERE karya.id = ? AND karya.status = 'ACCEPTED'");
$stmt->bind_param('i', $id);
$stmt->execute();
$k = $stmt->get_result()->fetch_assoc();

include 'includes/header.php';
?>

<div class="page-wrap">
    <!-- TOMBOL KEMBALI -->
  <div style="margin-bottom: 20px;">
    <a href="javascript:history.back()" style="display: inline-flex; align-items: center; gap: 8px; color: var(--gray); font-weight: 600; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--gray)'">
      <span style="font-size: 20px;">←</span> Kembali
    </a>
  </div>
  <?php if (!$k): ?>
    <div class="empty-state"><div class="icon">❌</div><p>Karya tidak ditemukan atau belum dipublikasikan.</p></div>
  <?php else: ?>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:start;">
      <div>
        <?php if ($k['gambar']): ?>
          <img src="uploads/<?= htmlspecialchars($k['gambar']) ?>" style="width:100%;border-radius:16px;aspect-ratio:4/3;object-fit:cover;">
        <?php else: ?>
          <div style="width:100%;aspect-ratio:4/3;background:#e5e7eb;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:80px;">🖼️</div>
        <?php endif; ?>
      </div>
      <div>
        <span class="badge-status badge-accepted">Accepted</span>
        <h1 style="font-size:28px;margin:12px 0 8px;"><?= htmlspecialchars($k['judul']) ?></h1>
        <p style="color:var(--gray);margin-bottom:16px;">Oleh <?= htmlspecialchars($k['peserta_name']) ?></p>
        <p style="margin-bottom:16px;"><?= nl2br(htmlspecialchars($k['deskripsi'])) ?></p>
        <p><strong>Medium:</strong> <?= htmlspecialchars($k['medium']) ?></p>
        <p><strong>Kategori:</strong> <?= htmlspecialchars($k['kategori']) ?></p>
        <p><strong>Booth:</strong> <?= htmlspecialchars($k['booth'] ?: '-') ?></p>
        <a href="katalog.php" class="btn-cta" style="margin-top:24px;display:inline-block;">← Kembali</a>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>