<?php
include '../../koneksi.php';

if (isset($_GET['id'])) {
    $id_sejarah = $_GET['id'];
    $query = "SELECT * FROM sejarah WHERE id_sejarah = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_sejarah);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='../../index_admin.php?page=sejarah';</script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keterangan = $_POST['keterangan'];
    $gambar_lama = $_POST['gambar_lama'];

    if ($_FILES['gambar']['name']) {
        $gambar_baru = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $upload_dir = "../../uploads/";

        if (!empty($gambar_lama) && file_exists($upload_dir . $gambar_lama)) {
            unlink($upload_dir . $gambar_lama);
        }

        move_uploaded_file($gambar_tmp, $upload_dir . $gambar_baru);
    } else {
        $gambar_baru = $gambar_lama;
    }

    $update_query = "UPDATE sejarah SET gambar = ?, keterangan = ? WHERE id_sejarah = ?";
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param("ssi", $gambar_baru, $keterangan, $id_sejarah);

    if ($stmt_update->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='../../index_admin.php?page=sejarah';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data!'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sejarah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .img-preview {
            display: block;
            margin: 10px auto;
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .img-preview:hover {
            transform: scale(1.05);
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            transition: 0.3s;
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            display: block;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h3 class="text-center mb-4">Edit Sejarah</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3 text-center">
                            <label class="form-label fw-bold">Gambar</label><br>
                            <img src="../../uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="Sejarah" class="img-preview"><br>
                            <input type="file" class="form-control mt-2" id="gambar" name="gambar">
                            <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="5" required><?= htmlspecialchars($row['keterangan']); ?></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-custom px-4 py-2">Update</button>
                            <a href="../../index_admin.php?page=sejarah" class="btn btn-secondary px-4 py-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>