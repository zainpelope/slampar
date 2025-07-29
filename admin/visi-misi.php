<?php
include 'koneksi.php';

$visi_query = "SELECT id, isi FROM visi";
$visi_result = $conn->query($visi_query);
$visi_text = "";

while ($row = $visi_result->fetch_assoc()) {
    $visi_text .= "<div class='d-flex justify-content-between align-items-center border-bottom py-2'>";
    $visi_text .= "<p>" . htmlspecialchars($row['isi']) . "</p>";
    $visi_text .= "<div class='btn-group'>";
    $visi_text .= "<a href='admin/edit_visi.php?id=" . $row['id'] . "' class='btn btn-sm btn-primary border-bottom'>Edit</a>"; // Tambahkan border-bottom
    $visi_text .= "<a href='admin/hapus_visi.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger border-bottom' onclick='return confirm(\"Apakah Anda yakin ingin menghapus visi ini?\")'>Hapus</a>"; // Tambahkan border-bottom
    $visi_text .= "</div>";
    $visi_text .= "</div>";
}

$misi_query = "SELECT id, isi FROM misi";
$misi_result = $conn->query($misi_query);
$misi_text = "";

while ($row = $misi_result->fetch_assoc()) {
    $misi_text .= "<div class='d-flex justify-content-between align-items-center border-bottom py-2'>";
    $misi_text .= "<p>" . htmlspecialchars($row['isi']) . "</p>";
    $misi_text .= "<div class='btn-group'>";
    $misi_text .= "<a href='admin/edit_misi.php?id=" . $row['id'] . "' class='btn btn-sm btn-primary border-bottom'>Edit</a>"; // Tambahkan border-bottom
    $misi_text .= "<a href='admin/hapus_misi.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger border-bottom' onclick='return confirm(\"Apakah Anda yakin ingin menghapus misi ini?\")'>Hapus</a>"; // Tambahkan border-bottom
    $misi_text .= "</div>";
    $misi_text .= "</div>";
}
?>

<main class="main">
    <div class="page-title dark-background"></div>
    <div class="container my-5" data-aos="fade-up" data-aos-delay="200">
        <section id="visimisi" class="vision-mission mt-5">
            <div class="d-flex justify-content-between mb-3">
                <h3>VISI & MISI</h3>
            </div>
            <div>
                <a href="admin/tambah_visi.php" class="btn btn-primary">Tambah Visi</a>
                <a href="admin/tambah_misi.php" class="btn btn-primary">Tambah Misi</a>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>VISI</th>
                                <th>MISI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $visi_text; ?></td>
                                <td><?php echo $misi_text; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</main>

<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>