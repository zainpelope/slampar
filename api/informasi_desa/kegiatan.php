<?php
header("Content-Type: application/json");
include '../../koneksi.php';

$per_page = 5;
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;

$sql_count = "SELECT COUNT(*) AS total FROM kegiatan";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);

$sql = "SELECT * FROM kegiatan LIMIT $start_from, $per_page";
$result = $conn->query($sql);

$kegiatan = [];

while ($row = $result->fetch_assoc()) {
    $kegiatan[] = [
        "id_kegiatan" => $row["id_kegiatan"],
        "gambar" => "uploads/" . $row["gambar"],
        "nama_kegiatan" => $row["nama_kegiatan"],
        "keterangan" => $row["keterangan"],
        "tanggal_mulai" => date("d-m-Y", strtotime($row["tanggal_mulai"])),
        "tanggal_selesai" => date("d-m-Y", strtotime($row["tanggal_selesai"])),
        "lokasi" => $row["lokasi"]
    ];
}

$response = [
    "current_page" => $halaman,
    "total_pages" => $total_pages,
    "total_records" => $total_records,
    "per_page" => $per_page,
    "data" => $kegiatan
];

echo json_encode($response, JSON_PRETTY_PRINT);
