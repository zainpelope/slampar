<?php
include('koneksi.php');

if (isset($_GET['id'])) {
    $id_pengajuan = $_GET['id'];

    // Lakukan query untuk menghapus data berdasarkan ID
    $query = "DELETE FROM pengajuan_surat WHERE id = '$id_pengajuan'";

    if ($conn->query($query)) {
        echo "<script>alert('Data pengajuan berhasil dihapus.'); window.location.href='index_admin.php?page=layanan_publik';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus data: " . $conn->error . "'); window.location.href='index_admin.php?page=layanan_publik';</script>";
    }
} else {
    echo "<script>alert('ID pengajuan tidak valid.'); window.location.href='index_admin.php?page=layanan_publik';</script>";
}

$conn->close();
