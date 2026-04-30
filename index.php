<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen Blog (CMS)</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f0f2f5; display: flex; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: white; height: 100vh; position: fixed; box-shadow: 2px 0 10px rgba(0,0,0,0.05); padding: 20px; box-sizing: border-box; }
        .sidebar h4 { color: #999; font-size: 12px; margin-bottom: 20px; letter-spacing: 1px; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li { margin-bottom: 10px; }
        .sidebar ul li a { text-decoration: none; color: #555; display: flex; align-items: center; padding: 12px; border-radius: 8px; transition: 0.3s; }
        .sidebar ul li a:hover { background: #f0fdf4; color: #2ecc71; }
        .sidebar ul li a.active { background: #f0fdf4; color: #2ecc71; border-left: 4px solid #2ecc71; }

        /* Main Content Area */
        .main-wrapper { margin-left: 260px; width: calc(100% - 260px); }
        .top-bar { background: #34495e; color: white; padding: 15px 40px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .content-container { padding: 40px; }
        
        /* Card Tampilan Putih (Tempat Tabel/Form) */
        .glass-card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); min-height: 400px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4>MENU UTAMA</h4>
        <ul>
            <li><a href="index.php?page=penulis" class="<?= (!isset($_GET['page']) || $_GET['page']=='penulis') ? 'active' : '' ?>">👤 Kelola Penulis</a></li>
            <li><a href="index.php?page=artikel" class="<?= ($_GET['page']=='artikel') ? 'active' : '' ?>">📝 Kelola Artikel</a></li>
            <li><a href="index.php?page=kategori" class="<?= ($_GET['page']=='kategori') ? 'active' : '' ?>">📁 Kelola Kategori</a></li>
        </ul>
    </div>

    <div class="main-wrapper">
        <div class="top-bar">
            <h2 style="margin:0;">Sistem Manajemen Blog (CMS)</h2>
            <span style="font-size: 12px; opacity: 0.7;">Blog Keren</span>
        </div>

        <div class="content-container">
            <div class="glass-card">
                <?php 
                // Logika pemanggilan file konten
                $hal = isset($_GET['page']) ? $_GET['page'] : 'penulis';

                if ($hal == 'penulis') {
                    if (file_exists('halaman_penulis.php')) {
                        include 'halaman_penulis.php';
                    } else {
                        echo "<p style='color:red;'>File halaman_penulis.php tidak ditemukan!</p>";
                    }
                } elseif ($hal == 'artikel') {
                    include 'halaman_artikel.php';
                } elseif ($hal == 'kategori') {
                    include 'halaman_kategori.php';
                }
                ?>
            </div>
        </div>
    </div>

</body>
</html>