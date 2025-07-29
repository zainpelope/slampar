<?php
include '../../koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_berita'])) {
    $id_berita = $_GET['id_berita'];
    $sql = "SELECT * FROM berita WHERE id_berita = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_berita);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Berita tidak ditemukan.";
        exit();
    }
} else {
    echo "ID Berita tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome for icons -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 800px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #343a40;
        }

        .img-fluid {
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .btn {
            font-size: 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .card-body {
            margin-top: 30px;
        }

        .card-footer {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .icon {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1><?= htmlspecialchars($row['judul']) ?></h1>
        <img src="../uploads/<?= htmlspecialchars($row['gambar']) ?>" class="img-fluid mb-3" style="max-width: 100%;">
        <div class="card">
            <div class="card-body">
                <p class="mb-3"><strong>Keterangan:</strong></p>
                <p><?= nl2br(htmlspecialchars($row['keterangan'])) ?></p>
                <p class="mt-4"><strong>Tanggal:</strong> <?= htmlspecialchars($row['tanggal']) ?></p>
            </div>
            <div class="card-footer text-center">
                <a href="../../index_admin.php?page=berita" class="btn btn-secondary">
                    <i class="fas fa-arrow-left icon"></i> Kembali ke Berita
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>