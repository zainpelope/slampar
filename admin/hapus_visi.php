<?php
include('../koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM visi WHERE id = '$id'";
    if ($conn->query($query)) {
        echo "<script>alert('Visi berhasil dihapus!'); window.location.href='../index_admin.php?page=visi-misi';</script>";
    } else {
        echo "<script>alert('Gagal menghapus visi.');</script>";
    }
}
?>