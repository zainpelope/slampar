<?php
include('koneksi.php');


$per_page = 5;
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;


$sql_count = "SELECT COUNT(*) AS total FROM pengumuman";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);


$sql = "SELECT * FROM pengumuman ORDER BY tanggal DESC LIMIT $start_from, $per_page";
$result = $conn->query($sql);
?>

<main class="main">
    <div class="page-title dark-background"></div>
    <div class="container my-5" data-aos="fade-up" data-aos-delay="200">
        <h2>Pengumuman</h2>
        <a href="tambah_pengumuman.php" class="btn btn-success mb-3">Tambah Pengumuman</a>

        <?php
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>No</th>";
            echo "<th>Judul</th>";
            echo "<th>Keterangan</th>";
            echo "<th>Tanggal</th>";
            echo "<th>Aksi</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            $no = $start_from + 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no . "</td>";
                echo "<td>" . $row["judul"] . "</td>";
                echo "<td>" . $row["keterangan"] . "</td>";
                $tanggal = date('d-m-Y', strtotime($row["tanggal"]));
                echo "<td>" . $tanggal . "</td>";
                echo "<td>";
                echo "<a href='detail_pengumuman.php?id=" . $row["id_pengumuman"] . "' class='btn btn-primary btn-sm'>Detail</a> ";
                echo "<a href='edit_pengumuman.php?id=" . $row["id_pengumuman"] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                echo "<a href='hapus_pengumuman.php?id=" . $row["id_pengumuman"] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')\">Hapus</a>";
                echo "</td>";
                echo "</tr>";
                $no++;
            }

            echo "</tbody>";
            echo "</table>";


            echo "<nav aria-label='Page navigation example' class='mt-4'>";
            echo "<ul class='pagination justify-content-center'>";
            echo "<li class='page-item " . ($halaman <= 1 ? 'disabled' : '') . "'>";
            echo "<a class='page-link' href='" . ($halaman > 1 ? "?page=pengumuman&halaman=" . ($halaman - 1) : "#") . "'>Previous</a>";
            echo "</li>";
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li class='page-item " . ($i == $halaman ? 'active' : '') . "'>";
                echo "<a class='page-link' href='?page=pengumuman&halaman=" . $i . "'>" . $i . "</a>";
                echo "</li>";
            }
            echo "<li class='page-item " . ($halaman >= $total_pages ? 'disabled' : '') . "'>";
            echo "<a class='page-link' href='" . ($halaman < $total_pages ? "?page=pengumuman&halaman=" . ($halaman + 1) : "#") . "'>Next</a>";
            echo "</li>";
            echo "</ul>";
            echo "</nav>";
        } else {
            echo "<p>Tidak ada pengumuman saat ini.</p>";
        }
        ?>
    </div>
</main>

<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<?php
$conn->close();
?>