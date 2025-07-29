<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    die("Anda harus login sebagai admin untuk mengakses halaman ini.");
}

$id_admin = $_SESSION['id_admin'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $keterangan = $_POST['keterangan'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $lokasi = $_POST['lokasi'];

    $gambar = $_FILES['gambar']['name'];
    $target_dir = "uploads/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0775, true);
    }

    $target_file = $target_dir . basename($gambar);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO kegiatan (nama_kegiatan, keterangan, tanggal_mulai, tanggal_selesai, lokasi, gambar, id_admin) 
                VALUES ('$nama_kegiatan', '$keterangan', '$tanggal_mulai', '$tanggal_selesai', '$lokasi', '$gambar', '$id_admin')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index_admin.php?page=kegiatan");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload gambar.";
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            padding: 20px;
        }

        .container {
            max-width: 600px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tambah Kegiatan</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_kegiatan" class="form-label">Nama Kegiatan:</label>
                <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan:</label>
                <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
            </div>
            <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai:</label>
                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi:</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar:</label>
                <input class="form-control" type="file" id="gambar" name="gambar">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index_admin.php?page=kegiatan" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>