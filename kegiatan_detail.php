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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Kegiatan</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .row {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start; 
        }

        .label {
            width: 200px;
            font-weight: bold;
            color: #555;
            padding-top: 5px; 
        }

        .value {
            flex: 1;
        }

        .value img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .kembali {
            text-align: center;
            margin-top: 20px;
        }

        .kembali a {
            display: block;
            width: 100%;
            padding: 10px 0;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Detail Kegiatan</h1>
    <div class="container">
    <div class="row">
            <div class="label">Gambar:</div>
            <div class="value"><img src="admin/uploads/<?php echo $row['gambar']; ?>" alt="Gambar Kegiatan"></div>
        </div>
        <div class="row">
            <div class="label">Nama Kegiatan:</div>
            <div class="value"><?php echo $row['nama_kegiatan']; ?></div>
        </div>
     
        <div class="row">
            <div class="label">Tanggal Mulai:</div>
            <div class="value"><?php echo $row['tanggal_mulai']; ?></div>
        </div>
        <div class="row">
            <div class="label">Tanggal Selesai:</div>
            <div class="value"><?php echo $row['tanggal_selesai']; ?></div>
        </div>
        <div class="row">
            <div class="label">Lokasi:</div>
            <div class="value"><?php echo $row['lokasi']; ?></div>
        </div>
        <div class="row">
            <div class="label">Keterangan:</div>
            <div class="value"><?php echo $row['keterangan']; ?></div>
        </div>
        <div class="kembali">
            <a href="index.php?page=kegiatan">Kembali</a>
        </div>
    </div>
</body>
</html>