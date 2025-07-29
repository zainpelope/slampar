<?php
include '../koneksi.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['id_pengguna'])) {
    echo "<script>alert('Harap login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit();
}

$id_pengguna = $_SESSION['id_pengguna'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = $_POST['nama_lengkap'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $agama = $_POST['agama'];
    $pekerjaan = $_POST['pekerjaan'];
    $alasan = $_POST['keperluan'];

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["file_pendukung"]["name"]);
    move_uploaded_file($_FILES["file_pendukung"]["tmp_name"], $target_file);

    $query_pengajuan = "INSERT INTO pengajuan_surat (id_pengguna, jenis_surat, status) VALUES ('$id_pengguna', 'Tidak Mampu', 'Menunggu Verifikasi')";
    if (mysqli_query($conn, $query_pengajuan)) {
        $id_pengajuan = mysqli_insert_id($conn);

        $query_detail = "INSERT INTO detail_surat (id_pengajuan, nama_lengkap, tempat_lahir, tanggal_lahir, nik, alamat, agama, pekerjaan, keperluan, file_pendukung) VALUES ('$id_pengajuan', '$nama_lengkap', '$tempat_lahir', '$tanggal_lahir', '$nik', '$alamat', '$agama', '$pekerjaan', '$keperluan', '$target_file')";
        mysqli_query($conn, $query_detail);

        echo "<script>alert('Pengajuan Surat Keterangan Tidak Mampu berhasil!'); window.location.href='coba.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan, coba lagi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Pengajuan Surat Keterangan Tidak Mampu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Form Pengajuan Surat Keterangan Tidak Mampu</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">NIK</label>
                <input type="text" name="nik" class="form-control" required maxlength="16">
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Agama</label>
                <input type="text" name="agama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Keperluan</label>
                <textarea name="keperluan" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload File Pendukung</label>
                <input type="file" name="file_pendukung" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajukan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>