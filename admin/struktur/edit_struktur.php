<?php
include '../../koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_struktur = $_GET['id'];
    $sql = "SELECT * FROM struktur WHERE id_struktur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_struktur);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        header("Location: ../../index_admin.php?page=struktur");
        exit();
    }
} else {
    header("Location: ../../index_admin.php?page=struktur");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_struktur = $_POST['id_struktur'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $id_admin = $_SESSION['id_admin'];

    if (!empty($_FILES["gambar"]["name"])) {
        $gambar = $_FILES["gambar"]["name"];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($gambar);

        if (!empty($row['gambar']) && file_exists($target_dir . $row['gambar'])) {
            unlink($target_dir . $row['gambar']);
        }

        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);

        $sql = "UPDATE struktur SET nama = ?, jabatan = ?, gambar = ?, id_admin = ? WHERE id_struktur = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $nama, $jabatan, $gambar, $id_admin, $id_struktur);
    } else {
        $sql = "UPDATE struktur SET nama = ?, jabatan = ?, id_admin = ? WHERE id_struktur = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $nama, $jabatan, $id_admin, $id_struktur);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: ../../index_admin.php?page=struktur");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Struktur Organisasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-warning text-white text-center">
                <h2>Edit Struktur Organisasi</h2>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_struktur" value="<?= htmlspecialchars($row['id_struktur']) ?>">
                    <div class="mb-4">
                        <label for="nama" class="form-label fw-bold">Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="jabatan" class="form-label fw-bold">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" value="<?= htmlspecialchars($row['jabatan']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="gambar" class="form-label fw-bold">Upload Gambar Baru (Opsional)</label>
                        <input type="file" class="form-control" name="gambar">
                        <small class="text-muted">Format gambar yang diperbolehkan: JPG, PNG.</small>
                        <br>
                        <small class="text-danger">Gambar saat ini: <?= htmlspecialchars($row['gambar']) ?></small>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning btn-lg">Simpan Perubahan</button>
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