<?php include 'koneksi.php';
$nama = $_POST['nama_kategori']; $ket = $_POST['keterangan'];
$conn->query("INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES ('$nama', '$ket')");
echo "Kategori berhasil disimpan!"; ?>