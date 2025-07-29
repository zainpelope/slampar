<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengguna = $_SESSION['id_pengguna'];
    $jenis_surat = $_POST['jenis_surat'];
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $tempat_lahir = htmlspecialchars($_POST['tempat_lahir']);
    $tanggal_lahir = date('Y-m-d', strtotime($_POST['tanggal_lahir']));
    $nik = preg_replace('/[^0-9]/', '', $_POST['nik']); // Pastikan hanya angka
    $alamat = htmlspecialchars($_POST['alamat']);
    $agama = htmlspecialchars($_POST['agama']);
    $pekerjaan = isset($_POST['pekerjaan']) ? htmlspecialchars($_POST['pekerjaan']) : null;
    $keperluan = isset($_POST['keperluan']) ? htmlspecialchars($_POST['keperluan']) : null;
    $status_pernikahan = isset($_POST['status_pernikahan']) ? htmlspecialchars($_POST['status_pernikahan']) : null;
    $jenis_usaha = isset($_POST['jenis_usaha']) ? htmlspecialchars($_POST['jenis_usaha']) : null;

    $status_tanah = isset($_POST['status_tanah']) ? htmlspecialchars($_POST['status_tanah']) : null;
    $luas_tanah = isset($_POST['luas_tanah']) ? floatval($_POST['luas_tanah']) : null;
    $letak_tanah = isset($_POST['letak_tanah']) ? htmlspecialchars($_POST['letak_tanah']) : null;
    $status_kepemilikan = isset($_POST['status_kepemilikan']) ? htmlspecialchars($_POST['status_kepemilikan']) : null;
    $batas_utara = isset($_POST['batas_utara']) ? htmlspecialchars($_POST['batas_utara']) : null;
    $batas_selatan = isset($_POST['batas_selatan']) ? htmlspecialchars($_POST['batas_selatan']) : null;
    $batas_timur = isset($_POST['batas_timur']) ? htmlspecialchars($_POST['batas_timur']) : null;
    $batas_barat = isset($_POST['batas_barat']) ? htmlspecialchars($_POST['batas_barat']) : null;

    // Fungsi untuk upload file
    function uploadFile($fileInput, $uploadDir = 'uploads/')
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] == 0) {
            $fileInfo = pathinfo($_FILES[$fileInput]['name']);
            $fileExt = strtolower($fileInfo['extension']);

            if (!in_array($fileExt, $allowedExtensions)) {
                die("Error: Format file tidak didukung!");
            }

            if ($_FILES[$fileInput]['size'] > 2 * 1024 * 1024) { // Batasi ukuran 2MB
                die("Error: Ukuran file terlalu besar!");
            }

            $filename = time() . '_' . basename($_FILES[$fileInput]['name']);
            $uploadFile = $uploadDir . $filename;

            if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $uploadFile)) {
                return $filename;
            }
        }
        return null;
    }

    $bukti_kepemilikan = uploadFile('bukti_kepemilikan');
    $file_pendukung = uploadFile('file_pendukung');

    // Insert into pengajuan_surat
    $query1 = "INSERT INTO pengajuan_surat (id_pengguna, jenis_surat) VALUES (?, ?)";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("is", $id_pengguna, $jenis_surat);

    if ($stmt1->execute()) {
        $id_pengajuan = $conn->insert_id;

        $query2 = "INSERT INTO detail_surat 
                    (id_pengajuan, nama_lengkap, tempat_lahir, tanggal_lahir, nik, alamat, agama, pekerjaan, keperluan, status_pernikahan, jenis_usaha, 
                    status_tanah, luas_tanah, letak_tanah, status_kepemilikan, bukti_kepemilikan, batas_utara, batas_selatan, batas_timur, batas_barat, file_pendukung) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param(
            "isssssssssssdssssssss",
            $id_pengajuan,
            $nama_lengkap,
            $tempat_lahir,
            $tanggal_lahir,
            $nik,
            $alamat,
            $agama,
            $pekerjaan,
            $keperluan,
            $status_pernikahan,
            $jenis_usaha,
            $status_tanah,
            $luas_tanah,
            $letak_tanah,
            $status_kepemilikan,
            $bukti_kepemilikan,
            $batas_utara,
            $batas_selatan,
            $batas_timur,
            $batas_barat,
            $file_pendukung
        );

        if ($stmt2->execute()) {
            echo "<script>alert('Pengajuan berhasil!'); window.location='index.php?page=warga';</script>";
        } else {
            error_log("Error detail_surat: " . $stmt2->error);
            die("Terjadi kesalahan, silakan coba lagi.");
        }
    } else {
        error_log("Error pengajuan_surat: " . $stmt1->error);
        die("Terjadi kesalahan, silakan coba lagi.");
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Pengajuan Surat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
    <script>
        function showForm() {
            var jenisSurat = document.getElementById("jenis_surat").value;
            var formFields = document.getElementById("form_fields");

            var html = "";
            if (jenisSurat) {
                html += `<div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>`;
                html += `<div class="mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" required>
                    </div>`;
                html += `<div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required id="tanggal_lahir">
                    </div>`;
                html += `<div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" id="nik" class="form-control" required 
                               oninput="validateNIK(this)">
                        <div class="text-danger mt-1" id="nik_error"></div>
                    </div>`;
                html += `<div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" required></textarea>
                    </div>`;
                html += `<div class="mb-3">
                        <label class="form-label">Agama</label>
                        <select name="agama" class="form-select" required>
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>`;
                html += `<div class="mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control">
                    </div>`;
                html += `<div class="mb-3">
                        <label class="form-label">Keperluan</label>
                        <textarea name="keperluan" class="form-control" required></textarea>
                    </div>`;
                html += `<div class="mb-3">
                        <label class="form-label">File Pendukung (KTP/KK)</label>
                        <input type="file" name="file_pendukung" class="form-control">
                    </div>`;

                if (jenisSurat === "Belum Menikah") {
                    html += `<div class="mb-3">
                            <label class="form-label">Status Pernikahan</label>
                            <select name="status_pernikahan" class="form-select">
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Menikah">Menikah</option>
                            </select>
                        </div>`;
                }

                if (jenisSurat === "Usaha") {
                    html += `<div class="mb-3">
                            <label class="form-label">Jenis Usaha</label>
                            <input type="text" name="jenis_usaha" class="form-control" required>
                        </div>`;
                }

                if (jenisSurat === "Tanah") {
                    html += `<div class="mb-3">
                            <label class="form-label">Status Tanah</label>
                            <input type="text" name="status_tanah" class="form-control" required>
                        </div>`;
                    html += `<div class="mb-3">
                            <label class="form-label">Luas Tanah (m²)</label>
                            <input type="number" name="luas_tanah" class="form-control" required>
                        </div>`;
                    html += `<div class="mb-3">
                            <label class="form-label">Letak Tanah</label>
                            <textarea name="letak_tanah" class="form-control" required></textarea>
                        </div>`;
                    html += `<div class="mb-3">
                            <label class="form-label">Status Kepemilikan</label>
                            <select name="status_kepemilikan" class="form-select">
                                <option value="Pribadi">Pribadi</option>
                                <option value="Warisan">Warisan</option>
                                <option value="Hak Guna">Hak Guna</option>
                                <option value="Sewa">Sewa</option>
                            </select>
                        </div>`;
                    html += `<div class="mb-3">
                            <label class="form-label">Bukti Kepemilikan</label>
                            <input type="file" name="bukti_kepemilikan" class="form-control">
                        </div>`;
                    html += `<div class="mb-3">
                            <label class="form-label">Batas Utara</label>
                            <input type="text" name="batas_utara" class="form-control">
                        </div>`;
                    html += `<div class="mb-3">
                            <label class="form-label">Batas Selatan</label>
                            <input type="text" name="batas_selatan" class="form-control">
                        </div>`;
                    html += `<div class="mb-3">
                            <label class="form-label">Batas Timur</label>
                            <input type="text" name="batas_timur" class="form-control">
                        </div>`;
                    html += `<div class="mb-3">
                            <label class="form-label">Batas Barat</label>
                            <input type="text" name="batas_barat" class="form-control">
                        </div>`;
                }
            }
            formFields.innerHTML = html;
            document.getElementById("tanggal_lahir").valueAsDate = new Date();
        }

        function validateNIK(input) {
            var nik = input.value;
            var errorDiv = document.getElementById("nik_error");

            if (!/^\d{0,16}$/.test(nik)) {
                input.value = nik.slice(0, -1);
            }

            if (nik.length !== 16) {
                errorDiv.innerText = "NIK harus terdiri dari 16 angka!";
            } else {
                errorDiv.innerText = "";
            }
        }
    </script>

</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="text-center mb-4">Form Pengajuan Surat</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Pilih Jenis Surat</label>
                            <select name="jenis_surat" id="jenis_surat" class="form-select" onchange="showForm()" required>
                                <option value="">-- Pilih --</option>
                                <option value="Domisili">Surat Domisili</option>
                                <option value="Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                                <option value="Usaha">Surat Usaha</option>
                                <option value="Belum Menikah">Surat Belum Menikah</option>
                                <option value="Tanah">Surat Tanah</option>
                            </select>
                        </div>
                        <div id="form_fields"></div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Ajukan Surat</button>
                        <a href="index.php?page=warga" class="btn btn-secondary w-100 mt-3">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>