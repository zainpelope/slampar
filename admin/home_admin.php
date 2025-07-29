<?php
include 'koneksi.php';
$sql_galery = "SELECT * FROM galery";
$result_galery = $conn->query($sql_galery);
$sql_potensi = "SELECT * FROM potensi_desa";
$result_potensi = $conn->query($sql_potensi);

$sql_banner = "SELECT * FROM banner";
$result_banner = $conn->query($sql_banner); ?>



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
    background-color: rgba(22, 21, 21, 0.5);
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
                  <a href="edit_banner.php?id=<?php echo $row_banner['id_banner']; ?>" style="color: yellow;">Edit</a>
                  <span style="color: white;">&nbsp;|&nbsp;</span>
                  <a href="#" onclick="return confirm('Apakah Anda yakin ingin menghapus banner ini?') ? window.location.href = 'hapus_banner.php?id=<?php echo $row_banner['id_banner']; ?>' : false;" style="color: red; text-decoration: none;">Hapus</a>
                </div>
                <a href="tambah_banner.php" class="btn-get-started animate__animated animate__fadeInUp scrollto">Add More</a>
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
                  echo "<div class='col-lg-7'>";
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