<?php
include 'koneksi.php';

$per_page_galeri = 8;
$halaman_galeri = isset($_GET['halaman_galeri']) && is_numeric($_GET['halaman_galeri']) ? $_GET['halaman_galeri'] : 1;
if ($halaman_galeri < 1) {
  $halaman_galeri = 1;
}
$start_from_galeri = ($halaman_galeri - 1) * $per_page_galeri;

$sql_count_galeri = "SELECT COUNT(*) AS total FROM galery";
$result_count_galeri = $conn->query($sql_count_galeri);
$total_records_galeri = $result_count_galeri->fetch_assoc()['total'];
$total_pages_galeri = ceil($total_records_galeri / $per_page_galeri);

$sql_galery = "SELECT * FROM galery LIMIT $start_from_galeri, $per_page_galeri";
$result_galery = $conn->query($sql_galery);

$sql_potensi = "SELECT * FROM potensi_desa";
$result_potensi = $conn->query($sql_potensi);

$sql_banner = "SELECT * FROM banner";
$result_banner = $conn->query($sql_banner);
?>



<style>
  .hero {
    width: 100%;
    height: 100vh;
    position: relative;
    overflow: hidden;
  }

  .carousel-item {
    height: 100vh;
    background-size: cover;
    background-position: center;
  }

  .carousel-inner {
    height: 100%;
  }

  .carousel-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: rgba(27, 25, 25, 0.5);
    color: white;
    text-align: center;
  }

  .edit-delete-buttons {
    display: flex;
    justify-content: center;
    margin-top: 10px;
  }

  .edit-delete-buttons button {
    margin: 0 5px;
  }
</style>


<main class="main">
  <section id="hero" class="hero section dark-background">
    <div id="hero-carousel" class="carousel carousel-fade" data-bs-ride="carousel">
      <div class="carousel-inner">

        <?php
        $active = true;
        if ($result_banner->num_rows > 0) {
          while ($row_banner = $result_banner->fetch_assoc()) {
        ?>
            <div class="carousel-item <?php if ($active) {
                                        echo 'active';
                                        $active = false;
                                      } ?>" style="background-image: url('<?php echo $row_banner['gambar']; ?>');">
              <div class="carousel-container">
                <h2 class="animate__animated animate__fadeInDown"><?php echo $row_banner['judul']; ?></h2>

                <p class="animate__animated animate__fadeInUp"><?php echo $row_banner['keterangan']; ?></p>
                <div class="edit-delete-buttons">
                </div>
                <a href="#" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
              </div>
            </div>
          <?php
          }
        } else {
          ?>
          <a href="tambah_banner.php" style="display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0;">
            <button style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
              Add More
            </button>
          </a>
        <?php
        }
        ?>
      </div>

      <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>
      <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>
    </div>

  </section>
  <section id="features-2" class="features section features-2">
    <div class="container section-title" data-aos="fade-up">

      <h2>Potensi Desa</h2>

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
                  echo "<div class='col-lg-7'>";
                  echo "<i class='bi bi-store flex-shrink-0'></i>";
                  echo "<div class='info-umkm flex-grow-1'>";
                  echo "<h4>" . $row["title"] . "</h4>";
                  echo "<p>" . $row["keterangan"] . "</p>";
                  echo "</div>";
                  echo "<div class='action-buttons ml-auto'>";

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
  <section id="gallery" class="gallery section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Gallery</h2>
      <p>Desa Larangan Slampar memiliki galeri visual yang menampilkan keindahan alam, kegiatan masyarakat, serta produk lokal unggulan melalui kumpulan gambar yang dapat menggambarkan identitas dan potensi desa secara visual.</p>
    </div>
    <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
      <div class="row g-0">
        <?php while ($row = $result_galery->fetch_assoc()) : ?>
          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="uploads/<?= $row['gambar'] ?>" class="glightbox" data-gallery="images-gallery">
                <img src="uploads/<?= $row['gambar'] ?>" class="img-fluid">
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>

    <nav aria-label="Page navigation example" class="mt-4">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php if ($halaman_galeri <= 1) {
                                echo 'disabled';
                              } ?>">
          <a class="page-link" href="<?php if ($halaman_galeri > 1) {
                                        echo '?page=home&halaman_galeri=' . ($halaman_galeri - 1);
                                      } ?>">Previous</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages_galeri; $i++) : ?>
          <li class="page-item <?php if ($i == $halaman_galeri) {
                                  echo 'active';
                                } ?>">
            <a class="page-link" href="?page=home&halaman_galeri=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?php if ($halaman_galeri >= $total_pages_galeri) {
                                echo 'disabled';
                              } ?>">
          <a class="page-link" href="<?php if ($halaman_galeri < $total_pages_galeri) {
                                        echo '?page=home&halaman_galeri=' . ($halaman_galeri + 1);
                                      } ?>">Next</a>
        </li>
      </ul>
    </nav>
  </section>

</main>
<script>
  function konfirmasiHapus(id_banner) {
    var konfirmasi = confirm("Apakah Anda yakin ingin menghapus banner ini?");
    if (konfirmasi) {
      window.location.href = "hapus_banner.php?id=" + id_banner;
    }
  }
</script>
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