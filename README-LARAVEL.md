# EXHIBITA — versi Laravel

Folder ini adalah **lapisan (overlay) Laravel** untuk project EXHIBITA: isinya hanya file yang
spesifik untuk aplikasi (controller, model, view, route, migration, aset). Folder `vendor/`
dan inti framework dibuat oleh Composer di langkah 1.

## Cara pasang

1. Buat project Laravel baru (butuh PHP 8.2+ dan Composer):

       composer create-project laravel/laravel exhibita
       cd exhibita

2. Salin **seluruh isi** zip ini ke dalam folder `exhibita`, timpa file yang sudah ada
   (`bootstrap/app.php`, `routes/web.php`, `database/seeders/DatabaseSeeder.php`,
   migration `0001_01_01_000000_create_users_table.php`, dst.).

3. Atur `.env`:

       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=exhibita
       DB_USERNAME=root
       DB_PASSWORD=

4. Siapkan database:

   - **Database baru / kosong**  ->  `php artisan migrate --seed`
   - **Sudah punya database `exhibita` dari versi lama**  ->  `php artisan migrate`
     (tabel yang sudah ada dilewati; hanya kolom `karya.views` yang ditambahkan bila belum ada).
     Jangan jalankan `--seed` agar data lama tidak tercampur.

5. Jalankan: `php artisan serve` lalu buka http://127.0.0.1:8000

Akun contoh dari seeder: `admin@exhibita.id / admin123`, `panitia@exhibita.id / panitia123`,
`mahasiswa@exhibita.id / mhs12345`.

## Peta file lama -> Laravel

| File lama | Sekarang |
|---|---|
| `index.php` | route `/` -> `resources/views/pages/index.blade.php` |
| `login.php`, `register.php`, `logout.php` | `AuthController` + `views/auth/*` |
| `dashboard.php` | `DashboardController` |
| `katalog.php`, `detail-karya.php`, `detail-event.php`, `jadwal.php` | `KatalogController` / view `pages/*` |
| `daftar-karya.php`, `karya-saya.php`, `edit-karya.php` | `KaryaController` + `views/karya/*` |
| `kurasi.php`, `review-kurasi.php` | `KurasiController` + `views/kurasi/*` |
| `admin-users.php` | `AdminUserController` + `views/admin/users` |
| `profil.php` | `ProfilController` |
| `includes/header.php`, `footer.php` | `views/partials/*` + `views/layouts/app.blade.php` |
| `includes/auth.php` | Auth Laravel + middleware `role` (`app/Http/Middleware/RoleMiddleware.php`) |
| `config/db.php` | `.env` |
| `css/`, `js/`, `img/`, `uploads/` | `public/css`, `public/js`, `public/img`, `public/uploads` |

## Yang sengaja disesuaikan (tampilan & alur tetap sama)

- Semua link/aset memakai `route()` dan `asset()`, jadi URL berubah dari `katalog.php` menjadi `/katalog`, dst.
- Form POST diberi `@csrf` (wajib di Laravel). Tombol **Hapus** karya & user tetap berupa link
  dengan konfirmasi yang sama, tapi sekarang mengirim request `DELETE` lewat form tersembunyi
  (sebelumnya `?hapus=ID` lewat GET).
- `public/js/script.js`: selector tombol logout diubah dari `a[href="logout.php"]` ke `a[href$="/logout"]`.
- Ekstensi file upload kini diambil dari isi file yang divalidasi (JPG/PNG), bukan dari nama file kiriman user.
- Kolom `views` pada tabel `karya` dipakai `detail-karya.php` tetapi tidak ada di `database.sql`;
  sekarang ditambahkan lewat migration.
- Hash password di `database.sql` tampak seperti placeholder; seeder membuat hash yang valid.
