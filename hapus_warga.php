<?php
include('koneksi.php');

$id = $_GET['id'];
$sql = "DELETE FROM warga WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: index_admin.php?page=warga");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
