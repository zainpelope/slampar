<?php
include('../koneksi.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $misi = $_POST['misi'];
    $id_admin = $_SESSION['id_admin'];

    $query = "INSERT INTO misi (id_admin, isi) VALUES ('$id_admin', '$misi')";
    if ($conn->query($query)) {
        echo "<script>alert('Misi berhasil ditambahkan!'); window.location.href='../index_admin.php?page=visi-misi';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan misi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Misi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h3 class="text-center mb-4">Tambah Misi</h3>
        <div class="card p-4 shadow-sm">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="misi" class="form-label">Misi:</label>
                    <textarea id="misi" name="misi" class="form-control" rows="5" required></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="../index_admin.php?page=visi-misi" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>