<?php
include '../../koneksi.php';
session_start();


if (!isset($_SESSION['id_admin'])) {
    header("Location: ../../index_admin.php?page=berita");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $judul = $_POST['judul'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];


    $id_admin = $_SESSION['id_admin'];


    $image = $_FILES['gambar'];
    $imageName = time() . "_" . basename($image['name']);
    $targetDirectory = '../../uploads/';
    $targetFile = $targetDirectory . $imageName;


    if (getimagesize($image['tmp_name']) === false) {
        echo "<script>alert('File yang diunggah bukan gambar.'); window.history.back();</script>";
        exit();
    }


    if (move_uploaded_file($image['tmp_name'], $targetFile)) {

        $sql = "INSERT INTO berita (gambar, judul, keterangan, tanggal, id_admin) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $imageName, $judul, $keterangan, $tanggal, $id_admin);

        if ($stmt->execute()) {
            echo "<script>alert('Berita berhasil ditambahkan!'); window.location.href='../../index_admin.php?page=berita';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan: " . $stmt->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Gagal mengunggah gambar.'); window.history.back();</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Tambah Berita</h3>
            </div>
            <div class="card-body">
                <form action="tambah_berita.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" accept="image/*" required>
                        <div class="form-text">Unggah gambar berita (format: jpg, png, gif).</div>
                    </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan judul berita" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="5" placeholder="Masukkan keterangan berita" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="../../index_admin.php?page=berita" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Tambah Berita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>