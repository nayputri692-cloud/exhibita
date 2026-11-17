<?php
require 'config/db.php';
require 'includes/auth.php';
requireRole('MAHASISWA');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $event_id = (int)$_POST['event_id'];
  $judul = trim($_POST['judul']);
  $deskripsi = trim($_POST['deskripsi']);
  $medium = trim($_POST['medium']);
  $kategori = $_POST['kategori'];
  $gambar = null;

  // Upload gambar
  if (!empty($_FILES['gambar']['name'])) {
    $allowed = ['image/jpeg', 'image/png'];
    $mime = mime_content_type($_FILES['gambar']['tmp_name']);
    if (!in_array($mime, $allowed)) {
      $error = 'Hanya JPG/PNG yang diizinkan.';
    } elseif ($_FILES['gambar']['size'] > 5 * 1024 * 1024) {
      $error = 'Maksimal 5MB.';
    } else {
      $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
      $gambar = uniqid('karya_') . '.' . $ext;
      move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar);
    }
  } else {
    $error = 'Gambar wajib diupload.';
  }

  if (!$error) {
    $stmt = $conn->prepare("INSERT INTO karya (event_id, user_id, judul, deskripsi, medium, kategori, gambar) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('iisssss', $event_id, $_SESSION['user_id'], $judul, $deskripsi, $medium, $kategori, $gambar);
    if ($stmt->execute()) {
      $success = 'Karya berhasil didaftarkan! Menunggu kurasi panitia.';
    } else {
      $error = 'Gagal menyimpan: ' . $conn->error;
    }
  }
}

// Ambil event published
$events = $conn->query("SELECT id, nama FROM events WHERE status = 'PUBLISHED' ORDER BY tanggal DESC");

include 'includes/header.php';
?>

<div class="page-wrap">
  <h1 class="page-title">Daftarkan Karya</h1>
  <p class="page-subtitle">Upload karya terbaikmu dan tunggu proses kurasi.</p>

  <?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" style="max-width:640px;">
    <div class="form-group">
      <label>Event</label>
      <select name="event_id" required>
        <option value="">-- Pilih Event --</option>
        <?php while ($e = $events->fetch_assoc()): ?>
          <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nama']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="form-group">
      <label>Judul Karya</label>
      <input type="text" name="judul" required>
    </div>

    <div class="form-group">
      <label>Deskripsi</label>
      <textarea name="deskripsi" required></textarea>
    </div>

    <div class="form-group">
      <label>Medium</label>
      <input type="text" name="medium" placeholder="mis. Akrilik di Kanvas" required>
    </div>

    <div class="form-group">
      <label>Kategori</label>
      <select name="kategori" required>
        <option value="Seni Rupa">Seni Rupa</option>
        <option value="Film">Film</option>
        <option value="Desain">Desain</option>
      </select>
    </div>

    <div class="form-group">
      <label>Gambar Karya (JPG/PNG, max 5MB)</label>
      <input type="file" name="gambar" accept="image/jpeg,image/png" required>
    </div>

    <button type="submit" class="btn-primary">Submit Karya</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>