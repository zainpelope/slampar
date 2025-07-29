<?php
include('koneksi.php');

$per_page = 5;
$current_page = isset($_GET['page']) ? $_GET['page'] : 'sejarah';
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;
$query = "SELECT * FROM sejarah ORDER BY id_sejarah DESC LIMIT $start_from, $per_page";
$result = $conn->query($query);
$total_records_query = "SELECT COUNT(*) AS total FROM sejarah";
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);
?>
<main class="main">
    <div class="page-title dark-background"></div>
    <div class="container my-5" data-aos="fade-up" data-aos-delay="200">
        <section id="sejarah" class="profil-section">
            <div class="section-title text-center">
                <h2>Sejarah</h2>
            </div>

            <a href="admin/sejarah/tambah_sejarah.php" class="btn btn-primary mb-3">Tambah Sejarah</a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $start_from + 1;
                        while ($row = $result->fetch_assoc()) :
                            $gambar_path = "uploads/" . htmlspecialchars($row['gambar']);
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <?php if (!empty($row['gambar']) && file_exists($gambar_path)) : ?>
                                        <img src="<?= $gambar_path ?>" alt="Sejarah" style="width: 100px; height: 100px; object-fit: cover;">
                                    <?php else : ?>
                                        <img src="assets/img/default-image.png" alt="Default" style="width: 100px; height: 100px; object-fit: cover;">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['keterangan']); ?></td>
                                <td>
                                    <a href="admin/sejarah/detail_sejarah.php?id=<?= $row['id_sejarah']; ?>" class="btn btn-info btn-sm">Detail</a>
                                    <a href="admin/sejarah/edit_sejarah.php?id=<?= $row['id_sejarah']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="admin/sejarah/hapus_sejarah.php?id=<?= $row['id_sejarah']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item <?php if ($halaman <= 1) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?php if ($halaman > 1) {
                                                        echo '?page=' . $current_page . '&halaman=' . ($halaman - 1);
                                                    } ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?php if ($i == $halaman) {
                                                    echo 'active';
                                                } ?>">
                            <a class="page-link" href="?page=<?= $current_page ?>&halaman=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if ($halaman >= $total_pages) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?php if ($halaman < $total_pages) {
                                                        echo '?page=' . $current_page . '&halaman=' . ($halaman + 1);
                                                    } ?>">Next</a>
                    </li>
                </ul>
            </nav>

        </section>
    </div>
</main>

<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>
<div id="preloader"></div>