// Validasi form sederhana di client side
document.addEventListener('DOMContentLoaded', () => {
  // Preview gambar sebelum upload
  const fileInput = document.querySelector('input[type="file"][name="gambar"]');
  if (fileInput) {
    fileInput.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (!file) return;
      if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran file maksimal 5MB.');
        e.target.value = '';
        return;
      }
      if (!['image/jpeg', 'image/png'].includes(file.type)) {
        alert('Hanya JPG/PNG yang diizinkan.');
        e.target.value = '';
      }
    });
  }

  // Konfirmasi logout
  const logoutBtn = document.querySelector('a[href$="/logout"]');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', (e) => {
      if (!confirm('Yakin ingin logout?')) e.preventDefault();
    });
  }
});