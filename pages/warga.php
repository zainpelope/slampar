<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_pengguna'])) {
    header("Location: login.php");
    exit();
}

$id_pengguna = $_SESSION['id_pengguna'];

$query_user = "SELECT * FROM warga WHERE id = '$id_pengguna'";
$result_user = $conn->query($query_user);
$user = $result_user->fetch_assoc();


$batas = 5;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$previous = $halaman - 1;
$next = $halaman + 1;


$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$where = "";
if ($cari != '') {
    $where = "AND jenis_surat LIKE '%$cari%'";
}

$data = mysqli_query($conn, "SELECT * FROM pengajuan_surat WHERE id_pengguna = '$id_pengguna' $where");
$jumlah_data = mysqli_num_rows($data);
$total_halaman = ceil($jumlah_data / $batas);

$query_surat = "SELECT * FROM pengajuan_surat WHERE id_pengguna = '$id_pengguna' $where ORDER BY tanggal_pengajuan DESC LIMIT $halaman_awal, $batas";
$result_surat = $conn->query($query_surat);
?>

<main class="main">
    <div class="page-title dark-background"></div>
    <div class="container mt-4">

        <a href="form_pengajuan.php" class="btn btn-primary">Ajukan Surat Baru</a>

        <hr>

        <h3>Status Pengajuan Surat</h3>

        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Jenis Surat" name="cari" value="<?= $cari; ?>">
                <input type="hidden" name="page" value="warga">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Surat</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Tanggal Selesai</th>
                    <th>Alasan Penolakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = $halaman_awal + 1;
                while ($row = $result_surat->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['jenis_surat']; ?></td>
                        <td>
                            <span class="badge bg-<?= ($row['status'] == 'Siap Diambil') ? 'success' : (($row['status'] == 'Ditolak') ? 'danger' : 'warning'); ?>">
                                <?= $row['status']; ?>
                            </span>
                        </td>
                        <td><?= $row['tanggal_pengajuan']; ?></td>
                        <td><?= $row['tanggal_selesai'] ? $row['tanggal_selesai'] : '-'; ?></td>
                        <td><?= ($row['status'] == 'Ditolak' && $row['alasan_penolakan']) ? $row['alasan_penolakan'] : '-'; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($halaman > 1) { ?>
                    <li class="page-item"><a class="page-link" href="?page=warga&cari=<?= $cari; ?>&halaman=<?= $previous; ?>">Previous</a></li>
                <?php } ?>
                <?php
                for ($x = 1; $x <= $total_halaman; $x++) {
                ?>
                    <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>"><a class="page-link" href="?page=warga&cari=<?= $cari; ?>&halaman=<?= $x; ?>"><?= $x; ?></a></li>
                <?php
                }
                ?>
                <?php if ($halaman < $total_halaman) { ?>
                    <li class="page-item"><a class="page-link" href="?page=warga&cari=<?= $cari; ?>&halaman=<?= $next; ?>">Next</a></li>
                <?php } ?>
            </ul>
        </nav>

    </div>

</main>

<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>