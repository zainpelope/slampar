<?php
include('koneksi.php');


$per_page = 5;
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;


$sql_count = "SELECT COUNT(*) AS total FROM sejarah";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);


$query = "SELECT * FROM sejarah ORDER BY id_sejarah DESC LIMIT $start_from, $per_page";
$result = $conn->query($query);
?>

<main class="main">
    <div class="page-title dark-background"></div>

    <div class="container my-5" data-aos="fade-up" data-aos-delay="200">

        <section id="sejarah" class="profil-section">
            <div class="section-title text-center">
                <h2>Sejarah</h2>
            </div>

            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <img src="uploads/<?= $row['gambar']; ?>" alt="Sejarah" class="img-fluid" width="500" height="500">
                    </div>
                    <div class="col-md-6">
                        <p><?= $row['keterangan']; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>

            <nav aria-label="Page navigation example" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if ($halaman <= 1) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?php if ($halaman > 1) {
                                                        echo '?page=sejarah&halaman=' . ($halaman - 1);
                                                    } ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?php if ($i == $halaman) {
                                                    echo 'active';
                                                } ?>">
                            <a class="page-link" href="?page=sejarah&halaman=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if ($halaman >= $total_pages) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?php if ($halaman < $total_pages) {
                                                        echo '?page=sejarah&halaman=' . ($halaman + 1);
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