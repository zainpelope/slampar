<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$conn) {
        die(json_encode(["status" => "error", "message" => "Koneksi database gagal!"]));
    }

    $id_pengguna = mysqli_real_escape_string($conn, $_POST['id_pengguna'] ?? '');
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap'] ?? '');
    $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir'] ?? '');
    $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir'] ?? '');
    $nik = mysqli_real_escape_string($conn, $_POST['nik'] ?? '');
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat'] ?? '');
    $agama = mysqli_real_escape_string($conn, $_POST['agama'] ?? '');
    $pekerjaan = mysqli_real_escape_string($conn, $_POST['pekerjaan'] ?? '');
    $keperluan = mysqli_real_escape_string($conn, $_POST['keperluan'] ?? '');
    $status_tanah = mysqli_real_escape_string($conn, $_POST['status_tanah'] ?? '');
    $luas_tanah = mysqli_real_escape_string($conn, $_POST['luas_tanah'] ?? '');
    $letak_tanah = mysqli_real_escape_string($conn, $_POST['letak_tanah'] ?? '');
    $status_kepemilikan = mysqli_real_escape_string($conn, $_POST['status_kepemilikan'] ?? '');
    $batas_utara = mysqli_real_escape_string($conn, $_POST['batas_utara'] ?? '');
    $batas_selatan = mysqli_real_escape_string($conn, $_POST['batas_selatan'] ?? '');
    $batas_timur = mysqli_real_escape_string($conn, $_POST['batas_timur'] ?? '');
    $batas_barat = mysqli_real_escape_string($conn, $_POST['batas_barat'] ?? '');

    error_log("Data diterima: " . json_encode($_POST));

    // Upload file pendukung
    $target_file = "";
    if (!empty($_FILES["file_pendukung"]["name"])) {
        $target_dir = "../uploads/";
        $file_name = basename($_FILES["file_pendukung"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ["jpg", "jpeg", "png", "pdf"];
        if (!in_array($file_type, $allowed_types)) {
            echo json_encode(["status" => "error", "message" => "Format file pendukung tidak diizinkan!"]);
            exit;
        }

        if (move_uploaded_file($_FILES["file_pendukung"]["tmp_name"], $target_file)) {
            error_log("File pendukung berhasil diunggah: " . $target_file);
        } else {
            $target_file = "";
            error_log("Gagal mengunggah file pendukung.");
        }
    }

    // Upload bukti kepemilikan
    $bukti_kepemilikan = "";
    if (!empty($_FILES["bukti_kepemilikan"]["name"])) {
        $target_dir_bukti = "../uploads/";
        $bukti_file_name = basename($_FILES["bukti_kepemilikan"]["name"]);
        $bukti_kepemilikan = $target_dir_bukti . time() . "_" . $bukti_file_name;
        $bukti_file_type = strtolower(pathinfo($bukti_kepemilikan, PATHINFO_EXTENSION));

        if (!in_array($bukti_file_type, ["jpg", "jpeg", "png"])) {
            echo json_encode(["status" => "error", "message" => "Format bukti kepemilikan tidak diizinkan!"]);
            exit;
        }

        if (move_uploaded_file($_FILES["bukti_kepemilikan"]["tmp_name"], $bukti_kepemilikan)) {
            error_log("Bukti kepemilikan berhasil diunggah: " . $bukti_kepemilikan);
        } else {
            $bukti_kepemilikan = "";
            error_log("Gagal mengunggah bukti kepemilikan.");
        }
    }

    $query_pengajuan = "INSERT INTO pengajuan_surat (id_pengguna, jenis_surat, status) VALUES ('$id_pengguna', 'Tanah', 'Menunggu Verifikasi')";

    if (mysqli_query($conn, $query_pengajuan)) {
        $id_pengajuan = mysqli_insert_id($conn);

        $query_detail = "INSERT INTO detail_surat (id_pengajuan, nama_lengkap, tempat_lahir, tanggal_lahir, nik, alamat, agama, pekerjaan, keperluan, status_tanah, luas_tanah, letak_tanah, status_kepemilikan, bukti_kepemilikan, batas_utara, batas_selatan, batas_timur, batas_barat, file_pendukung) VALUES ('$id_pengajuan', '$nama_lengkap', '$tempat_lahir', '$tanggal_lahir', '$nik', '$alamat', '$agama', '$pekerjaan', '$keperluan', '$status_tanah', '$luas_tanah', '$letak_tanah', '$status_kepemilikan', '$bukti_kepemilikan', '$batas_utara', '$batas_selatan', '$batas_timur', '$batas_barat', '$target_file')";

        if (mysqli_query($conn, $query_detail)) {
            echo json_encode(["status" => "success", "message" => "Pengajuan surat tanah berhasil!"]);
        } else {
            $error_message = "Terjadi kesalahan saat menyimpan detail surat: " . mysqli_error($conn);
            error_log("Error detail_surat: " . $error_message);
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else {
        $error_message = "Terjadi kesalahan saat menyimpan pengajuan surat: " . mysqli_error($conn);
        error_log("Error pengajuan_surat: " . $error_message);
        echo json_encode(["status" => "error", "message" => $error_message]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Metode request tidak valid."]);
}

mysqli_close($conn);
