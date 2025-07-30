<?php
include 'koneksi.php'; // Asumsi koneksi.php membuat $conn
session_start();

$message = ''; // Variabel untuk menyimpan pesan sukses atau error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $email = $_POST['email'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password_baru = $_POST['konfirmasi_password_baru'];

    // Validasi input
    if (empty($nama) || empty($nik) || empty($tanggal_lahir) || empty($email) || empty($password_baru) || empty($konfirmasi_password_baru)) {
        $message = "<div class='alert alert-danger' role='alert'>Semua kolom harus diisi!</div>";
    } elseif ($password_baru !== $konfirmasi_password_baru) {
        $message = "<div class='alert alert-danger' role='alert'>Password baru dan konfirmasi password tidak cocok!</div>";
    } else {
        // Gunakan prepared statements untuk mencegah SQL Injection
        $stmt = $conn->prepare("SELECT id FROM warga WHERE nama = ? AND nik = ? AND tanggal_lahir = ? AND email = ?");
        $stmt->bind_param("ssss", $nama, $nik, $tanggal_lahir, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $user_id = $user['id'];

            // Update password
            // SANGAT PENTING: Dalam aplikasi nyata, gunakan password_hash() untuk meng-hash password
            // Contoh: $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
            // Lalu simpan $hashed_password ke database.
            // Untuk konsistensi dengan kode login Anda saat ini yang tidak menggunakan hashing,
            // saya akan menyimpan password dalam bentuk teks biasa.
            // MOHON SANGAT DIREKOMENDASIKAN UNTUK MENGUBAH INI DI LINGKUNGAN PRODUKSI!
            $update_stmt = $conn->prepare("UPDATE warga SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $password_baru, $user_id); // Ganti $password_baru dengan $hashed_password jika menggunakan hashing

            if ($update_stmt->execute()) {
                $message = "<div class='alert alert-success' role='alert'>Password berhasil direset! Silakan login dengan password baru Anda.</div>";
            } else {
                $message = "<div class='alert alert-danger' role='alert'>Terjadi kesalahan saat mereset password. Silakan coba lagi.</div>";
            }
            $update_stmt->close();
        } else {
            $message = "<div class='alert alert-danger' role='alert'>Data yang Anda masukkan tidak cocok dengan catatan kami.</div>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Reset Password - Sipedas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f0f2f5;
        }

        .reset-container {
            width: 480px;
            /* Slightly wider for more fields */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background-color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .reset-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .reset-title {
            font-size: 2.2em;
            font-weight: 600;
            color: #333;
            margin-bottom: 0px;
        }

        .app-subtitle {
            font-size: 1em;
            color: #6a6a6a;
            margin-top: 5px;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .form-check {
            margin-top: 15px;
            margin-bottom: 25px;
            padding-left: 0;
        }

        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            margin-right: 8px;
            float: none;
            vertical-align: middle;
            cursor: pointer;
        }

        .form-check-label {
            vertical-align: middle;
            cursor: pointer;
            color: #555;
        }

        .btn {
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 8px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <h2 class="text-center reset-title">Reset Password</h2>
        <p class="text-center app-subtitle">Sistem Pelayanan Desa</p>

        <?php echo $message; // Menampilkan pesan sukses/error 
        ?>

        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap:</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nik" class="form-label">NIK:</label>
                <input type="text" name="nik" id="nik" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password_baru" class="form-label">Password Baru:</label>
                <input type="password" name="password_baru" id="password_baru" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="konfirmasi_password_baru" class="form-label">Konfirmasi Password Baru:</label>
                <input type="password" name="konfirmasi_password_baru" id="konfirmasi_password_baru" class="form-control" required>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="showPasswordCheckbox" onchange="togglePasswordVisibility()">
                <label class="form-check-label" for="showPasswordCheckbox">
                    Tampilkan Password
                </label>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Reset Password</button>
                <a href="login.php" class="btn btn-secondary">Kembali ke Login</a>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField1 = document.getElementById('password_baru');
            const passwordField2 = document.getElementById('konfirmasi_password_baru');
            const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

            if (showPasswordCheckbox.checked) {
                passwordField1.type = 'text';
                passwordField2.type = 'text';
            } else {
                passwordField1.type = 'password';
                passwordField2.type = 'password';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>