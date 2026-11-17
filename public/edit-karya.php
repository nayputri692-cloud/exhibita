<?php
require 'config/db.php';
require 'includes/auth.php';
requireRole('MAHASISWA');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'];

// Ambil data karya yang mau diedit
$stmt = $conn->prepare("SELECT * FROM karya WHERE id = ? AND user_id = ?");
$stmt->bind_param('ii', $id, $user_id);
$stmt->execute();
$karya = $stmt->get_result()->fetch_assoc();

// Jika karya tidak ditemukan atau bukan milik user ini
if (!$karya) {
  header('Location: karya-saya.php');
  exit;
}

$error = '';
$success = '';

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $judul = trim($_POST['judul']);
  $deskripsi = trim($_POST['deskripsi']);
  $medium = trim($_POST['medium']);
  $kategori = $_POST['kategori'];
  $gambar_baru = $karya['gambar']; // Default pakai gambar lama

  // Cek kalau user upload gambar baru
  if (!empty($_FILES['gambar']['name'])) {
    $allowed = ['image/jpeg', 'image/png'];
    $mime = mime_content_type($_FILES['gambar']['tmp_name']);
    
    if (!in_array($mime, $allowed)) {
      $error = 'Hanya JPG/PNG yang diizinkan.';
    } elseif ($_FILES['gambar']['size'] > 5 * 1024 * 1024) {
      $error = 'Maksimal 5MB.';
    } else {
      $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
      $gambar_baru = uniqid('karya_') . '.' . $ext;
      
      if (move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar_baru)) {
        // Hapus gambar lama kalau ada
        if (!empty($karya['gambar']) && file_exists('uploads/' . $karya['gambar'])) {
          unlink('uploads/' . $karya['gambar']);
        }
      } else {
        $error = 'Gagal mengupload gambar baru.';
        $gambar_baru = $karya['gambar']; // Balikin ke gambar lama
      }
    }
  }

  if (!$error) {
    // Update database, kembalikan status ke SUBMITTED agar dikurasi ulang
    $stmt_update = $conn->prepare("UPDATE karya SET judul = ?, deskripsi = ?, medium = ?, kategori = ?, gambar = ?, status = 'SUBMITTED', catatan = NULL WHERE id = ? AND user_id = ?");
    $stmt_update->bind_param('sssssii', $judul, $deskripsi, $medium, $kategori, $gambar_baru, $id, $user_id);
    
    if ($stmt_update->execute()) {
      $success = 'Karya berhasil diperbarui! Status dikembalikan ke SUBMITTED untuk kurasi ulang.';
      // Refresh data
      $karya['judul'] = $judul;
      $karya['deskripsi'] = $deskripsi;
      $karya['medium'] = $medium;
      $karya['kategori'] = $kategori;
      $karya['gambar'] = $gambar_baru;
      $karya['status'] = 'SUBMITTED';
    } else {
      $error = 'Gagal memperbarui data: ' . $conn->error;
    }
  }
}

include 'includes/header.php';
?>

<div class="page-wrap">
  <div style="margin-bottom: 20px;">
    <a href="karya-saya.php" style="display: inline-flex; align-items: center; gap: 8px; color: var(--gray); font-weight: 600; text-decoration: none;">
      <span style="font-size: 20px;">←</span> Kembali ke Karya Saya
    </a>
  </div>

  <h1 class="page-title">Edit Karya</h1>
  <p class="page-subtitle">Perbarui detail karyamu. Mengedit karya akan mereset status kurasi menjadi "Menunggu".</p>

  <?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" style="max-width:640px;">
    
    <div class="form-group">
      <label>Judul Karya</label>
      <input type="text" name="judul" value="<?= htmlspecialchars($karya['judul']) ?>" required>
    </div>

    <div class="form-group">
      <label>Deskripsi</label>
      <textarea name="deskripsi" required><?= htmlspecialchars($karya['deskripsi']) ?></textarea>
    </div>

    <div class="form-group">
      <label>Medium</label>
      <input type="text" name="medium" value="<?= htmlspecialchars($karya['medium']) ?>" required>
    </div>

    <div class="form-group">
      <label>Kategori</label>
      <select name="kategori" required>
        <option value="Seni Rupa" <?= $karya['kategori'] === 'Seni Rupa' ? 'selected' : '' ?>>Seni Rupa</option>
        <option value="Film" <?= $karya['kategori'] === 'Film' ? 'selected' : '' ?>>Film</option>
        <option value="Desain" <?= $karya['kategori'] === 'Desain' ? 'selected' : '' ?>>Desain</option>
      </select>
    </div>

    <div class="form-group">
      <label>Gambar Karya (JPG/PNG, max 5MB)</label>
      <?php if ($karya['gambar'] && file_exists('uploads/' . $karya['gambar'])): ?>
        <div style="margin-bottom: 10px;">
          <img src="uploads/<?= htmlspecialchars($karya['gambar']) ?>" style="width: 150px; border-radius: 8px;">
          <p style="font-size: 12px; color: var(--gray);">*Biarkan kosong jika tidak ingin mengganti gambar.</p>
        </div>
      <?php endif; ?>
      <input type="file" name="gambar" accept="image/jpeg,image/png">
    </div>

    <button type="submit" class="btn-primary">Simpan Perubahan</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>