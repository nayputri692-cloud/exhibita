<?php
require 'config/db.php';
require 'includes/auth.php';

// Kunci halaman ini HANYA untuk ADMIN
requireRole('ADMIN');

$pesan = '';

// Proses Hapus User
if (isset($_GET['hapus'])) {
  $id_hapus = (int)$_GET['hapus'];
  if ($id_hapus !== $_SESSION['user_id']) { // Cegah admin hapus diri sendiri
    $conn->query("DELETE FROM users WHERE id = $id_hapus");
    $pesan = 'Pengguna berhasil dihapus.';
  }
}

// Proses Ubah Role
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ubah_role'])) {
  $id_user = (int)$_POST['user_id'];
  $role_baru = $_POST['role'];
  $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
  $stmt->bind_param('si', $role_baru, $id_user);
  $stmt->execute();
  $pesan = 'Role pengguna berhasil diubah.';
}

$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");

include 'includes/header.php';
?>

<div class="page-wrap" style="padding-top: 40px;">
  <h1 class="page-title">Kelola Pengguna</h1>
  <p class="page-subtitle">Halaman khusus Admin untuk mengatur akun pengguna sistem.</p>

  <?php if ($pesan): ?>
    <div class="alert alert-success"><?= htmlspecialchars($pesan) ?></div>
  <?php endif; ?>

  <div class="table-wrap" style="background: #fff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden;">
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Role Saat Ini</th>
          <th>Ubah Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($u = $users->fetch_assoc()): ?>
          <tr>
            <td><strong><?= htmlspecialchars($u['name']) ?></strong></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td>
              <span class="badge-status" style="background: #E5E7EB; color: #111827;"><?= $u['role'] ?></span>
            </td>
            <td>
              <!-- Form ubah role -->
              <form method="POST" style="display: flex; gap: 8px;">
                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                <input type="hidden" name="ubah_role" value="1">
                <select name="role" style="padding: 6px; border-radius: 6px; border: 1px solid #ddd;">
                  <option value="MAHASISWA" <?= $u['role'] === 'MAHASISWA' ? 'selected' : '' ?>>Mahasiswa</option>
                  <option value="PANITIA" <?= $u['role'] === 'PANITIA' ? 'selected' : '' ?>>Panitia</option>
                  <option value="ADMIN" <?= $u['role'] === 'ADMIN' ? 'selected' : '' ?>>Admin</option>
                </select>
                <button type="submit" class="btn-sm btn-view" style="padding: 6px 12px;">Simpan</button>
              </form>
            </td>
            <td>
              <?php if ($u['id'] !== $_SESSION['user_id']): ?>
                <a href="admin-users.php?hapus=<?= $u['id'] ?>" class="btn-sm btn-reject" style="text-decoration:none;" onclick="return confirm('Yakin hapus user ini?');">Hapus</a>
              <?php else: ?>
                <span style="font-size: 12px; color: var(--gray);">(Anda)</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>