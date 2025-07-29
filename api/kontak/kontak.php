<?php
header('Content-Type: application/json'); // Set header untuk JSON

include '../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $subjeck = isset($_POST['subjeck']) ? htmlspecialchars($_POST['subjeck']) : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';
    $status = 'baru'; // Default status

    if (empty($name) || empty($email) || empty($subjeck) || empty($message)) {
        http_response_code(400); // Bad Request
        echo json_encode(array("status" => "error", "message" => "Semua field harus diisi."));
        exit;
    }

    // Validasi email (opsional, tapi disarankan)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "Format email tidak valid."));
        exit;
    }

    $sql = "INSERT INTO kontak (name, email, subjeck, message, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $subjeck, $message, $status);

    if ($stmt->execute()) {
        http_response_code(201); // Created
        echo json_encode(array("status" => "success", "message" => "Pesan Anda terkirim!"));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("status" => "error", "message" => "Terjadi kesalahan: " . $conn->error));
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("status" => "error", "message" => "Method tidak diizinkan. Hanya POST yang diperbolehkan."));
}
