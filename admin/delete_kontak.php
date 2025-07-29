<?php
include '../koneksi.php';

if (isset($_POST['id_kontak'])) {
    $id_kontak = $_POST['id_kontak'];

    $sql = "DELETE FROM kontak WHERE id_kontak = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kontak);
    if ($stmt->execute()) {

        header("Location: ../admin/kotak_masuk.php");
        exit();
    } else {

        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {

    echo "ID kontak tidak ditemukan.";
}

$conn->close();
