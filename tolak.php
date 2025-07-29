<?php
include('koneksi.php');

if (isset($_GET['id']) && isset($_POST['alasan_penolakan'])) {
    $id = $_GET['id'];
    $alasan = $_POST['alasan_penolakan'];

    // Update status menjadi Ditolak
    $query = "UPDATE pengajuan_surat SET status='Ditolak', alasan_penolakan=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $alasan, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Pengajuan ditolak!'); window.location.href='index_admin.php?page=layanan_publik';</script>";
    } else {
        echo "<script>alert('Gagal menolak pengajuan!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Data tidak lengkap!'); window.history.back();</script>";
}

$conn->close();
