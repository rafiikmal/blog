<?php 
include 'koneksi.php';

// Menangkap data dari form
$id    = $_POST['id']; 
$judul = $_POST['judul'];
$id_p  = $_POST['id_penulis'];
$id_k  = $_POST['id_kategori'];
$isi   = $_POST['isi_artikel']; 

// Cek apakah ada upload gambar baru
if (!empty($_FILES['cover']['name'])) {
    $cover = $_FILES['cover']['name'];
    $tmp   = $_FILES['cover']['tmp_name'];
    
    // Pindahkan file ke folder uploads
    if (move_uploaded_file($tmp, "uploads_artikel/" . $cover)) {
        // Update dengan gambar baru
        $sql = "UPDATE artikel SET judul='$judul', isi='$isi', id_penulis='$id_p', id_kategori='$id_k', gambar='$cover' WHERE id=$id";
    } else {
        die("Gagal mengupload gambar.");
    }
} else {
    // Update tanpa mengubah gambar
    $sql = "UPDATE artikel SET judul='$judul', isi='$isi', id_penulis='$id_p', id_kategori='$id_k' WHERE id=$id";
}

if ($conn->query($sql)) {
    echo "Perubahan berhasil disimpan!";
} else {
    echo "Error Database: " . $conn->error;
}
?>