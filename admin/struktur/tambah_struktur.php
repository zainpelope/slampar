<?php
include '../../koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Struktur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h2>Tambah Struktur</h2>
            </div>
            <div class="card-body">
                <form action="proses_struktur.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="nama" class="form-label fw-bold">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-4">
                        <label for="jabatan" class="form-label fw-bold">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" placeholder="Masukkan jabatan" required>
                    </div>
                    <div class="mb-4">
                        <label for="gambar" class="form-label fw-bold">Upload Gambar</label>
                        <input type="file" class="form-control" name="gambar" required>
                        <small class="text-muted">Format gambar yang diperbolehkan: JPG, PNG.</small>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Tambah</button>
                    </div>
                </form>
                <div class="d-grid mt-2">
                    <a href="../../index_admin.php?page=struktur" class="btn btn-secondary btn-lg">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>