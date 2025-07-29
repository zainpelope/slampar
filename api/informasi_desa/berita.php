<?php
header('Content-Type: application/json');
include '../../koneksi.php';

$per_page = 8;
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;

$sql_count = "SELECT COUNT(*) AS total FROM berita";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);

$sql = "SELECT * FROM berita LIMIT $start_from, $per_page";
$result = $conn->query($sql);

$berita = [];
while ($row = $result->fetch_assoc()) {
    $berita[] = [
        'id_berita' => $row['id_berita'],
        'judul' => $row['judul'],
        'tanggal' => $row['tanggal'],
        'keterangan' => $row['keterangan'],
        'gambar' => 'uploads/' . $row['gambar']
    ];
}

$response = [
    'halaman' => $halaman,
    'total_halaman' => $total_pages,
    'total_berita' => $total_records,
    'data' => $berita
];

echo json_encode($response, JSON_PRETTY_PRINT);
