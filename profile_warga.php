<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Mulai sesi (penting untuk mengecek status login)
session_start();
include('koneksi.php');


$id = $_SESSION['id_pengguna'];
$query = "SELECT nama, nik, tanggal_lahir, alamat, no_hp, email FROM warga WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            max-width: 800px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card-profile {
            text-align: center;
            padding: 20px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }

        .btn-group {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    </style>
</head>

<body>
    <div class="container profile-container">
        <div class="row w-100">
            <div class="col-md-4">
                <div class="card card-profile">
                    <img src="https://i.pravatar.cc/120" alt="User Avatar" class="profile-img">
                    <h4 class="mt-3"><?= htmlspecialchars($user['nama']) ?></h4>

                    <div class="btn-group">
                        <a href="edit_profile.php" class="btn btn-primary">Edit</a>
                        <a href="slampang.php" class="btn btn-secondary">Logout</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-3">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama Lengkap</th>
                            <td><?= htmlspecialchars($user['nama']) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td><?= htmlspecialchars($user['no_hp']) ?></td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td><?= htmlspecialchars($user['nik']) ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td><?= htmlspecialchars($user['tanggal_lahir']) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= htmlspecialchars($user['alamat']) ?></td>
                        </tr>
                    </table>
                    <a href="index.php?page=home" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>