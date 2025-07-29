<?php
include '../koneksi.php'; // Koneksi ke database
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pengajuan Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Daftar Pengajuan Surat</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Surat</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM pengajuan_surat";
                $result = mysqli_query($conn, $query);
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>" >
                        "<td>{$no}</td>"
                        . "<td>{$row['jenis_surat']}</td>"
                        . "<td>{$row['status']}</td>"
                        . "<td>{$row['tanggal_pengajuan']}</td>"
                        . "<td><a href='detail_surat.php?id={$row['id']}' class='btn btn-info'>Detail</a></td>"
                        . "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>

        <h3>Ajukan Surat Baru</h3>
        <div class="btn-group">
            <a href="../coba/domisili.php" class="btn btn-primary">Domisili</a>
            <a href="../coba/sktm.php" class="btn btn-secondary">Tidak Mampu</a>
            <a href="../coba/usaha.php" class="btn btn-success">Usaha</a>
            <a href="../coba/nikah.php" class="btn btn-warning">Belum Menikah</a>
            <a href="../coba/tanah.php" class="btn btn-danger">Tanah</a>
        </div>
    </div>
</body>

</html>