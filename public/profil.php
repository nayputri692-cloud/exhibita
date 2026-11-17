<?php
require 'config/db.php';
require 'includes/auth.php';
requireLogin(); // Wajib login

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Ambil data user saat ini
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $new_password = $_POST['password'];
  
  if (strlen($name) < 3) {
    $error = 'Nama minimal 3 karakter.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Format email tidak valid.';
  } else {
    // Cek apakah email sudah dipakai user lain
    $cek = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $cek->bind_param('si', $email, $user_id);
    $cek->execute();
    if ($cek->get_result()->fetch_assoc()) {
      $error = 'Email sudah digunakan oleh akun lain.';
    } else {
      // Update data
      if (!empty($new_password)) {
        if (strlen($new_password) < 8) {
          $error = 'Password baru minimal 8 karakter.';
        } else {
          $hash = password_hash($new_password, PASSWORD_DEFAULT);
          $stmt_up = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
          $stmt_up->bind_param('sssi', $name, $email, $hash, $user_id);
        }
      } else {
        $stmt_up = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt_up->bind_param('ssi', $name, $email, $user_id);
      }

      if (!isset($error) || empty($error)) {
        if ($stmt_up->execute()) {
          $_SESSION['user_name'] = $name; // Update session nama
          $success = 'Profil berhasil diperbarui!';
          $user['name'] = $name;
          $user['email'] = $email;
        } else {
          $error = 'Gagal memperbarui profil: ' . $conn->error;
        }
      }
    }
  }
}

include 'includes/header.php';
?>

<div class="page-wrap" style="padding-top: 40px;">
  <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-top: 4px solid var(--secondary);">
    
    <h1 class="page-title" style="text-align: center; margin-bottom: 8px;">Edit Profil</h1>
    <p class="page-subtitle" style="text-align: center; margin-bottom: 30px;">Perbarui informasi akun kamu di sini.</p>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
      </div>

      <div class="form-group">
        <label>Password Baru (Opsional)</label>
        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
        <small style="color: var(--gray); font-size: 12px;">*Minimal 8 karakter jika ingin diganti.</small>
      </div>

      <button type="submit" class="btn-primary" style="margin-top: 10px;">Simpan Perubahan</button>
    </form>
  </div>
</div>

<?php include 'includes/footer.php'; ?>