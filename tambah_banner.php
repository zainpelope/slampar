<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    die("Anda harus login sebagai admin untuk mengakses halaman ini.");
}

$id_admin = $_SESSION['id_admin'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }
    $allowed_formats = ["jpg", "png", "jpeg", "gif", "webp"];
    if (!in_array($imageFileType, $allowed_formats)) {
        echo "Hanya file JPG, PNG, JPEG, GIF, dan WEBP yang diizinkan.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = $target_file;
            $judul = $_POST['judul'];
            $keterangan = $_POST['keterangan'];

            $sql = "INSERT INTO banner (gambar, judul, keterangan, id_admin) VALUES ('$gambar', '$judul', '$keterangan', '$id_admin')";

            if ($conn->query($sql) === TRUE) {
                header("Location: index_admin.php?admin=home_admin");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Banner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Banner</h1>
        <form method="post" action="" enctype="multipart/form-data" class="p-4 bg-light rounded shadow">
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar:</label>
                <input type="file" class="form-control" name="gambar" id="gambar" required>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul:</label>
                <input type="text" class="form-control" name="judul" id="judul" required>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan:</label>
                <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
            </div>

            <button type="submit" class="btn btn-success w-100">Simpan</button>
            <a href="index_admin.php?admin=home_admin" class="btn btn-danger w-100 mt-2">Kembali</a>
        </form>
    </div>
</body>

</html>