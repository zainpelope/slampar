<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    die("Anda harus login sebagai admin untuk mengakses halaman ini.");
}

$id_admin = $_SESSION['id_admin'];

function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keterangan = clean_input($_POST['keterangan']);

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        $error_message = "File bukan gambar.";
    }

    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_types)) {
        $error_message = "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
    }

    if (!isset($error_message)) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = basename($_FILES["gambar"]["name"]);

            $sql = "REPLACE INTO potensi_desa (id, gambar, keterangan, id_admin) VALUES (1, '$gambar', '$keterangan', '$id_admin')";
            if (mysqli_query($conn, $sql)) {
                header("Location: ../index_admin.php?admin=home_admin&status=success");
                exit();
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        } else {
            $error_message = "Gagal mengupload gambar.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Potensi Desa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h1>Update Potensi Desa</h1>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form action="create.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="gambar">Gambar:</label>
            <input type="file" class="form-control-file" id="gambar" name="gambar" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="../index_admin.php?admin=home_admin" class="btn btn-secondary">Kembali</a>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>