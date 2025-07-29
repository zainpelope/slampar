<?php
header("Content-Type: application/json");
include '../../koneksi.php';

$per_page = 5;
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;

$sql_count = "SELECT COUNT(*) AS total FROM pengumuman";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);

$sql = "SELECT * FROM pengumuman ORDER BY tanggal DESC LIMIT $start_from, $per_page";
$result = $conn->query($sql);

$pengumuman = [];

while ($row = $result->fetch_assoc()) {
    $pengumuman[] = [
        "id_pengumuman" => $row["id_pengumuman"],
        "judul" => $row["judul"],
        "keterangan" => $row["keterangan"],
        "tanggal" => date("d-m-Y", strtotime($row["tanggal"])),
        "detail_url" => "detail.php?id=" . $row['id_pengumuman']
    ];
}

$response = [
    "current_page" => $halaman,
    "total_pages" => $total_pages,
    "total_records" => $total_records,
    "per_page" => $per_page,
    "data" => $pengumuman
];

echo json_encode($response, JSON_PRETTY_PRINT);
