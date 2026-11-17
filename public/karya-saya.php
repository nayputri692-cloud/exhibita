<?php
require 'config/db.php';
require 'includes/auth.php';
requireRole('MAHASISWA');

// Fitur Hapus Karya
if (isset($_GET['hapus'])) {
  $id_hapus = (int)$_GET['hapus'];
  
  $cek = $conn->prepare("SELECT gambar FROM karya WHERE id = ? AND user_id = ?");
  $cek->bind_param('ii', $id_hapus, $_SESSION['user_id']);
  $cek->execute();
  $data = $cek->get_result()->fetch_assoc();
  
  if ($data) {
    if (!empty($data['gambar']) && file_exists('uploads/' . $data['gambar'])) {
      unlink('uploads/' . $data['gambar']);
    }
    $stmt_hapus = $conn->prepare("DELETE FROM karya WHERE id = ? AND user_id = ?");
    $stmt_hapus->bind_param('ii', $id_hapus, $_SESSION['user_id']);
    $stmt_hapus->execute();
  }
  header('Location: karya-saya.php');
  exit;
}

$stmt = $conn->prepare("SELECT karya.*, events.nama AS event_nama FROM karya
                        LEFT JOIN events ON karya.event_id = events.id
                        WHERE karya.user_id = ?
                        ORDER BY karya.created_at DESC");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

include 'includes/header.php';
?>

<div class="page-wrap">
  <h1 class="page-title">Karya Saya</h1>
  <p class="page-subtitle">Pantau status kurasi dan kelola karya kamu.</p>

  <?php if ($result->num_rows === 0): ?>
    <div class="empty-state">
      <div class="icon">📭</div>
      <p>Belum ada karya. <a href="daftar-karya.php" style="color:var(--orange);font-weight:600;">Daftarkan sekarang</a></p>
    </div>
  <?php else: ?>
    <div class="grid">
      <?php while ($k = $result->fetch_assoc()):
        $badge = $k['status'] === 'ACCEPTED' ? 'badge-accepted'
               : ($k['status'] === 'REJECTED' ? 'badge-rejected' : 'badge-pending');
      ?>
        <div class="karya-card">
          <?php if ($k['gambar'] && file_exists('uploads/' . $k['gambar'])): ?>
            <img src="uploads/<?= htmlspecialchars($k['gambar']) ?>" class="thumb" alt="<?= htmlspecialchars($k['judul']) ?>">
          <?php else: ?>
            <div class="thumb" style="display:flex;align-items:center;justify-content:center;font-size:40px;background:#e5e7eb;color:#9ca3af;">🖼️</div>
          <?php endif; ?>
          
          <div class="body">
            <h3><?= htmlspecialchars($k['judul']) ?></h3>
            <p class="meta"><?= htmlspecialchars($k['event_nama'] ?? '-') ?> • <?= htmlspecialchars($k['kategori']) ?></p>
            <span class="badge-status <?= $badge ?>"><?= $k['status'] ?></span>
            
            <?php if ($k['catatan']): ?>
              <p style="font-size:13px;color:var(--gray);margin-top:8px;"><em>Catatan: <?= htmlspecialchars($k['catatan']) ?></em></p>
            <?php endif; ?>

            <!-- TOMBOL AKSI (EDIT & HAPUS) -->
            <div style="margin-top: 16px; display: flex; gap: 8px;">
              <a href="edit-karya.php?id=<?= $k['id'] ?>" class="btn-sm btn-view" style="text-decoration: none; display: inline-block;">
                 ✏️ Edit
              </a>
              <a href="karya-saya.php?hapus=<?= $k['id'] ?>" class="btn-sm btn-reject" style="text-decoration: none; display: inline-block;" onclick="return confirm('Yakin ingin menghapus karya ini secara permanen?');">
                 🗑️ Hapus
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>