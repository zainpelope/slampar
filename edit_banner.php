<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    die("Anda harus login sebagai admin untuk mengakses halaman ini.");
}

$id_admin = $_SESSION['id_admin'];


if (!isset($_GET['id'])) {
    die("ID banner tidak ditemukan.");
}

$id_banner = $_GET['id'];


$sql = "SELECT * FROM banner WHERE id_banner = '$id_banner'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Data banner tidak ditemukan.");
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $keterangan = $_POST['keterangan'];
    $gambar_lama = $row['gambar'];


    if (!empty($_FILES["gambar"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


        $allowed_formats = ["jpg", "png", "jpeg", "gif", "webp"];
        if (!in_array($imageFileType, $allowed_formats)) {
            echo "Hanya file JPG, PNG, JPEG, GIF, dan WEBP yang diizinkan.";
            exit();
        }


        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {

            if (file_exists($gambar_lama)) {
                unlink($gambar_lama);
            }
            $gambar = $target_file;
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload file.";
            exit();
        }
    } else {
        $gambar = $gambar_lama;
    }


    $sql_update = "UPDATE banner SET gambar = '$gambar', judul = '$judul', keterangan = '$keterangan' WHERE id_banner = '$id_banner'";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: index_admin.php?admin=home_admin");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Banner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Banner</h1>
        <form method="post" action="" enctype="multipart/form-data" class="p-4 bg-light rounded shadow">
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar:</label>
                <input type="file" class="form-control" name="gambar" id="gambar">
                <img src="<?php echo $row['gambar']; ?>" alt="Banner Lama" class="img-fluid mt-2" style="max-height: 200px;">
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label">Judul:</label>
                <input type="text" class="form-control" name="judul" id="judul" value="<?php echo $row['judul']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan:</label>
                <textarea class="form-control" name="keterangan" id="keterangan"><?php echo $row['keterangan']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update</button>
            <a href="index_admin.php?admin=home_admin" class="btn btn-danger w-100 mt-2">Kembali</a>
        </form>
    </div>
</body>

</html>