<?php 
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil nama gambar untuk dihapus dari folder
    $ambil = $conn->query("SELECT gambar FROM artikel WHERE id=$id");
    $data = $ambil->fetch_assoc();
    if ($data['gambar'] != "") {
        unlink("uploads_artikel/" . $data['gambar']);
    }

    $sql = "DELETE FROM artikel WHERE id=$id";
    if ($conn->query($sql)) {
        echo "Artikel berhasil dihapus!";
    } else {
        echo "Gagal menghapus: " . $conn->error;
    }
}
?>