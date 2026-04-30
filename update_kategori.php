<?php include 'koneksi.php';
$id = $_POST['id']; $nama = $_POST['nama_kategori']; $ket = $_POST['keterangan'];
$conn->query("UPDATE kategori_artikel SET nama_kategori='$nama', keterangan='$ket' WHERE id=$id");
echo "Kategori berhasil diperbarui!"; ?>