<?php
require 'config/db.php';
require 'includes/auth.php';

$search = $_GET['q'] ?? '';
$kategori = $_GET['kategori'] ?? '';

$sql = "SELECT karya.*, users.name AS peserta_name FROM karya
        JOIN users ON karya.user_id = users.id
        WHERE karya.status = 'ACCEPTED'";
$params = [];
$types = '';

if ($search) {
  $sql .= " AND (karya.judul LIKE ? OR users.name LIKE ?)";
  $params[] = "%$search%";
  $params[] = "%$search%";
  $types .= 'ss';
}
if ($kategori) {
  $sql .= " AND karya.kategori = ?";
  $params[] = $kategori;
  $types .= 's';
}
$sql .= " ORDER BY karya.created_at DESC";

$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

include 'includes/header.php';
?>

<div class="page-wrap" style="padding-top: 100px;">
  <h1 class="page-title" style="color: #4A0E17;">Katalog Karya</h1>
  <p class="page-subtitle">Jelajahi karya mahasiswa yang lolos kurasi.</p>

  <form class="toolbar" method="GET">
    <input type="text" name="q" placeholder="Cari judul atau nama peserta..." value="<?= htmlspecialchars($search) ?>">
    <select name="kategori">
      <option value="">Semua Kategori</option>
      <option value="Seni Rupa" <?= $kategori === 'Seni Rupa' ? 'selected' : '' ?>>Seni Rupa</option>
      <option value="Film" <?= $kategori === 'Film' ? 'selected' : '' ?>>Film</option>
      <option value="Desain" <?= $kategori === 'Desain' ? 'selected' : '' ?>>Desain</option>
    </select>
    <button type="submit" class="btn-login" style="border-radius: 12px; background: #4A0E17; border-color: #4A0E17;">Cari</button>
  </form>

  <div class="grid">
    <?php if ($result->num_rows === 0): ?>
      <div class="empty-state">
        <div class="icon">🔍</div>
        <p>Belum ada karya yang lolos kurasi atau tidak ada yang cocok dengan pencarian.</p>
                <a href="index.php" class="btn-login" style="margin-top: 20px; background: #4A0E17; border-color: #4A0E17;">Kembali ke Beranda</a>
        </a>
      </div>
    <?php endif; ?>

    <?php while ($k = $result->fetch_assoc()): ?>
      <a href="detail-karya.php?id=<?= $k['id'] ?>" class="karya-card">
        <?php if ($k['gambar']): ?>
          <img src="uploads/<?= htmlspecialchars($k['gambar']) ?>" class="thumb" alt="<?= htmlspecialchars($k['judul']) ?>">
        <?php else: ?>
          <div class="thumb" style="display:flex;align-items:center;justify-content:center;font-size:40px;">🖼️</div>
        <?php endif; ?>
        <div class="body">
          <h3><?= htmlspecialchars($k['judul']) ?></h3>
          <p class="meta"><?= htmlspecialchars($k['peserta_name']) ?> • <?= htmlspecialchars($k['kategori']) ?></p>
          <span class="badge-status badge-accepted">Accepted</span>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>