<?php
header("Content-Type: application/json");
include '../../koneksi.php';

$id_pengguna = isset($_GET['id_pengguna']) ? $_GET['id_pengguna'] : '';

if (empty($id_pengguna)) {
    echo json_encode(["status" => "error", "message" => "ID Pengguna tidak ditemukan"]);
    exit();
}

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$where = $cari ? "AND jenis_surat LIKE '%$cari%'" : "";

// Menghapus batasan halaman
$query_surat = "SELECT * FROM pengajuan_surat WHERE id_pengguna = '$id_pengguna' $where ORDER BY tanggal_pengajuan DESC";
$result_surat = $conn->query($query_surat);

$pengajuan_surat = [];
while ($row = $result_surat->fetch_assoc()) {
    $pengajuan_surat[] = [
        "id" => $row['id'],
        "jenis_surat" => $row['jenis_surat'],
        "status" => $row['status'],
        "tanggal_pengajuan" => $row['tanggal_pengajuan'],
        "tanggal_selesai" => $row['tanggal_selesai'] ? $row['tanggal_selesai'] : '-',
        "alasan_penolakan" => ($row['status'] == 'Ditolak' && $row['alasan_penolakan']) ? $row['alasan_penolakan'] : '-'
    ];
}

echo json_encode([
    "status" => "success",
    "pengajuan_surat" => $pengajuan_surat
]);
