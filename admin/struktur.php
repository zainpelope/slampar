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

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql_gambar = "SELECT gambar FROM struktur WHERE id_struktur = ?";
    $stmt = $conn->prepare($sql_gambar);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($gambar);
    $stmt->fetch();
    $stmt->close();

    if ($gambar) {
        unlink("admin/uploads/" . $gambar);
    }

    $sql_delete = "DELETE FROM struktur WHERE id_struktur = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index_admin.php?page=struktur");
    exit();
}
?>

<main class="main">
    <div class="page-title dark-background text-center py-5 text-white"></div>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Struktur</h2>
            <a href="admin/struktur/tambah_struktur.php" class="btn btn-primary">Tambah Struktur</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = $start_from + 1;
                    while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <img src="admin/uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="Struktur" style="width: 80px; height: 80px; object-fit: cover;">
                            </td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['jabatan']) ?></td>
                            <td>
                                <a href="admin/struktur/edit_struktur.php?id=<?= $row['id_struktur'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="confirmDeleteStruktur(<?= $row['id_struktur'] ?>)">Hapus</button>
                            </td>
                            <script>
                                function confirmDeleteStruktur(id) {
                                    const userConfirmed = confirm("Apakah Anda yakin ingin menghapus struktur ini?");
                                    if (userConfirmed) {
                                        window.location.href = `index_admin.php?page=struktur&hapus=${id}`;
                                    } else {
                                        return;
                                    }
                                }
                            </script>
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
                                                    echo '?page=struktur&halaman=' . ($halaman - 1);
                                                } ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($i == $halaman) {
                                                echo 'active';
                                            } ?>">
                        <a class="page-link" href="?page=struktur&halaman=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($halaman >= $total_pages) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?php if ($halaman < $total_pages) {
                                                    echo '?page=struktur&halaman=' . ($halaman + 1);
                                                } ?>">Next</a>
                </li>
            </ul>
        </nav>

    </div>
</main>
<br><br><br>
<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>