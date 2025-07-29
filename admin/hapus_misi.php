<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM misi WHERE id = '$id'";
    if ($conn->query($query)) {
        echo "<script>alert('Misi berhasil dihapus!'); window.location.href='../index_admin.php?page=visi-misi';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "ID tidak valid.";
}
?>