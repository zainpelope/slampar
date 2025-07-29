<?php
// Pastikan session dimulai
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['id_admin'])) {
    header("Location: ../coba/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Dashboard Admin</h1>
        <p class="text-center">Selamat datang, <?= htmlspecialchars($_SESSION['email']); ?>!</p>

        <!-- Tombol Navigasi -->
        <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="galery/sejarah.php" class="btn btn-primary btn-lg">Sejarah</a>
            <a href="galery/galery.php" class="btn btn-primary btn-lg">Galeri</a>
            <a href="struktur/struktur.php" class="btn btn-success btn-lg">Struktur</a>
            <a href="berita/berita.php" class="btn btn-warning btn-lg">Berita</a>
        </div>

        <!-- Logout -->
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-2xThFz3ZQDpFWa6dHQJ65qoaHxdNvsaROhg6Bey1EsqybteIzgh9iuQFxBFLvXQK" crossorigin="anonymous"></script>
</body>

</html>