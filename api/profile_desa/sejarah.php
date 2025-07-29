<?php
header('Content-Type: application/json');
include('../../koneksi.php');

$per_page = isset($_GET['per_page']) ? (int) $_GET['per_page'] : 5;
$halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;

$sql_count = "SELECT COUNT(*) AS total FROM sejarah";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);

$query = "SELECT * FROM sejarah ORDER BY id_sejarah DESC LIMIT $start_from, $per_page";
$result = $conn->query($query);

$sejarah_data = [];
while ($row = $result->fetch_assoc()) {
    $sejarah_data[] = [
        'id_sejarah' => $row['id_sejarah'],
        'gambar' => "uploads/" . $row['gambar'],
        'keterangan' => $row['keterangan']
    ];
}

$response = [
    'status' => 'success',
    'halaman' => $halaman,
    'per_page' => $per_page,
    'total_records' => $total_records,
    'total_pages' => $total_pages,
    'data' => $sejarah_data
];

echo json_encode($response);
