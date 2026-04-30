<?php
include 'koneksi.php';

$query = "SELECT * FROM penulis ORDER BY id DESC";
$result = $conn->query($query);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>