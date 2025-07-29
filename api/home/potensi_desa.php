<?php
include '../../koneksi.php';

$sql = "SELECT * FROM potensi_desa";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(["status" => "success", "data" => $data]);
