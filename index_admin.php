<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Desa Larangan Slampar</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Style CSS File -->
    <link href="assets/css/lagi.css" rel="stylesheet">

</head>

<body class="index-page">
    <main class="main">
        <!-- Navbar -->
        <?php include('header_admin.php'); ?>

        <div class="content">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                $allowed_admin = ['home_admin', 'visi-misi', 'kegiatan', 'pengumuman', 'sejarah', 'galery', 'struktur', 'berita', 'masuk_masuk', 'layanan_publik', 'warga'];
                if (in_array($page, $allowed_admin)) {
                    include 'admin/' . $page . '.php';
                } else {
                    include 'admin/home_admin.php';
                }
            } else {
                include 'admin/home_admin.php';
            }



            ?>
        </div>
    </main>


    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>