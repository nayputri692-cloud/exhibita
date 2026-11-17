CREATE DATABASE IF NOT EXISTS exhibita CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE exhibita;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('ADMIN','PANITIA','MAHASISWA') NOT NULL DEFAULT 'MAHASISWA',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(200) NOT NULL,
  deskripsi TEXT NOT NULL,
  lokasi VARCHAR(200) NOT NULL,
  tanggal DATE NOT NULL,
  kategori VARCHAR(100) NOT NULL,
  poster VARCHAR(255) DEFAULT NULL,
  status ENUM('DRAFT','PUBLISHED') DEFAULT 'PUBLISHED',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE karya (
  id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT NOT NULL,
  user_id INT NOT NULL,
  judul VARCHAR(200) NOT NULL,
  deskripsi TEXT NOT NULL,
  medium VARCHAR(150) NOT NULL,
  kategori VARCHAR(100) NOT NULL,
  gambar VARCHAR(255) DEFAULT NULL,
  status ENUM('SUBMITTED','ACCEPTED','REJECTED') DEFAULT 'SUBMITTED',
  catatan TEXT DEFAULT NULL,
  booth VARCHAR(100) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Seed user (password: admin123 / panitia123 / mhs12345)
INSERT INTO users (name, email, password, role) VALUES
('Admin Exhibita', 'admin@exhibita.id', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HcKMUlgk8Vf7zYqo0qH9mZ1s2b3c4d', 'ADMIN'),
('Rangga Panitia', 'panitia@exhibita.id', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HcKMUlgk8Vf7zYqo0qH9mZ1s2b3c4d', 'PANITIA'),
('Sinta Mahasiswa', 'mahasiswa@exhibita.id', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HcKMUlgk8Vf7zYqo0qH9mZ1s2b3c4d', 'MAHASISWA');

INSERT INTO events (nama, deskripsi, lokasi, tanggal, kategori) VALUES
('Pameran Seni Rupa 2025', 'Pameran karya lukis & patung mahasiswa.', 'Gedung A Kampus', '2025-06-10', 'Seni Rupa'),
('Showcase Film Pendek', 'Karya sinematik mahasiswa FIKOM.', 'Aula B', '2025-07-15', 'Film'),
('Desain UI/UX Expo', 'Prototipe & studi kasus desain digital.', 'Lab Desain', '2025-08-20', 'Desain');