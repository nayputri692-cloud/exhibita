<?php
require 'config/db.php';
require 'includes/auth.php';
requireRole(['PANITIA', 'ADMIN']);

$id = (int)($_GET['id'] ?? 0);

// Proses Aksi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'];
  if ($action === 'accept') {
    $booth = trim($_POST['booth'] ?? '');
    $stmt = $conn->prepare("UPDATE karya SET status = 'ACCEPTED', booth = ?, catatan = 'Karya diterima.' WHERE id = ?");
    $stmt->bind_param('si', $booth, $id);
    $stmt->execute();
  } elseif ($action === 'reject') {
    $catatan = trim($_POST['catatan'] ?? '');
    if ($catatan) {
      $stmt = $conn->prepare("UPDATE karya SET status = 'REJECTED', catatan = ? WHERE id = ?");
      $stmt->bind_param('si', $catatan, $id);
      $stmt->execute();
    }
  }
  header('Location: kurasi.php');
  exit;
}

// Ambil data
$stmt = $conn->prepare("SELECT karya.*, users.name AS peserta_name, events.nama AS event_nama FROM karya JOIN users ON karya.user_id = users.id LEFT JOIN events ON karya.event_id = events.id WHERE karya.id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$k = $stmt->get_result()->fetch_assoc();

if (!$k) { header('Location: kurasi.php'); exit; }

include 'includes/header.php';
?>

<div class="page-wrap">
  <div style="margin-bottom: 20px;">
    <a href="kurasi.php" style="color: var(--gray); font-weight: 600; text-decoration: none;">← Kembali ke Daftar Kurasi</a>
  </div>

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
    
    <!-- Kolom Kiri: Gambar -->
    <div>
      <?php if ($k['gambar']): ?>
        <img src="uploads/<?= htmlspecialchars($k['gambar']) ?>" style="width: 100%; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
      <?php else: ?>
        <div style="width:100%; aspect-ratio:4/3; background:#eee; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:60px;">🖼️</div>
      <?php endif; ?>
    </div>

    <!-- Kolom Kanan: Detail & Form Penilaian -->
    <div>
      <span class="badge-status <?= $k['status'] === 'ACCEPTED' ? 'badge-accepted' : ($k['status'] === 'REJECTED' ? 'badge-rejected' : 'badge-pending') ?>">
        <?= $k['status'] ?>
      </span>
      <h1 style="font-size: 32px; color: var(--primary); margin: 12px 0;"><?= htmlspecialchars($k['judul']) ?></h1>
      <p style="color: var(--gray); margin-bottom: 20px;">
        Oleh: <strong><?= htmlspecialchars($k['peserta_name']) ?></strong> <br>
        Event: <?= htmlspecialchars($k['event_nama'] ?? '-') ?> <br>
        Medium: <?= htmlspecialchars($k['medium']) ?> | Kategori: <?= htmlspecialchars($k['kategori']) ?>
      </p>

      <div style="background: #F9FAFB; padding: 20px; border-radius: 12px; margin-bottom: 24px; font-size: 15px; line-height: 1.8;">
        <?= nl2br(htmlspecialchars($k['deskripsi'])) ?>
      </div>

      <!-- Form Aksi -->
      <?php if ($k['status'] === 'SUBMITTED'): ?>
        <div style="border-top: 1px solid #eee; padding-top: 24px;">
          <h3 style="margin-bottom: 16px;">Keputusan Kurasi</h3>
          
          <form method="POST" style="margin-bottom: 16px; display: flex; gap: 10px;">
            <input type="hidden" name="action" value="accept">
            <input type="text" name="booth" placeholder="Nomor Booth (mis. A-1)" required style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            <button type="submit" class="btn-sm btn-accept" style="padding: 12px 24px; font-size: 14px;">✔ Terima Karya</button>
          </form>

          <form method="POST" style="display: flex; gap: 10px;">
            <input type="hidden" name="action" value="reject">
            <input type="text" name="catatan" placeholder="Alasan penolakan..." required style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            <button type="submit" class="btn-sm btn-reject" style="padding: 12px 24px; font-size: 14px;">✖ Tolak Karya</button>
          </form>
        </div>
      <?php else: ?>
        <div style="background: #F3F4F6; padding: 16px; border-radius: 8px;">
          <strong>Catatan Kurasi:</strong> <?= htmlspecialchars($k['catatan'] ?: '-') ?><br>
          <strong>Booth:</strong> <?= htmlspecialchars($k['booth'] ?: '-') ?>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>

<?php include 'includes/footer.php'; ?>