<?php
include('koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE pengajuan_surat SET status='Siap Diambil' WHERE id='$id'";
    $conn->query($sql);
}

$conn->close();
