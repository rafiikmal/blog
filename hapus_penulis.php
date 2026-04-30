<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Opsional: Hapus file foto dari folder agar tidak menumpuk
    $ambil = $conn->query("SELECT foto FROM penulis WHERE id=$id");
    $data = $ambil->fetch_assoc();
    if ($data && $data['foto'] != "") {
        if (file_exists("uploads_penulis/" . $data['foto'])) {
            unlink("uploads_penulis/" . $data['foto']);
        }
    }

    // Perintah hapus dari database
    $sql = "DELETE FROM penulis WHERE id=$id";
    
    if ($conn->query($sql)) {
        echo "Data penulis berhasil dihapus!";
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }
}
?>