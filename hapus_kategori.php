<?php include 'koneksi.php';
$id = $_GET['id'];
$conn->query("DELETE FROM kategori_artikel WHERE id=$id");
echo "Kategori berhasil dihapus!"; ?>