<?php
header("Content-Type: application/json");
require_once "../koneksi.php";

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = isset($_POST['nik']) ? trim($_POST['nik']) : '';
    $tanggal_lahir = isset($_POST['tanggal_lahir']) ? trim($_POST['tanggal_lahir']) : '';

    if (empty($nik) || empty($tanggal_lahir)) {
        $response = ["status" => "error", "message" => "NIK dan Tanggal Lahir wajib diisi!"];
        echo json_encode($response);
        exit();
    }


    error_log("NIK diterima: " . $nik);
    error_log("Tanggal Lahir diterima: " . $tanggal_lahir);

    $query = "SELECT * FROM warga WHERE nik = ? AND tanggal_lahir = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $nik, $tanggal_lahir);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $response = [
            "status" => "success",
            "message" => "Login berhasil",
            "data" => [
                "id" => $user['id'],
                "nama" => $user['nama'],
                "nik" => $user['nik'],
                "tanggal_lahir" => $user['tanggal_lahir']
            ]
        ];
    } else {
        $response = ["status" => "error", "message" => "NIK atau Tanggal Lahir salah!"];
    }

    echo json_encode($response);
} else {
    $response = ["status" => "error", "message" => "Metode tidak diperbolehkan!"];
    echo json_encode($response);
}
