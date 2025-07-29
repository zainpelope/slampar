<?php
include 'koneksi.php';

$sql = "SELECT * FROM banner";
$result = $conn->query($sql);
$no = 1;

?>

<!DOCTYPE html>
<html>

<head>
    <title>Daftar Banner</title>
    <script>
        function konfirmasiHapus(id) {
            var konfirmasi = confirm("Apakah Anda yakin ingin menghapus banner ini?");
            if (konfirmasi) {
                window.location.href = "hapus_banner.php?id=" + id;
            }
        }
    </script>
</head>

<body>
    <h1>Daftar Banner</h1>
    <a href="tambah_banner.php">Tambah Banner</a><br><br>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no . "</td>";
                echo "<td><img src='" . $row['gambar'] . "' width='100'></td>";
                echo "<td>" . $row['judul'] . "</td>";
                echo "<td>" . $row['keterangan'] . "</td>";
                echo "<td><a href='edit_banner.php?id=" . $row['id_banner'] . "'>Edit</a> | <a href='#' onclick='konfirmasiHapus(" . $row['id_banner'] . ")'>Hapus</a></td>"; // Panggil fungsi konfirmasi
                echo "</tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data banner.</td></tr>";
        }
        ?>
    </table>
</body>

</html>