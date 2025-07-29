<?php
include('../../koneksi.php'); 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_sejarah = $_GET['id'];

    $query = "SELECT * FROM sejarah WHERE id_sejarah = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Error dalam query: " . $conn->error);
    }

    $stmt->bind_param("i", $id_sejarah);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    } else {
        die("<h3 class='text-danger text-center'>Data tidak ditemukan! Pastikan ID benar.</h3>");
    }
} else {
    die("<h3 class='text-danger text-center'>ID tidak valid atau tidak ditemukan di URL.</h3>");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sejarah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .img-container {
            text-align: center;
        }
        .img-container img {
            max-width: 300px;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .img-container img:hover {
            transform: scale(1.05);
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Detail Sejarah</h2>
        <hr class="w-25 mx-auto border-primary">
    </div>

    <div class="card mx-auto p-4" style="max-width: 700px;">
        <div class="img-container mb-4">
            <h5 class="text-center fw-semibold">Gambar</h5>
            <img src="../../admin/uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="Sejarah" class="img-fluid">
        </div>

        <div class="card-body">
            <h5 class="fw-semibold">Keterangan</h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($row['keterangan'])); ?></p>

            <div class="text-center mt-4">
                <a href="../../index_admin.php?page=sejarah" class="btn btn-custom px-4 py-2">Kembali</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
