<?php
include 'koneksi.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subjeck = htmlspecialchars($_POST['subjeck']);
    $message = htmlspecialchars($_POST['message']);
    $status = 'baru'; // Default status

    // Menggunakan prepared statement untuk keamanan
    $sql = "INSERT INTO kontak (name, email, subjeck, message, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $subjeck, $message, $status);

    if ($stmt->execute()) {
        $successMessage = "Pesan Anda terkirim!";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            });
        </script>";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<main class="main">
    <div class="page-title dark-background"></div>

    <div class="container my-5" data-aos="fade-up" data-aos-delay="200">
        <section id="contact" class="contact section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak</h2>
                <p>Jika Anda memiliki saran, kritik, atau masukan terkait Desa Larangan Slampar, silakan sampaikan melalui kontak resmi desa. Masukan Anda sangat berarti untuk mendukung pengembangan dan kemajuan desa secara bersama-sama.</p>
            </div>

            <div class="container" data-aos="fade" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-4">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Alamat</h3>
                                <p>Desa Larangan Slampar, Kecamatan Tlanakan, Kabupaten Pamekasan.</p>
                            </div>
                        </div>

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Nomor Telepon</h3>
                                <p>+62 878-4006-0990</p>
                            </div>
                        </div>

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email</h3>
                                <p>larangan_slampar@gmail.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <form id="contactForm" action="" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="subjeck" class="form-label">Subjek</label>
                                <input type="text" class="form-control" id="subjeck" name="subjeck" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submitButton">
                                <span id="buttonText">Kirim Pesan</span>
                                <span id="buttonSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<!-- MODAL UNTUK SUKSES -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">Berhasil!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Pesan Anda telah Terkirim. Terima kasih!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.href='index.php?page=kontak'">Tutup</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const submitButton = document.getElementById('submitButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');

        submitButton.disabled = true;
        buttonText.style.display = 'none';
        buttonSpinner.classList.remove('d-none');

        setTimeout(() => {
            this.submit();
        }, 1500);
    });
</script>

<?php include('footer.html'); ?>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader"></div>