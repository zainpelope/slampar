<?php
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (strlen($nik) != 16 || !ctype_digit($nik)) {
        echo "<script>alert('NIK harus terdiri dari 16 digit angka.'); window.history.back();</script>";
        exit();
    }


    $cek_nik = "SELECT nik FROM warga WHERE nik = '$nik'";
    $result_nik = mysqli_query($conn, $cek_nik);
    if (mysqli_num_rows($result_nik) > 0) {
        echo "<script>alert('NIK yang Anda masukkan sudah terdaftar.'); window.history.back();</script>";
        exit();
    }


    if (!empty($email)) {
        $cek_email = "SELECT email FROM warga WHERE email = '$email'";
        $result_email = mysqli_query($conn, $cek_email);
        if (mysqli_num_rows($result_email) > 0) {
            echo "<script>alert('Email yang Anda masukkan sudah terdaftar.'); window.history.back();</script>";
            exit();
        }
    }

    $sql = "INSERT INTO warga (nama, nik, tanggal_lahir, alamat, no_hp, email, password) VALUES ('$nama', '$nik', '$tanggal_lahir', '$alamat', '$no_hp', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index_admin.php?page=warga");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


$tanggal_sekarang = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex-grow: 1;
            padding: 20px;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-container {
            margin-top: 20px;
            text-align: center;
        }

        .btn-full {
            width: 100%;
            margin-bottom: 10px;
        }

        .alert-danger {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Tambah Warga</h2>
        <div class="form-container">
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Nama:</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">NIK:</label>
                    <input type="text" name="nik" class="form-control" required minlength="16" maxlength="16" onkeypress="return hanyaAngka(event)">
                    <small class="text-danger" id="nik-error"></small>
                    <?php
                    if (isset($_GET['nik_exist']) && $_GET['nik_exist'] == 'true') {
                        echo '<div class="alert alert-danger">NIK sudah terdaftar.</div>';
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $tanggal_sekarang; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat:</label>
                    <textarea name="alamat" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">No HP:</label>
                    <input type="text" name="no_hp" class="form-control" required onkeypress="return hanyaAngka(event)">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control">
                    <?php
                    if (isset($_GET['email_exist']) && $_GET['email_exist'] == 'true') {
                        echo '<div class="alert alert-danger">Email sudah terdaftar.</div>';
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="btn-container">
                    <button type="submit" class="btn btn-success btn-full">Simpan</button>
                    <a href="index_admin.php?page=warga" class="btn btn-secondary btn-full">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        document.querySelector('form').addEventListener('submit', function(event) {
            const nikInput = document.querySelector('input[name="nik"]');
            const nikValue = nikInput.value;
            const nikError = document.getElementById('nik-error');

            if (nikValue.length !== 16 || !/^\d+$/.test(nikValue)) {
                nikError.textContent = 'NIK harus terdiri dari 16 digit angka.';
                event.preventDefault();
            } else {
                nikError.textContent = '';
            }
        });
    </script>
</body>

</html>