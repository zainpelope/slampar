<?php
include 'koneksi.php';


$sql = "SELECT COUNT(*) AS jumlah_baru FROM kontak WHERE status = 'baru'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
$jumlah_baru = $data['jumlah_baru'];
?>
<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
        <a href="index_admin.php" class="logo d-flex align-items-center">
            <img src="logo.png" alt="">
            <h1 class="sitename">Larangan Slampar</h1>
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index_admin.php?admin=home_admin" class="active">Home</a></li>
                <li class="dropdown"><a href=""><span>Profile Desa</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="index_admin.php?page=sejarah">Sejarah</a></li>
                        <li><a href="index_admin.php?page=visi-misi">Visi-Misi</a></li>
                        <li><a href="index_admin.php?page=struktur">Struktur Desa</a></li>
                        <li><a href="index_admin.php?page=galery">Galery</a></li>

                    </ul>
                </li>
                <li class="dropdown"><a href=""><span>Informasi Desa</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="index_admin.php?page=warga">Warga</a></li>
                        <li><a href="index_admin.php?page=berita">Berita</a></li>
                        <li><a href="index_admin.php?page=kegiatan">Kegiatan</a></li>
                        <li><a href="index_admin.php?page=pengumuman">Pengumuman</a></li>
                    </ul>
                </li>

                <li><a href="index_admin.php?page=layanan_publik">Layanan Publik</a></li>


                <li>
                    <a href="admin/kotak_masuk.php">
                        Kotak Masuk
                        <?php if ($jumlah_baru > 0): ?>
                            <span class="badge bg-danger"><?php echo $jumlah_baru; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li><a href="admin/profile_admin.php">Profile</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>