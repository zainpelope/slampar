<?php
include 'koneksi.php';


$per_page = 8;
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;

$sql_count = "SELECT COUNT(*) AS total FROM berita";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);

$sql = "SELECT * FROM berita LIMIT $start_from, $per_page";
$result = $conn->query($sql);

?>

<main class="main">
    <div class="page-title dark-background"></div>
    <div class="container my-5" data-aos="fade-up" data-aos-delay="200">
        <section id="berita" class="berita section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Berita</h2>
                <p>Menyajikan informasi terbaru tentang peristiwa dan berita terkini dari Desa Larangan Slampar.</p>
            </div>
            <div class="container">
                <div class="row">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                            <div class="member">
                                <a href="pages/detail_berita.php?id=<?= $row['id_berita']; ?>">
                                    <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="img-fluid" alt="" style="width: 200px; height: 200px; object-fit: cover;">
                                    <div class="member-content">
                                        <h5 class="mb-1"><?= htmlspecialchars($row['judul']) ?></h5>
                                        <p class="text-muted"><?= htmlspecialchars($row['tanggal']) ?></p>
                                        <p class="mb-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            <?= htmlspecialchars($row['keterangan']) ?>
                                        </p>
                                        <a href="pages/detail_berita.php?id=<?= $row['id_berita']; ?>" class="btn btn-link">Lihat Selengkapnya</a>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
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
        </section>
    </div>
</main>
<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<div id="preloader"></div>