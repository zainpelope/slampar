<?php
header('Content-Type: application/json');
include('../../koneksi.php');

$visi_query = "SELECT isi FROM visi";
$visi_result = $conn->query($visi_query);
$visi_text = "";
while ($row = $visi_result->fetch_assoc()) {
    $visi_text .= $row['isi'] . " ";
}
$visi_text = trim($visi_text);

$misi_query = "SELECT isi FROM misi";
$misi_result = $conn->query($misi_query);
$misi = [];
while ($row = $misi_result->fetch_assoc()) {
    $misi[] = $row['isi'];
}

$response = [
    'status' => 'success',
    'visi' => $visi_text,
    'misi' => $misi
];

echo json_encode($response);
