<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_kegiatan = $_GET['id'];
    $sql = "SELECT * FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Kegiatan tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak diberikan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $keterangan = $_POST['keterangan'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $lokasi = $_POST['lokasi'];


    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['gambar']['name']);

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $sql = "UPDATE kegiatan SET 
                        nama_kegiatan='$nama_kegiatan', 
                        keterangan='$keterangan', 
                        tanggal_mulai='$tanggal_mulai', 
                        tanggal_selesai='$tanggal_selesai', 
                        lokasi='$lokasi', 
                        gambar='$gambar' 
                    WHERE id_kegiatan='$id_kegiatan'";
        } else {
            echo "Gagal mengunggah gambar.";
            exit;
        }
    } else {
        $sql = "UPDATE kegiatan SET 
                    nama_kegiatan='$nama_kegiatan', 
                    keterangan='$keterangan', 
                    tanggal_mulai='$tanggal_mulai', 
                    tanggal_selesai='$tanggal_selesai', 
                    lokasi='$lokasi' 
                WHERE id_kegiatan='$id_kegiatan'";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: index_admin.php?page=kegiatan");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            padding: 20px;
        }

        .container {
            max-width: 600px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Kegiatan</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_kegiatan" class="form-label">Nama Kegiatan:</label>
                <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="<?php echo $row['nama_kegiatan']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan:</label>
                <textarea class="form-control" id="keterangan" name="keterangan"><?php echo $row['keterangan']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $row['tanggal_mulai']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai:</label>
                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo $row['tanggal_selesai']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi:</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo $row['lokasi']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Lama:</label><br>
                <img src="admin/uploads/<?php echo $row['gambar']; ?>" width="150"><br>
                <label for="gambar" class="form-label">Gambar Baru:</label>
                <input class="form-control" type="file" id="gambar" name="gambar">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index_admin.php?page=kegiatan" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>