<?php 
include 'koneksi.php';

// Ambil data dari form
$judul = $_POST['judul']; 
$id_p  = $_POST['id_penulis']; 
$id_k  = $_POST['id_kategori']; 
$isi   = $_POST['isi_artikel'];

// Buat format tanggal sesuai gambar referensi (Contoh: Kamis, 30 April 2026 | 00:15)
// Kita set locale ke Indonesia agar nama harinya bahasa Indonesia
setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id_ID.utf8', 'Indonesian');
$hari_tanggal = date('l, d F Y | H:i'); 

// Urusan Gambar
$nama_file = $_FILES['cover']['name'];
$tmp_file  = $_FILES['cover']['tmp_name'];

// Pindahkan file ke folder tujuan
move_uploaded_file($tmp_file, "uploads_artikel/" . $nama_file);

// Query INSERT disesuaikan dengan nama kolom di CMD kamu:
// kolom: judul, isi, gambar, hari_tanggal, id_penulis, id_kategori
$sql = "INSERT INTO artikel (judul, isi, gambar, hari_tanggal, id_penulis, id_kategori) 
        VALUES ('$judul', '$isi', '$nama_file', '$hari_tanggal', '$id_p', '$id_k')";

if ($conn->query($sql)) {
    echo "Artikel berhasil disimpan!";
} else {
    echo "Gagal menyimpan: " . $conn->error;
}
?>