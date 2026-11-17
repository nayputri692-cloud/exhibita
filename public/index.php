<?php 
// Navbar disembunyikan di landing page
// include 'includes/header.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EXHIBITA</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<!-- Seluruh body diberi background gradasi Pink Susu -->
<body style="background: linear-gradient(135deg, #FAF5F6 0%, #F2E3E6 50%, #E6D3D8 100%); margin: 0; overflow-x: hidden;">

  <!-- Ornamen Cahaya (Blur) di background belakang -->
  <div style="position: fixed; top: -100px; left: -100px; width: 400px; height: 400px; background: rgba(255, 255, 255, 0.5); border-radius: 50%; filter: blur(80px); z-index: -1;"></div>
  <div style="position: fixed; bottom: -100px; right: -100px; width: 500px; height: 500px; background: rgba(230, 168, 182, 0.4); border-radius: 50%; filter: blur(100px); z-index: -1;"></div>

  <!-- 1. HERO SECTION -->
  <section style="position: relative; display: flex; align-items: center; justify-content: center; min-height: 80vh; background: url('img/hero.jpg') center/cover no-repeat; padding: 100px 24px; margin-bottom: 60px;">
    <div style="position: absolute; inset: 0; background: rgba(0, 0, 0, 0.4); z-index: 1;"></div>
    
    <div style="position: relative; z-index: 2; text-align: center; max-width: 900px; margin: 0 auto;">
      <h1 style="font-size: clamp(40px, 6vw, 72px); text-transform: uppercase; letter-spacing: 2px; color: #fff !important; text-shadow: 0 4px 20px rgba(0,0,0,0.8); font-weight: 900; line-height: 1.1; margin: 0;">
        HOUSE OF EXHIBITA
      </h1>
      <p style="font-size: 20px; margin-top: 20px; color: #fff !important; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
        Mengubah cara pandang masyarakat tentang karya mahasiswa.
      </p>
      <div style="display: flex; justify-content: center; gap: 16px; margin-top: 40px; flex-wrap: wrap;">
        <a href="katalog.php" style="background: #4A0E17; border: 2px solid #4A0E17; padding: 14px 32px; font-size: 16px; font-weight: bold; border-radius: 999px; text-decoration: none; color: #fff; box-shadow: 0 4px 15px rgba(74, 14, 23, 0.4); transition: all 0.3s;">Jelajahi Katalog</a>
        <a href="login.php" style="background: #4A0E17; border: 2px solid #4A0E17; padding: 14px 32px; font-size: 16px; font-weight: bold; border-radius: 999px; text-decoration: none; color: #fff; box-shadow: 0 4px 15px rgba(74, 14, 23, 0.4); transition: all 0.3s;">Login</a>
      </div>
    </div>
  </section>

  <!-- 2. PAMERAN UNGGULAN (Card Kaca) -->
  <section style="padding: 60px 24px; position: relative; z-index: 10;">
    <div style="max-width: 1200px; margin: 0 auto;">
      <h2 style="text-align: center; font-size: 28px; font-weight: 800; color: #4A0E17; margin-bottom: 40px; text-transform: uppercase; letter-spacing: 2px;">
        Pameran Unggulan
      </h2>
      
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
        <!-- Card 1 -->
        <div style="background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(74, 14, 23, 0.08); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
          <img src="img/pameran1.jpg" alt="Seni Rupa" style="height: 200px; object-fit: cover; width: 100%;">
          <div style="padding: 24px;">
            <h3 style="color: #4A0E17; margin-bottom: 10px; font-size: 20px;">Pameran Seni Rupa 2025</h3>
            <p style="font-size: 14px; color: #4B5563; margin-bottom: 16px; line-height: 1.6;">Pameran karya lukis & patung mahasiswa dari berbagai angkatan.</p>
            <a href="katalog.php" style="color: #4A0E17; font-weight: 700; font-size: 14px; text-decoration: none;">Read More...</a>
          </div>
        </div>
        
        <!-- Card 2 -->
        <div style="background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(74, 14, 23, 0.08); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
          <img src="img/pameran2.jpg" alt="Film Pendek" style="height: 200px; object-fit: cover; width: 100%;">
          <div style="padding: 24px;">
            <h3 style="color: #4A0E17; margin-bottom: 10px; font-size: 20px;">Showcase Film Pendek</h3>
            <p style="font-size: 14px; color: #4B5563; margin-bottom: 16px; line-height: 1.6;">Karya sinematik mahasiswa FIKOM yang penuh dengan cerita.</p>
            <a href="katalog.php" style="color: #4A0E17; font-weight: 700; font-size: 14px; text-decoration: none;">Read More...</a>
          </div>
        </div>
        
        <!-- Card 3 -->
        <div style="background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(74, 14, 23, 0.08); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
          <img src="img/pameran3.jpg" alt="Desain UI/UX" style="height: 200px; object-fit: cover; width: 100%;">
          <div style="padding: 24px;">
            <h3 style="color: #4A0E17; margin-bottom: 10px; font-size: 20px;">Desain UI/UX Expo</h3>
            <p style="font-size: 14px; color: #4B5563; margin-bottom: 16px; line-height: 1.6;">Prototipe & studi kasus desain digital masa depan.</p>
            <a href="katalog.php" style="color: #4A0E17; font-weight: 700; font-size: 14px; text-decoration: none;">Read More...</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. TENTANG PAMERAN -->
  <section style="padding: 60px 24px; position: relative; z-index: 10;">
    <div style="max-width: 1200px; margin: 0 auto;">
      <h2 style="text-align: center; font-size: 28px; font-weight: 800; color: #4A0E17; margin-bottom: 40px; text-transform: uppercase; letter-spacing: 2px;">
        Tentang Pameran
      </h2>
      
      <div style="display: flex; flex-wrap: wrap; gap: 40px; align-items: center;">
        <!-- Kotak Kaca Teks -->
        <div style="flex: 1; min-width: 300px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); padding: 40px; border-radius: 24px; box-shadow: 0 20px 40px rgba(74, 14, 23, 0.08); position: relative; z-index: 2; margin-right: -50px;">
          <h3 style="font-size: 26px; color: #4A0E17; margin-bottom: 16px; font-weight: 800;">The History of EXHIBITA</h3>
          <p style="color: #4B5563; line-height: 1.8; margin-bottom: 24px; font-size: 15px;">
            EXHIBITA adalah platform pameran digital yang menjembatani karya mahasiswa dengan apresiasi publik. Kami percaya bahwa setiap karya memiliki cerita, dan setiap mahasiswa berhak untuk menunjukkan hasil kerja keras mereka ke panggung yang lebih luas.
          </p>
          <a href="#" style="background: #4A0E17; color: #fff; padding: 12px 28px; border-radius: 999px; text-decoration: none; font-weight: 600; font-size: 14px; box-shadow: 0 4px 15px rgba(74, 14, 23, 0.3);">Read More...</a>
        </div>
        <!-- Gambar -->
        <div style="flex: 2; min-width: 300px;">
          <img src="img/pameran4.jpg" alt="Suasana Pameran" style="width: 100%; height: 450px; object-fit: cover; border-radius: 24px; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
        </div>
      </div>
    </div>
  </section>

    <!-- 4. GALERI FOTO -->
  <section style="padding: 60px 24px; position: relative; z-index: 10;">
    <div style="max-width: 1200px; margin: 0 auto;">
      <h2 style="text-align: center; font-size: 24px; font-weight: 800; color: #4A0E17; margin-bottom: 30px; text-transform: uppercase; letter-spacing: 1px;">
        Galeri Suasana Pameran
      </h2>
      
      <!-- Grid Galeri Diubah -->
      <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
        <?php for($i=1; $i<=8; $i++): ?>
          <img src="img/galeri<?= $i ?>.jpg" alt="Galeri" 
               style="width: 100%; max-width: 260px; aspect-ratio: 1; object-fit: cover; border-radius: 16px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); transition: transform 0.3s; cursor: pointer;" 
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
        <?php endfor; ?>
      </div>
      
    </div>
  </section>

  <!-- 5. FOOTER BESAR (3 Kolom) -->
  <section style="background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(20px); border-top: 1px solid rgba(255,255,255,0.5); padding: 60px 24px; position: relative; z-index: 10; margin-top: 40px;">
    <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px;">
      
      <div>
        <h4 style="font-size: 20px; font-weight: 800; margin-bottom: 20px; color: #4A0E17;">Latest Posts</h4>
        <ul style="list-style: none; padding: 0; color: #4B5563; font-size: 14px; line-height: 2;">
          <li>• Karya Lukisan Senja Kota</li>
          <li>• Film Pendek Jalan Pulang</li>
          <li>• Desain UI Aplikasi Kasir</li>
          <li>• Fotografi Urban Malam</li>
        </ul>
      </div>

      <div>
        <h4 style="font-size: 20px; font-weight: 800; margin-bottom: 20px; color: #4A0E17;">Mostly Viewed</h4>
        <ul style="list-style: none; padding: 0; color: #4B5563; font-size: 14px; line-height: 2;">
          <li>• Sejarah Pameran EXHIBITA</li>
          <li>• Galeri Pameran Seni Rupa</li>
          <li>• Karya Film Terbaik 2025</li>
          <li>• Pemenang Desain UI/UX</li>
        </ul>
      </div>

      <div>
        <h4 style="font-size: 20px; font-weight: 800; margin-bottom: 20px; color: #4A0E17;">Any Question</h4>
        <form style="display: flex; flex-direction: column; gap: 12px;">
          <input type="text" placeholder="NAME" style="padding: 12px; border-radius: 8px; border: none; background: rgba(255,255,255,0.7); font-weight: 600; outline: none;">
          <input type="email" placeholder="EMAIL" style="padding: 12px; border-radius: 8px; border: none; background: rgba(255,255,255,0.7); font-weight: 600; outline: none;">
          <textarea placeholder="MESSAGE" rows="3" style="padding: 12px; border-radius: 8px; border: none; background: rgba(255,255,255,0.7); font-weight: 600; outline: none; resize: none;"></textarea>
          <button type="submit" style="background: #4A0E17; color: #fff; padding: 12px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </section>

</body>
</html>