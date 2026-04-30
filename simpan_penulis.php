<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// Menangkap data dari Fetch API
$nama_depan    = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name     = $_POST['user_name'];
$password      = password_hash($_POST['password'], PASSWORD_BCRYPT); // Enkripsi BCrypt

$foto_nama = 'default.png';

// Logika Upload Foto
if (!empty($_FILES['foto']['tmp_name'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($_FILES['foto']['tmp_name']);
    
    // Validasi: Harus gambar & ukuran < 2MB
    if (strpos($mime, 'image/') === 0 && $_FILES['foto']['size'] <= 2000000) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_nama = time() . "_" . $user_name . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads_penulis/' . $foto_nama);
    }
}

// Prepared Statement untuk keamanan SQL Injection
$stmt = $conn->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nama_depan, $nama_belakang, $user_name, $password, $foto_nama);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}
?>