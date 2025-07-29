<?php
include '../../koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    die("Anda harus login sebagai admin untuk mengakses halaman ini.");
}

$id_admin = $_SESSION['id_admin'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keterangan = $_POST['keterangan'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];

        $upload_dir = '../../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0775, true);
        }

        $gambar_path = $upload_dir . basename($gambar);

        if (move_uploaded_file($gambar_tmp, $gambar_path)) {
            $query = "INSERT INTO sejarah (gambar, keterangan, id_admin) VALUES ('$gambar', '$keterangan', '$id_admin')";
            if ($conn->query($query)) {
                echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='../../index_admin.php?page=sejarah';</script>";
                exit;
            } else {
                echo "Terjadi kesalahan: " . $conn->error;
            }
        } else {
            echo "Gagal mengunggah gambar. Pastikan folder 'admin/uploads/' memiliki izin tulis.";
        }
    } else {
        echo "Harap pilih gambar untuk diunggah.";
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Sejarah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .preview-img {
            display: none;
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            margin-top: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h2 class="text-center mb-4">Tambah Sejarah</h2>
                    <form action="tambah_sejarah.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                            <img id="preview" class="preview-img" alt="Preview Gambar">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        <a href="../../index_admin.php?page=sejarah" class="btn btn-secondary w-100 mt-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>