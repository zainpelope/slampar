<?php
include 'koneksi.php';


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

        <?php if ($result->num_rows > 0): ?>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = $start_from + 1;
                    ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= htmlspecialchars($row["judul"]) ?></td>
                            <td>
                                <div class="limited-text">
                                    <?= nl2br(htmlspecialchars($row["keterangan"])) ?>
                                </div>
                                <?php if (str_word_count($row["keterangan"]) > 40): ?>
                                    <a href="detail.php?id=<?= $row['id_pengumuman'] ?>" class="see-more">Lihat Selengkapnya</a>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d-m-Y', strtotime($row["tanggal"])) ?></td>
                        </tr>
                        <?php $no++; ?>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <nav aria-label="Page navigation example" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if ($halaman <= 1) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?php if ($halaman > 1) {
                                                        echo '?page=pengumuman&halaman=' . ($halaman - 1);
                                                    } ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?php if ($i == $halaman) {
                                                    echo 'active';
                                                } ?>">
                            <a class="page-link" href="?page=pengumuman&halaman=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if ($halaman >= $total_pages) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?php if ($halaman < $total_pages) {
                                                        echo '?page=pengumuman&halaman=' . ($halaman + 1);
                                                    } ?>">Next</a>
                    </li>
                </ul>
            </nav>

        <?php else: ?>
            <p>Tidak ada pengumuman saat ini.</p>
        <?php endif; ?>
    </div>
</main>

<?php include('footer.html'); ?>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<?php $conn->close(); ?>

<style>
    .limited-text {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .see-more {
        color: blue;
        font-style: italic;
        cursor: pointer;
        text-decoration: none;
    }

    .see-more:hover {
        text-decoration: underline;
    }
</style>