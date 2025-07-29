<?php
include('koneksi.php');

$limit = 10;
$page = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
$start = ($page - 1) * $limit;


$search = isset($_GET['search']) ? $_GET['search'] : "";
$searchQuery = $search ? "WHERE nama LIKE '%$search%' OR nik LIKE '%$search%'" : "";


$sql_count = "SELECT COUNT(*) as total FROM warga $searchQuery";
$result_count = mysqli_query($conn, $sql_count);
$total = mysqli_fetch_assoc($result_count)['total'];
$totalPages = ceil($total / $limit);


$sql = "SELECT * FROM warga $searchQuery LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);
?>

<main class="main">
    <div class="page-title dark-background"></div>
    <div class="container my-5" data-aos="fade-up" data-aos-delay="200">
        <section id="sejarah" class="profil-section">
            <div class="section-title text-center">
                <h2>Warga</h2>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="tambah_warga.php" class="btn btn-primary">Tambah Warga</a>
                <span class="badge bg-success p-2 fs-6">Jumlah Warga: <?= $total; ?></span>
            </div>


            <form method="GET" action="" class="mb-3 d-flex">
                <input type="hidden" name="page" value="warga">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama / NIK" value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-success">Cari</button>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $start + 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nik']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tanggal_lahir']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['no_hp']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>
                                <a href='edit_warga.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='hapus_warga.php?id=" . $row['id'] . "' onclick='return confirm(\"Yakin ingin menghapus?\")' class='btn btn-danger btn-sm'>Hapus</a>
                              </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>


            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=warga&page_no=<?= $page - 1 ?>&search=<?= htmlspecialchars($search) ?>">Sebelumnya</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=warga&page_no=<?= $i ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=warga&page_no=<?= $page + 1 ?>&search=<?= htmlspecialchars($search) ?>">Selanjutnya</a>
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