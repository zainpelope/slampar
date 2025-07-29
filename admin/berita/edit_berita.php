<?php
include '../../koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id_berita'])) {
    echo "Berita tidak ditemukan!";
    exit();
}

$id_berita = $_GET['id_berita'];

$sql = "SELECT * FROM berita WHERE id_berita = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_berita);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Berita tidak ditemukan!";
    exit();
}

$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];
    $gambarLama = $row['gambar'];
    if ($_FILES['gambar']['name']) {
        $image = $_FILES['gambar'];
        $imageName = time() . "_" . basename($image['name']);
        $targetDirectory = '../../uploads/';
        $targetFile = $targetDirectory . $imageName;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            unlink("../../uploads/" . $gambarLama);
            $gambarLama = $imageName;
        } else {
            echo "Gagal mengunggah gambar!";
            exit();
        }
    }
    $sql = "UPDATE berita SET judul = ?, keterangan = ?, tanggal = ?, gambar = ? WHERE id_berita = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $judul, $keterangan, $tanggal, $gambarLama, $id_berita);

    if ($stmt->execute()) {
        header("Location: ../../index_admin.php?page=berita");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            color: #343a40;
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn {
            border-radius: 5px;
            padding: 10px 20px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .img-preview {
            max-width: 200px;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Berita</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="judul" class="form-label">Judul Berita</label>
                <input type="text" class="form-control" name="judul" value="<?= htmlspecialchars($row['judul']) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" name="keterangan" rows="5" required><?= htmlspecialchars($row['keterangan']) ?></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal" value="<?= htmlspecialchars($row['tanggal']) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" class="form-control" name="gambar" accept="image/*">
                <div class="mt-2">
                    <img src="../../uploads/<?= htmlspecialchars($row['gambar']) ?>" class="img-preview" alt="Image Preview">
                </div>
            </div>
            <div class="form-group d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="../../index_admin.php?page=berita" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>