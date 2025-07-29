<?php
include 'koneksi.php';
$sql_potensi = "SELECT * FROM potensi_desa";
$result_potensi = $conn->query($sql_potensi);
?>

<main class="main">


    <section id="features-2" class="features section features-2">
        <div class="container section-title" data-aos="fade-up">

            <a href="admin/create.php" style="text-decoration: none;">
                <h2 style="cursor: pointer; color: black; transition: 0.3s;">
                    Potensi Desa
                </h2>
            </a>

            <style>
                a h2:hover {
                    color: black;
                    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
                }
            </style>
            <?php
            $row = $result_potensi->fetch_assoc();
            if ($row) {
            ?>
                <p><?php echo $row['keterangan']; ?></p>
        </div>
        <div class="container">
            <div class="row gy-4 justify-content-between">
                <div class="features-image col-lg-4 d-flex align-items-center" data-aos="fade-up">
                    <img src="uploads/<?php echo $row['gambar']; ?>" class="img-fluid" alt="Potensi Desa">
                </div>
                <div class="col-lg-7 d-flex flex-column justify-content-center">
                    <div class="features-item d-flex" data-aos="fade-up" data-aos-delay="200">
                        <div class="row">
                            <?php
                            $sql = "SELECT * FROM umkm_desa";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='col-lg-7'>"; // Tambahkan col-lg-7 di sini
                                    echo "<i class='bi bi-store flex-shrink-0'></i>";
                                    echo "<div class='info-umkm flex-grow-1'>";
                                    echo "<h4><a href='tambah_umkm.php?id=" . $row["id_umkm"] . "' style='color: black;'>" . $row["title"] . "</a></h4>";
                                    echo "<p>" . $row["keterangan"] . "</p>";
                                    echo "</div>";
                                    echo "<div class='action-buttons ml-auto'>";
                                    echo "<a href='edit_umkm.php?id=" . $row["id_umkm"] . "' class='text-warning small' style='font-size: 12px;'>Edit</a> | ";
                                    echo "<a href='#' onclick='konfirmasiHapus(" . $row["id_umkm"] . ")' class='text-danger small' style='font-size: 12px;'>Hapus</a>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<div class='col-lg-12'><p>Tidak ada data UMKM.</p></div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <?php
            if ($row = $result_potensi->fetch_assoc()) {
                echo "<p>" . $row['keterangan'] . "</p>";
            }
            ?>
            </div>


        </div>
        </div>

        </div>
    </section>



</main>
<script>
    function konfirmasiHapus(id_umkm) {
        var konfirmasi = confirm("Apakah Anda yakin ingin menghapus data UMKM ini?");
        if (konfirmasi) {
            window.location.href = "hapus_umkm.php?id=" + id_umkm;
        } else {
            return false;
        }
    }
</script>
<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>