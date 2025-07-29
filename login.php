<?php

include 'koneksi.php'; // Asumsi koneksi.php membuat $conn
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Gunakan prepared statements untuk mencegah SQL Injection
    $stmt = $conn->prepare("SELECT id, nama, password FROM warga WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Dalam aplikasi nyata, kolom 'password' harus menyimpan password yang di-hash (misalnya, menggunakan password_hash())
        // Untuk demonstrasi dengan password teks biasa Anda saat ini, kita akan membandingkan secara langsung.
        // NAMUN, SANGAT DIREKOMENDASIKAN UNTUK MENG-HASH PASSWORD DALAM APLIKASI NYATA.
        if ($password === $user['password']) { // Ganti dengan password_verify($password, $user['password']) jika menggunakan password yang di-hash.
            $_SESSION['id_pengguna'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = 'warga'; // Asumsi 'warga' adalah peran default untuk pengguna ini

            header("Location: index.php?page=home");
            exit();
        } else {
            echo "<script>alert('Email atau Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Email atau Password salah!');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Login - Sipedas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f0f2f5;
            /* Lighter, more modern background */
        }

        .login-container {
            width: 420px;
            /* Slightly wider container */
            padding: 40px;
            /* More padding inside */
            border-radius: 12px;
            /* Softer rounded corners */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            /* More pronounced shadow */
            background-color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            /* Stronger shadow on hover */
        }

        .login-title {
            font-size: 2.2em;
            /* Larger title */
            font-weight: 600;
            color: #333;
            margin-bottom: 0px;
            /* Remove default h2 margin */
        }

        .app-subtitle {
            font-size: 1em;
            /* Slightly larger subtitle */
            color: #6a6a6a;
            /* Darker gray for better readability */
            margin-top: 5px;
            /* Space between title and subtitle */
            margin-bottom: 30px;
            /* More space before the form */
        }

        .form-label {
            font-weight: 500;
            /* Slightly bolder labels */
            color: #555;
            margin-bottom: 8px;
            /* Space between label and input */
        }

        .form-control {
            border-radius: 8px;
            /* Rounded input fields */
            padding: 12px 15px;
            /* More padding inside inputs */
            border: 1px solid #e0e0e0;
            /* Softer border */
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            /* Blue border on focus */
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            /* Softer shadow on focus */
        }

        /* Styling for the checkbox */
        .form-check {
            margin-top: 15px;
            /* Space between password field and checkbox */
            margin-bottom: 25px;
            /* Space between checkbox and buttons */
            padding-left: 0;
            /* Remove default Bootstrap padding */
        }

        .form-check-input {
            width: 1.2em;
            /* Adjust checkbox size */
            height: 1.2em;
            /* Adjust checkbox size */
            margin-right: 8px;
            /* Space between checkbox and label text */
            float: none;
            /* Remove float from Bootstrap */
            vertical-align: middle;
            /* Align with text */
            cursor: pointer;
        }

        .form-check-label {
            vertical-align: middle;
            /* Align with checkbox */
            cursor: pointer;
            color: #555;
            /* Label color */
        }


        .btn {
            font-weight: 600;
            padding: 12px 20px;
            /* More padding for buttons */
            border-radius: 8px;
            /* Rounded buttons */
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .btn-success {
            background-color: #28a745;
            /* Bootstrap green */
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            /* Darker green on hover */
            border-color: #1e7e34;
        }

        .btn-secondary {
            background-color: #6c757d;
            /* Bootstrap gray */
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            /* Darker gray on hover */
            border-color: #545b62;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center login-title">Login Sipedas</h2>
        <p class="text-center app-subtitle">Sistem Pelayanan Desa</p>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="showPasswordCheckbox" onchange="togglePasswordVisibility()">
                <label class="form-check-label" for="showPasswordCheckbox">
                    Tampilkan Password
                </label>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">Login</button>
                <a href="slampang.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

            if (showPasswordCheckbox.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>