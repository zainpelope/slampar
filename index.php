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
    <style>
        .section-title {
            margin-bottom: 30px;
        }

        .section-title h2 {
            font-size: 32px;
            font-weight: bold;
        }

        .vision-mission {
            margin-top: 40px;
        }

        .vision-mission h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .profile-image {
            max-width: 100%;
            height: auto;
        }

        .profile-container {
            display: flex;
            gap: 20px;
        }

        .profile-container img {
            width: 100%;
            height: auto;
        }

        .timeline {
            list-style: none;
            padding-left: 0;
        }

        .timeline li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 25px;
        }

        .timeline li::before {
            content: '\2713';
            /* Checkmark */
            position: absolute;
            left: 0;
            top: 0;
            font-size: 1.2rem;
            color: blue;
        }

        #struktur-desa .section-title {
            margin-bottom: 30px;
        }

        #struktur-desa img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>

<body class="index-page">
    <main class="main">
        <!-- Navbar -->
        <?php include('header.php'); ?>

        <div class="content">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                $allowed_pages = ['home', 'sejarah', 'kegiatan', 'pengumuman', 'struktur-desa', 'visi-misi', 'kontak', 'berita', 'warga'];
                if (in_array($page, $allowed_pages)) {
                    include 'pages/' . $page . '.php';
                } else {
                    include 'pages/home.php';
                }
            } else {
                include 'pages/home.php';
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