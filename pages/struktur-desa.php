<?php
include 'koneksi.php';
session_start();


$per_page = 10;
$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman']) ? $_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}
$start_from = ($halaman - 1) * $per_page;


$sql_count = "SELECT COUNT(*) AS total FROM struktur";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);


$sql = "SELECT * FROM struktur 
        ORDER BY 
            CASE WHEN jabatan = 'Kepala Desa' THEN 1 ELSE 2 END, 
            nama ASC
        LIMIT $start_from, $per_page";

$result = $conn->query($sql);
?>

<main class="main">
    <div class="page-title dark-background"></div>

    <div class="container my-5" data-aos="fade-up" data-aos-delay="200">
        <section id="struktur-desa" class="my-5">
            <div class="section-title text-center">
                <h2>Struktur Desa</h2>
            </div>
            <div class="row justify-content-center">
                <?php if ($result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="col-md-3 mb-3">
                            <div class="card shadow">
                                <img src="admin/uploads/<?= $row['gambar'] ?>" class="card-img-top" alt="struktur-desa" style="width: 100%; height: 300px; object-fit: cover; padding: 6px;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="text-align: center;">
                                    <p class="card-text font-weight-bold"><?= htmlspecialchars($row['nama']) ?></p>
                                    <p class="card-text"><?= htmlspecialchars($row['jabatan']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="text-center">Data struktur desa tidak ditemukan.</p>
                <?php } ?>
            </div>

            <nav aria-label="Page navigation example" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if ($halaman <= 1) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?php if ($halaman > 1) {
                                                        echo '?page=struktur-desa&halaman=' . ($halaman - 1);
                                                    } ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?php if ($i == $halaman) {
                                                    echo 'active';
                                                } ?>">
                            <a class="page-link" href="?page=struktur-desa&halaman=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if ($halaman >= $total_pages) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?php if ($halaman < $total_pages) {
                                                        echo '?page=struktur-desa&halaman=' . ($halaman + 1);
                                                    } ?>">Next</a>
                    </li>
                </ul>
            </nav>

        </section>
    </div>
</main>

<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<div id="preloader"></div>