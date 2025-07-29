<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_berita = $_GET['id'];

    $sql = "SELECT * FROM berita WHERE id_berita = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_berita);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}
?>

<main class="main">
    <div class="container my-5">
        <section id="detail-berita" class="section">


            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card shadow-lg rounded border-0">

                        <img src="../uploads/<?= htmlspecialchars($row['gambar']) ?>" class="img-fluid rounded-top" alt="News Image">

                        <div class="card-body">
                            <h2 class="display-4 font-weight-bold mb-3"><?= htmlspecialchars($row['judul']) ?></h2>
                            <p class="text-muted mb-4"><?= htmlspecialchars($row['tanggal']) ?></p>
                            <p class="card-text"><?= nl2br(htmlspecialchars($row['keterangan'])) ?></p>
                        </div>
                        <div class="card-body">
                            <a href="../index.php?page=berita" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

            </div>


        </section>
    </div>
</main>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">