<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('koneksi.php');

$batas = 10;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$previous = $halaman - 1;
$next = $halaman + 1;

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
// --- MENAMBAHKAN FILTER STATUS ---
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

$where_clauses = [];
$params = [];
$types = "";

if ($cari != '') {
    $where_clauses[] = "(p.nama LIKE ? OR ps.jenis_surat LIKE ?)";
    $params[] = '%' . $cari . '%';
    $params[] = '%' . $cari . '%';
    $types .= "ss";
}

// --- MENAMBAHKAN KONDISI WHERE UNTUK FILTER STATUS ---
if ($status_filter != '') {
    $where_clauses[] = "ps.status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$where = "";
if (!empty($where_clauses)) {
    $where = "WHERE " . implode(" AND ", $where_clauses);
}

// Total Data untuk Pagination
$stmt_count_sql = "SELECT COUNT(*) FROM pengajuan_surat ps JOIN warga p ON ps.id_pengguna = p.id " . $where;
$stmt_count = $conn->prepare($stmt_count_sql);
if (!empty($params)) {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$stmt_count->bind_result($jumlah_data);
$stmt_count->fetch();
$stmt_count->close();
$total_halaman = ceil($jumlah_data / $batas);

// Query utama untuk menampilkan data
$query_sql = "SELECT ps.*, p.nama FROM pengajuan_surat ps JOIN warga p ON ps.id_pengguna = p.id " . $where . " ORDER BY ps.tanggal_pengajuan DESC LIMIT ?, ?";
$stmt = $conn->prepare($query_sql);

// Bind parameter untuk query utama (termasuk LIMIT)
$final_params = array_merge($params, [$halaman_awal, $batas]);
$final_types = $types . "ii";

$stmt->bind_param($final_types, ...$final_params);
$stmt->execute();
$result = $stmt->get_result();

$total_masuk = $conn->query("SELECT COUNT(*) as total FROM pengajuan_surat")->fetch_assoc()['total'];
$total_ditolak = $conn->query("SELECT COUNT(*) as total FROM pengajuan_surat WHERE status = 'Ditolak'")->fetch_assoc()['total'];
$total_diproses = $conn->query("SELECT COUNT(*) as total FROM pengajuan_surat WHERE status = 'Diproses'")->fetch_assoc()['total'];
$total_diambil = $conn->query("SELECT COUNT(*) as total FROM pengajuan_surat WHERE status = 'Siap Diambil'")->fetch_assoc()['total'];
?>

<main class="main">
    <div class="page-title dark-background"></div>
    <div class="container mt-4">
        <h2>Daftar Pengajuan Surat</h2>

        <div class="mt-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Masuk</h5>
                            <p class="card-text"><?= $total_masuk; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Ditolak</h5>
                            <p class="card-text"><?= $total_ditolak; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Diproses</h5>
                            <p class="card-text"><?= $total_diproses; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <a href="?page=layanan_publik&status_filter=Siap%20Diambil" style="text-decoration: none; color: inherit;">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Diambil</h5>
                                <p class="card-text"><?= $total_diambil; ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <br>

        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Nama/Jenis Surat" name="cari" value="<?= $cari; ?>">
                <input type="hidden" name="page" value="layanan_publik">
                <?php if ($status_filter != '') { ?>
                    <input type="hidden" name="status_filter" value="<?= $status_filter; ?>">
                <?php } ?>
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Tanggal Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = $halaman_awal + 1;
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['jenis_surat']; ?></td>
                        <td>
                            <span class="badge bg-<?php
                                                    if ($row['status'] == 'Siap Diambil') {
                                                        echo 'primary';
                                                    } elseif ($row['status'] == 'Ditolak') {
                                                        echo 'danger';
                                                    } elseif ($row['status'] == 'Diproses') {
                                                        echo 'warning';
                                                    } elseif ($row['status'] == 'Menunggu Verifikasi') {
                                                        echo 'info';
                                                    } else {
                                                        echo 'secondary';
                                                    }
                                                    ?>">
                                <?= $row['status']; ?>
                            </span>
                        </td>
                        <td><?= $row['tanggal_pengajuan']; ?></td>
                        <td><?= $row['tanggal_selesai'] ? $row['tanggal_selesai'] : '-'; ?></td>
                        <td>
                            <a href="detail_pengajuan.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">Detail</a>
                            <?php if ($row['status'] == 'Menunggu Verifikasi') { ?>
                                <a href="verifikasi.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Verifikasi</a>
                                <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#tolakModal<?= $row['id']; ?>">Tolak</a>

                                <div class="modal fade" id="tolakModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="tolakModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="tolakModalLabel<?= $row['id']; ?>">Alasan Penolakan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="tolak.php?id=<?= $row['id']; ?>" method="POST">
                                                    <div class="mb-3">
                                                        <label for="alasan_penolakan" class="form-label">Alasan Penolakan:</label>
                                                        <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="3"></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($row['status'] == 'Diproses') { ?>
                                <?php
                                $cetak_link = '';
                                switch ($row['jenis_surat']) {
                                    case 'Domisili':
                                        $cetak_link = 'cetak/cetak_domisili.php?id=' . $row['id'];
                                        break;
                                    case 'Tidak Mampu':
                                        $cetak_link = 'cetak/cetak_sktm.php?id=' . $row['id'];
                                        break;
                                    case 'Usaha':
                                        $cetak_link = 'cetak/cetak_usaha.php?id=' . $row['id'];
                                        break;
                                    case 'Belum Menikah':
                                        $cetak_link = 'cetak/cetak_belum_menikah.php?id=' . $row['id'];
                                        break;
                                    case 'Tanah':
                                        $cetak_link = 'cetak/cetak_tanah.php?id=' . $row['id'];
                                        break;
                                    default:
                                        $cetak_link = '#';
                                }
                                ?>
                                <a href="#" class="btn btn-primary btn-sm" onclick="cetakSurat('<?= $cetak_link; ?>', <?= $row['id']; ?>)">Cetak</a>
                            <?php } elseif ($row['status'] == 'Siap Diambil') { ?>
                                <?php
                                // Link download akan sama dengan link cetak, asumsikan script cetak menghasilkan PDF
                                $download_link = '';
                                switch ($row['jenis_surat']) {
                                    case 'Domisili':
                                        $download_link = 'cetak/cetak_domisili.php?id=' . $row['id'];
                                        break;
                                    case 'Tidak Mampu':
                                        $download_link = 'cetak/cetak_sktm.php?id=' . $row['id'];
                                        break;
                                    case 'Usaha':
                                        $download_link = 'cetak/cetak_usaha.php?id=' . $row['id'];
                                        break;
                                    case 'Belum Menikah':
                                        $download_link = 'cetak/cetak_belum_menikah.php?id=' . $row['id'];
                                        break;
                                    case 'Tanah':
                                        $download_link = 'cetak/cetak_tanah.php?id=' . $row['id'];
                                        break;
                                    default:
                                        $download_link = '#';
                                }
                                ?>
                                <a href="<?= $download_link; ?>" class="btn btn-success btn-sm" target="_blank">Download</a>
                            <?php } else { ?>
                                <button class="btn btn-secondary btn-sm" disabled><?= $row['status']; ?></button>
                            <?php } ?>
                            <a href="hapus_pengajuan.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus pengajuan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        // Fungsi helper untuk membangun link pagination dengan menjaga parameter cari dan status_filter
        function build_pagination_link($page_num, $cari_val, $status_filter_val)
        {
            $link = "?page=layanan_publik&halaman=" . $page_num;
            if ($cari_val != '') {
                $link .= "&cari=" . urlencode($cari_val);
            }
            if ($status_filter_val != '') {
                $link .= "&status_filter=" . urlencode($status_filter_val);
            }
            return $link;
        }
        ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($halaman > 1) { ?>
                    <li class="page-item"><a class="page-link" href="<?= build_pagination_link($previous, $cari, $status_filter); ?>">Previous</a></li>
                <?php } ?>
                <?php
                for ($x = 1; $x <= $total_halaman; $x++) {
                ?>
                    <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>"><a class="page-link" href="<?= build_pagination_link($x, $cari, $status_filter); ?>"><?= $x; ?></a></li>
                <?php
                }
                ?>
                <?php if ($halaman < $total_halaman) { ?>
                    <li class="page-item"><a class="page-link" href="<?= build_pagination_link($next, $cari, $status_filter); ?>">Next</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>

    <script>
        function cetakSurat(url, id) {
            window.open(url, '_blank'); // Buka jendela cetak surat
            fetch('siap_diambil.php?id=' + id, { // Kirim permintaan untuk update status
                    method: 'GET'
                }).then(response => {
                    if (response.ok) {
                        location.reload(); // Reload halaman setelah update berhasil
                    } else {
                        console.error('Failed to update status.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</main>

<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<?php
if ($stmt) {
    $stmt->close();
}
$conn->close();
?>