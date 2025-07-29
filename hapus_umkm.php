<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM umkm_desa WHERE id_umkm = '$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_admin.php?admin=home_admin");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID UMKM tidak valid.";
    exit;
}
