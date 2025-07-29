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
    $keperluan = $_POST['keperluan'];
    $status_tanah = $_POST['status_tanah'];
    $luas_tanah = $_POST['luas_tanah'];
    $letak_tanah = $_POST['letak_tanah'];
    $status_kepemilikan = $_POST['status_kepemilikan'];
    $batas_utara = $_POST['batas_utara'];
    $batas_selatan = $_POST['batas_selatan'];
    $batas_timur = $_POST['batas_timur'];
    $batas_barat = $_POST['batas_barat'];

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["file_pendukung"]["name"]);
    move_uploaded_file($_FILES["file_pendukung"]["tmp_name"], $target_file);

    // Penanganan upload bukti kepemilikan
    $target_dir_bukti = "../uploads/"; // Direktori untuk menyimpan bukti kepemilikan
    $bukti_kepemilikan = basename($_FILES["bukti_kepemilikan"]["name"]);
    $target_file_bukti = $target_dir_bukti . $bukti_kepemilikan;

    // Pastikan direktori tujuan ada
    if (!file_exists($target_dir_bukti)) {
        mkdir($target_dir_bukti, 0777, true);
    }

    // Pindahkan file yang diupload
    if (move_uploaded_file($_FILES["bukti_kepemilikan"]["tmp_name"], $target_file_bukti)) {
        // File berhasil diupload, simpan nama file ke database
        $bukti_kepemilikan = $target_file_bukti;
    } else {
        // Gagal mengupload file, simpan nilai NULL atau pesan error
        $bukti_kepemilikan = NULL; // Atau pesan error, misalnya "Gagal upload bukti kepemilikan"
    }

    $query_pengajuan = "INSERT INTO pengajuan_surat (id_pengguna, jenis_surat, status) VALUES ('$id_pengguna', 'Tanah', 'Menunggu Verifikasi')";
    if (mysqli_query($conn, $query_pengajuan)) {
        $id_pengajuan = mysqli_insert_id($conn);

        $query_detail = "INSERT INTO detail_surat (id_pengajuan, nama_lengkap, tempat_lahir, tanggal_lahir, nik, alamat, agama, pekerjaan, keperluan, status_tanah, luas_tanah, letak_tanah, status_kepemilikan, bukti_kepemilikan, batas_utara, batas_selatan, batas_timur, batas_barat, file_pendukung) VALUES ('$id_pengajuan', '$nama_lengkap', '$tempat_lahir', '$tanggal_lahir', '$nik', '$alamat', '$agama', '$pekerjaan', '$keperluan', '$status_tanah', '$luas_tanah', '$letak_tanah', '$status_kepemilikan', '$bukti_kepemilikan', '$batas_utara', '$batas_selatan', '$batas_timur', '$batas_barat', '$target_file')";
        mysqli_query($conn, $query_detail);

        echo "<script>alert('Pengajuan surat Tanah berhasil!'); window.location.href='../coba/coba.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan, coba lagi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Pengajuan Surat Tanah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Form Pengajuan Surat Tanah</h2>
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
                <label class="form-label">Status Tanah</label>
                <input type="text" name="status_tanah" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Luas Tanah</label>
                <input type="number" name="luas_tanah" step="0.01" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Letak Tanah</label>
                <textarea name="letak_tanah" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status Kepemilikan</label>
                <select name="status_kepemilikan" class="form-control">
                    <option value="Pribadi">Pribadi</option>
                    <option value="Warisan">Warisan</option>
                    <option value="Hak Guna">Hak Guna</option>
                    <option value="Sewa">Sewa</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Bukti Kepemilikan (Gambar)</label>
                <input type="file" name="bukti_kepemilikan" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Batas Utara</label>
                <input type="text" name="batas_utara" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Batas Selatan</label>
                <input type="text" name="batas_selatan" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Batas<div class="mb-3">
                        <label class="form-label">Batas Timur</label>
                        <input type="text" name="batas_timur" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Batas Barat</label>
                        <input type="text" name="batas_barat" class="form-control">
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