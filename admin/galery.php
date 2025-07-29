<?php
include 'koneksi.php';
session_start();

$per_page = 8;
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;

$sql_count = "SELECT COUNT(*) AS total FROM galery";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);

$sql = "SELECT * FROM galery LIMIT $start_from, $per_page";
$result = $conn->query($sql);

// Proses Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Ambil nama gambar dari database
    $sql_gambar = "SELECT gambar FROM galery WHERE id_galery = ?";
    $stmt = $conn->prepare($sql_gambar);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($gambar);
    $stmt->fetch();
    $stmt->close();

    // Hapus file gambar jika ada
    if ($gambar && file_exists("uploads/" . $gambar)) {
        unlink("uploads/" . $gambar);
    }

    // Hapus data dari database
    $sql_delete = "DELETE FROM galery WHERE id_galery = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Gambar berhasil dihapus!'); window.location.href='index_admin.php?page=galery';</script>";
    } else {
        echo "<script>alert('Gagal menghapus gambar!');</script>";
    }
    $stmt->close();
}
?>

<main class="main">
    <div class="page-title dark-background text-center py-5 text-white"></div>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Gambar</h2>
            <a href="admin/galery/form_tambah_gambar.php" class="btn btn-primary">Tambah Gambar</a>
        </div>

        <div class="row g-4">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="ratio ratio-1x1">
                            <img src="uploads/<?= $row['gambar'] ?>" class="card-img-top" alt="Gambar" style="object-fit: cover;">
                        </div>
                        <div class="card-body text-center">
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id_galery'] ?>)">Hapus</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Navigasi Pagination -->
        <nav aria-label="Page navigation example" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($halaman <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= ($halaman > 1) ? '?page=galery&halaman=' . ($halaman - 1) : '#' ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?= ($i == $halaman) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=galery&halaman=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($halaman >= $total_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= ($halaman < $total_pages) ? '?page=galery&halaman=' . ($halaman + 1) : '#' ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</main>

<!-- Tambahkan Konfirmasi Hapus -->
<script>
    function confirmDelete(id) {
        if (confirm("Apakah Anda yakin ingin menghapus gambar ini?")) {
            window.location.href = "index_admin.php?page=galery&hapus=" + id;
        }
    }
</script>

<br><br><br>

<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>