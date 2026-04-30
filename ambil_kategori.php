<?php include 'koneksi.php';
$res = $conn->query("SELECT * FROM kategori_artikel");
echo json_encode($res->fetch_all(MYSQLI_ASSOC)); ?>