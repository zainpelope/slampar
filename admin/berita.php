<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

$per_page = 5;
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;


$sql_count = "SELECT COUNT(*) AS total FROM berita";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql_gambar = "SELECT gambar FROM berita WHERE id_berita = ?";
    $stmt = $conn->prepare($sql_gambar);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($gambar);
    $stmt->fetch();
    $stmt->close();

    if ($gambar) {
        unlink("uploads/" . $gambar);
    }

    $sql_delete = "DELETE FROM berita WHERE id_berita = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index_admin.php?page=berita");
    exit();
}

$sql = "SELECT * FROM berita LIMIT $start_from, $per_page";
$result = $conn->query($sql);
?>

<main class="main ">
    <div class="page-title dark-background text-center py-5 text-white"></div>
    <div class="container mt-5">
        <h1 class="text-center">Daftar Berita</h1>
        <a href="admin/berita/tambah_berita.php" class="btn btn-primary mb-3">Tambah Berita</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Gambar</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = $start_from + 1;
                    while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['judul']) ?></td>
                            <td class="text-center">
                                <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="img-thumbnail" style="max-width: 150px; max-height: 150px; width: 150px; height: 150px; object-fit: cover;">
                            </td>
                            <td style="display: -webkit-box; -webkit-line-clamp: 6; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; white-space: normal;"><?= htmlspecialchars($row['keterangan']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td class="text-center">
                                <a href="admin/berita/berita_detail.php?id_berita=<?= $row['id_berita'] ?>" class="btn btn-warning btn-sm">Detail</a>
                                <a href="admin/berita/edit_berita.php?id_berita=<?= $row['id_berita'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="index_admin.php?page=berita&hapus=<?= $row['id_berita'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation example" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($halaman <= 1) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?php if ($halaman > 1) {
                                                    echo '?page=berita&halaman=' . ($halaman - 1);
                                                } ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($i == $halaman) {
                                                echo 'active';
                                            } ?>">
                        <a class="page-link" href="?page=berita&halaman=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($halaman >= $total_pages) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?php if ($halaman < $total_pages) {
                                                    echo '?page=berita&halaman=' . ($halaman + 1);
                                                } ?>">Next</a>
                </li>
            </ul>
        </nav>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</main>

<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>