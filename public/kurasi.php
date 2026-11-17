<?php
require 'config/db.php';
require 'includes/auth.php';
requireRole(['PANITIA', 'ADMIN']);

$filter = $_GET['status'] ?? '';
$sql = "SELECT karya.*, users.name AS peserta_name, events.nama AS event_nama
        FROM karya
        JOIN users ON karya.user_id = users.id
        LEFT JOIN events ON karya.event_id = events.id";
if ($filter) {
  $sql .= " WHERE karya.status = ?";
}
$sql .= " ORDER BY karya.created_at DESC";

$stmt = $conn->prepare($sql);
if ($filter) $stmt->bind_param('s', $filter);
$stmt->execute();
$result = $stmt->get_result();

include 'includes/header.php';
?>

<div class="page-wrap">
  <h1 class="page-title">Kurasi Karya</h1>
  <p class="page-subtitle">Review karya yang masuk sebelum menentukan statusnya.</p>

  <form method="GET" class="toolbar">
    <select name="status" onchange="this.form.submit()">
      <option value="">Semua Status</option>
      <option value="SUBMITTED" <?= $filter === 'SUBMITTED' ? 'selected' : '' ?>>Menunggu Review (Submitted)</option>
      <option value="ACCEPTED" <?= $filter === 'ACCEPTED' ? 'selected' : '' ?>>Diterima (Accepted)</option>
      <option value="REJECTED" <?= $filter === 'REJECTED' ? 'selected' : '' ?>>Ditolak (Rejected)</option>
    </select>
  </form>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Gambar</th>
          <th>Judul & Peserta</th>
          <th>Event</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows === 0): ?>
          <tr><td colspan="5" style="text-align:center;color:var(--gray);padding:32px;">Tidak ada karya.</td></tr>
        <?php endif; ?>

        <?php while ($k = $result->fetch_assoc()):
          $badge = $k['status'] === 'ACCEPTED' ? 'badge-accepted'
                 : ($k['status'] === 'REJECTED' ? 'badge-rejected' : 'badge-pending');
        ?>
          <tr>
            <td>
              <?php if ($k['gambar']): ?>
                <img src="uploads/<?= htmlspecialchars($k['gambar']) ?>" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
              <?php else: ?>
                <div style="width: 80px; height: 60px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center;">🖼️</div>
              <?php endif; ?>
            </td>
            <td>
              <strong style="color: var(--primary);"><?= htmlspecialchars($k['judul']) ?></strong><br>
              <span style="font-size: 12px; color: var(--gray);">Oleh: <?= htmlspecialchars($k['peserta_name']) ?></span>
            </td>
            <td><?= htmlspecialchars($k['event_nama'] ?? '-') ?></td>
            <td><span class="badge-status <?= $badge ?>"><?= $k['status'] ?></span></td>
            <td>
              <!-- Tombol untuk buka halaman detail kurasi -->
              <a href="review-kurasi.php?id=<?= $k['id'] ?>" class="btn-sm btn-view" style="text-decoration:none; display:inline-block;">
                🔍 Review Karya
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>