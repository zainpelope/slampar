<?php
header("Content-Type: application/json");
require_once "../koneksi.php"; // Pastikan path ke koneksi.php sudah benar

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($email) || empty($password)) {
        $response = ["status" => "error", "message" => "Email dan Password wajib diisi!"];
        echo json_encode($response);
        exit();
    }

    // Untuk debugging, bisa diaktifkan jika perlu
    // error_log("Email diterima: " . $email);
    // error_log("Password diterima: " . $password);

    $query = "SELECT * FROM warga WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);

    // Periksa jika prepare() gagal
    if ($stmt === false) {
        $response = ["status" => "error", "message" => "Gagal menyiapkan statement: " . $conn->error];
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param("ss", $email, $password);
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
                "email" => $user['email'],
                // Hati-hati: Jangan mengembalikan password dalam respons API
            ]
        ];
    } else {
        $response = ["status" => "error", "message" => "Email atau Password salah!"];
    }

    echo json_encode($response);
} else {
    $response = ["status" => "error", "message" => "Metode tidak diperbolehkan!"];
    echo json_encode($response);
}
