<?php
include '../../koneksi.php';
session_start();


if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["gambar"])) {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $gambar = $_FILES["gambar"]["name"];
    $id_admin = $_SESSION['id_admin'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($gambar);


    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {

        $sql = "INSERT INTO struktur (nama, jabatan, gambar, id_admin) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nama, $jabatan, $gambar, $id_admin);
        $stmt->execute();
        $stmt->close();
    }


    header("Location: ../../index_admin.php?page=struktur");
    exit();
}
