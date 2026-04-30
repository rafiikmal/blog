<?php 
include 'koneksi.php';

// Menambahkan alias 'cover' untuk kolom 'gambar' agar cocok dengan kode JavaScript
$sql = "SELECT 
            artikel.id, 
            artikel.judul, 
            artikel.isi, 
            artikel.gambar AS cover, 
            artikel.hari_tanggal,
            artikel.id_penulis,
            artikel.id_kategori,
            penulis.nama_depan, 
            kategori_artikel.nama_kategori 
        FROM artikel 
        JOIN penulis ON artikel.id_penulis = penulis.id 
        JOIN kategori_artikel ON artikel.id_kategori = kategori_artikel.id";

$res = $conn->query($sql);

if ($res) {
    // Mengambil semua data sebagai array asosiatif
    echo json_encode($res->fetch_all(MYSQLI_ASSOC)); 
} else {
    // Jika query gagal, kirim pesan error dalam format JSON
    echo json_encode(["error" => $conn->error]);
}
?>