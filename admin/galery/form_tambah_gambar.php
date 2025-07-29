<?php
include '../../koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["gambar"])) {
    $gambar = $_FILES["gambar"]["name"];
    $id_admin = $_SESSION['id_admin'];
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($gambar);

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO galery (gambar, id_admin) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $gambar, $id_admin);
        $stmt->execute();
        $stmt->close();

        header("Location: ../../index_admin.php?page=galery");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gambar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg mx-auto" style="max-width: 600px;">
            <div class="card-header bg-primary text-white text-center">
                <h2 class="card-title">Tambah Gambar</h2>
            </div>
            <div class="card-body p-4">
                <form action="form_tambah_gambar.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="gambar" class="form-label fw-bold">Upload Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" required>
                        <small class="text-muted">Format yang diizinkan: jpg, png, gif</small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-cloud-upload-fill"></i> Tambah Gambar
                        </button>
                        <a href="../../index_admin.php?page=galery" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>