<?php
header('Content-Type: application/json');
include '../../koneksi.php';

$per_page = 10;
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;

$sql_count = "SELECT COUNT(*) AS total FROM struktur";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);

$sql = "SELECT * FROM struktur 
        ORDER BY 
            CASE WHEN jabatan = 'Kepala Desa' THEN 1 ELSE 2 END, 
            nama ASC
        LIMIT $start_from, $per_page";

$result = $conn->query($sql);

$response = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response['data'][] = [
            'id' => $row['id'],
            'nama' => $row['nama'],
            'jabatan' => $row['jabatan'],
            'gambar' => "admin/uploads/" . $row['gambar']
        ];
    }
    $response['pagination'] = [
        'current_page' => $halaman,
        'total_pages' => $total_pages,
        'total_records' => $total_records
    ];
    echo json_encode($response);
} else {
    echo json_encode(['message' => 'Data struktur desa tidak ditemukan.']);
}
