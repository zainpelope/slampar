<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM kegiatan WHERE id_kegiatan = '$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_admin.php?page=kegiatan");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>