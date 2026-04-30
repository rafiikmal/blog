<?php
include 'koneksi.php';

$id = $_POST['id'];
$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name = $_POST['user_name'];
$password = $_POST['password'];

// Logika jika user mengganti foto
if ($_FILES['foto']['name'] != "") {
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp, "uploads_penulis/" . $foto);
    
    // Update data termasuk foto baru
    $sql = "UPDATE penulis SET nama_depan='$nama_depan', nama_belakang='$nama_belakang', user_name='$user_name', foto='$foto' WHERE id=$id";
} else {
    // Update data tanpa mengganti foto lama
    $sql = "UPDATE penulis SET nama_depan='$nama_depan', nama_belakang='$nama_belakang', user_name='$user_name' WHERE id=$id";
}

// Logika jika password diisi (artinya user mau ganti password)
if (!empty($password)) {
    $conn->query("UPDATE penulis SET password='$password' WHERE id=$id");
}

if ($conn->query($sql)) {
    echo "Data penulis berhasil diperbarui!";
} else {
    echo "Gagal memperbarui: " . $conn->error;
}
?>