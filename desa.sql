-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 21, 2025 at 10:56 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `desa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `password`, `nama`) VALUES
(2, 'a@gmail.com', 'a', 'ZAINULLAH');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id_banner` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `keterangan` text,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id_banner`, `gambar`, `judul`, `keterangan`, `id_admin`) VALUES
(15, 'uploads/10.jpg', 'Asal Usul Nama Larangan Slampar', ' Desa Larangan Slampar memiliki sejarah panjang yang terkait dengan tradisi dan budaya masyarakat Madura. Nama \"Larangan\" berasal dari kata larang, yang berarti tempat terlarang atau sakral pada masa lalu. Sedangkan \"Slampar\" konon merujuk pada wilayah yang luas dan terbuka. Seiring waktu, desa ini berkembang menjadi pusat kehidupan masyarakat dengan nilai-nilai kearifan lokal yang masih dijaga hingga kini.', 2),
(16, 'uploads/11.jpg', 'Peran Larangan Slampar dalam Sejarah Pamekasan', 'Desa Larangan Slampar memiliki peran penting dalam sejarah Pamekasan. Pada masa kolonial, desa ini menjadi salah satu tempat berkumpulnya tokoh-tokoh perjuangan melawan penjajah. Keberadaan tokoh agama dan ulama di desa ini juga turut andil dalam menyebarkan ajaran Islam dan membangun karakter masyarakat yang kuat dan berbudaya.', 2),
(17, 'uploads/12.jpg', 'Tradisi dan Kearifan Lokal Desa Larangan Slampar', 'Hingga kini, Desa Larangan Slampar masih mempertahankan berbagai tradisi turun-temurun. Mulai dari ritual adat, kesenian khas Madura, hingga sistem gotong royong dalam kehidupan sosial. Salah satu tradisi unik yang masih lestari adalah acara selamatan desa, yang bertujuan untuk menghormati leluhur serta memohon keselamatan dan keberkahan bagi seluruh masyarakat.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` date NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `detail_surat`
--

CREATE TABLE `detail_surat` (
  `id` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `agama` varchar(20) NOT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `keperluan` text NOT NULL,
  `status_pernikahan` enum('Belum Menikah','Menikah','Duda','Janda') DEFAULT NULL,
  `jenis_usaha` varchar(255) DEFAULT NULL,
  `status_tanah` varchar(255) DEFAULT NULL,
  `luas_tanah` decimal(10,2) DEFAULT NULL,
  `letak_tanah` text,
  `status_kepemilikan` enum('Pribadi','Warisan','Hak Guna','Sewa') DEFAULT NULL,
  `bukti_kepemilikan` varchar(255) DEFAULT NULL,
  `batas_utara` varchar(255) DEFAULT NULL,
  `batas_selatan` varchar(255) DEFAULT NULL,
  `batas_timur` varchar(255) DEFAULT NULL,
  `batas_barat` varchar(255) DEFAULT NULL,
  `file_pendukung` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detail_surat`
--

INSERT INTO `detail_surat` (`id`, `id_pengajuan`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `nik`, `alamat`, `agama`, `pekerjaan`, `keperluan`, `status_pernikahan`, `jenis_usaha`, `status_tanah`, `luas_tanah`, `letak_tanah`, `status_kepemilikan`, `bukti_kepemilikan`, `batas_utara`, `batas_selatan`, `batas_timur`, `batas_barat`, `file_pendukung`) VALUES
(1, 1, 'Zain Alapola', 'Pamekasan', '2025-04-18', '3528061303980007', 'ererereree', 'Islam', 'sd', 'as', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1744956024_kacang.jpg'),
(2, 2, 'Zain Alapola', 'Pamekasan', '2025-07-21', '3528061303980007', 'kadur', 'Islam', 'sd', 'er', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1753095054_sa.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `dusun`
--

CREATE TABLE `dusun` (
  `id_dusun` int(11) NOT NULL,
  `nama_dusun` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `galery`
--

CREATE TABLE `galery` (
  `id_galery` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `galery`
--

INSERT INTO `galery` (`id_galery`, `gambar`, `id_admin`) VALUES
(13, '10.jpg', 2),
(14, '11.jpg', 2),
(15, '12.jpg', 2),
(17, 'g2.jpeg', 2),
(18, 'g1.jpeg', 2),
(19, 'g3.jpeg', 2),
(20, 'g4.jpeg', 2),
(21, 'potensi.jpg', 2),
(22, 'berita3.jpeg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `nama_kegiatan` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subjeck` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('baru','dibaca') DEFAULT 'baru',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `misi`
--

CREATE TABLE `misi` (
  `id` int(11) NOT NULL,
  `isi` text NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `misi`
--

INSERT INTO `misi` (`id`, `isi`, `id_admin`) VALUES
(2, 'Meningkatkan Kesejahteraan Masyarakat', 2),
(3, 'Membangun Infrastruktur yang Berkualitas', 2),
(4, 'Meningkatkan Kualitas Pendidikan dan SDM', 2),
(5, 'Memajukan Sektor Pertanian dan Lingkungan Hidup', 2),
(6, 'Meningkatkan Tata Kelola Pemerintahan Desa yang Transparan dan Partisipatif', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_surat`
--

CREATE TABLE `pengajuan_surat` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `jenis_surat` enum('Domisili','Tidak Mampu','Usaha','Belum Menikah','Tanah') NOT NULL,
  `status` enum('Menunggu Verifikasi','Diproses','Siap Diambil','Ditolak') DEFAULT 'Menunggu Verifikasi',
  `alasan_penolakan` text,
  `tanggal_pengajuan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_selesai` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pengajuan_surat`
--

INSERT INTO `pengajuan_surat` (`id`, `id_pengguna`, `jenis_surat`, `status`, `alasan_penolakan`, `tanggal_pengajuan`, `tanggal_selesai`) VALUES
(1, 18, 'Domisili', 'Ditolak', 'asaas', '2025-04-18 06:00:24', NULL),
(2, 18, 'Domisili', 'Siap Diambil', NULL, '2025-07-21 10:50:54', '2025-07-21 17:52:01');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `tanggal` date DEFAULT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `potensi_desa`
--

CREATE TABLE `potensi_desa` (
  `id` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `keterangan` text,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `potensi_desa`
--

INSERT INTO `potensi_desa` (`id`, `gambar`, `keterangan`, `id_admin`) VALUES
(1, 'potensi.jpg', 'Desa Larangan Slampar terletak di ujung utara Kecamatan Tlanakan, Kabupaten Pamekasan, dengan luas wilayah sekitar 8,47 km², menjadikannya desa terluas di kecamatan tersebut. \r\n\r\nDesa ini terdiri dari 9 dusun, salah satunya adalah Dusun Karpote. ​Potensi sumber daya alam di Desa Larangan Slampar cukup melimpah, terutama dalam sektor pertanian. \r\n\r\nKomoditas utama yang dihasilkan meliputi singkong, cabai merah, kunyit, dan pisang. Singkong, misalnya, dapat diolah menjadi berbagai produk seperti keripik tette dan keripik singkong, sementara kunyit dapat diolah menjadi minuman tradisional seperti jamu atau sinom. \r\n\r\nSelain itu, usaha keripik pisang juga berkembang di desa ini. ​Dalam upaya meningkatkan perekonomian masyarakat, program pemberdayaan telah dilakukan, termasuk pelatihan pembuatan pupuk bokashi untuk mendukung sektor pertanian. \r\n\r\nDengan memanfaatkan sumber daya alam yang ada, Desa Larangan Slampar memiliki potensi besar untuk mengembangkan produk-produk unggulan yang dapat meningkatkan kesejahteraan masyarakat setempat.​', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sejarah`
--

CREATE TABLE `sejarah` (
  `id_sejarah` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sejarah`
--

INSERT INTO `sejarah` (`id_sejarah`, `gambar`, `keterangan`, `id_admin`) VALUES
(3, 'desa-sejarahh.jpg', 'Desa Larangan Slampar terletak di Kecamatan Tlanakan, Kabupaten Pamekasan, Jawa Timur, dengan luas wilayah sekitar 446,643 hektar dan terdiri atas 10 dusun. Desa ini berbatasan dengan Desa Terrak di sebelah barat dan Desa Bukek di sebelah timur. ​\r\n\r\nSecara administratif, Desa Larangan Slampar terdiri dari 10 dusun, yaitu:​ \r\n1. Dusun Gergunung Dejeh​\r\n2. Dusun Gergunung Laok​\r\n3. Dusun Karpote​\r\n4. Dusun Torbalangan​\r\n5. Desa Larangan Slampar\r\n6. Dusun Nyabangan​\r\n7. Dusun Lonsambi​\r\n8. Dusun Tengah​\r\n9. Dusun Larangan​\r\n10. Dusun Morlaok​\r\n\r\nSetiap dusun dipimpin oleh seorang kepala dusun yang dibantu oleh tokoh masyarakat dan tokoh agama dalam menjalankan tugas dan fungsinya. ​\r\nDesa Larangan Slampar\r\n\r\nPada tahun 2022, Desa Larangan Slampar kembali dipimpin oleh seorang perempuan bernama Hoyyibah, yang terpilih dalam pemilihan kepala desa serentak. Beliau berhasil mengalahkan tiga calon pria lainnya dan mendapatkan kepercayaan masyarakat untuk memimpin desa tersebut. ​\r\nBangsaonline.com\r\n\r\nMeskipun informasi spesifik mengenai sejarah awal terbentuknya Desa Larangan Slampar tidak tersedia dalam sumber yang ada, desa ini memiliki peran penting dalam struktur pemerintahan lokal di Pamekasan dan terus berkembang seiring waktu.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `struktur`
--

CREATE TABLE `struktur` (
  `id_struktur` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `umkm_desa`
--

CREATE TABLE `umkm_desa` (
  `id_umkm` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `umkm_desa`
--

INSERT INTO `umkm_desa` (`id_umkm`, `title`, `keterangan`, `id_admin`) VALUES
(9, 'UMKM di Larangan Slampar', 'Desa Larangan Slampar memiliki berbagai UMKM yang berkembang pesat, mulai dari industri makanan khas Madura, kerajinan tangan, hingga produk pertanian. Keberadaan UMKM ini menjadi tulang punggung ekonomi masyarakat, menciptakan lapangan kerja, serta memperkenalkan produk lokal ke pasar yang lebih luas.', 2),
(10, 'Produk Unggulan UMKM Larangan Slampar', 'Beberapa produk unggulan dari UMKM Desa Larangan Slampar antara lain kerajinan anyaman khas Madura, batik tulis bermotif tradisional, serta aneka kuliner seperti keripik singkong dan olahan ikan laut. Produk-produk ini tidak hanya diminati oleh masyarakat lokal tetapi juga mulai merambah pasar luar daerah.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `visi`
--

CREATE TABLE `visi` (
  `id` int(11) NOT NULL,
  `isi` text NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `visi`
--

INSERT INTO `visi` (`id`, `isi`, `id_admin`) VALUES
(2, '\"Mewujudkan Desa Larangan Slampar yang Mandiri, Berdaya Saing, dan Sejahtera Berbasis Kearifan Lokal serta Kemajuan Teknologi.\"', 2);

-- --------------------------------------------------------

--
-- Table structure for table `warga`
--

CREATE TABLE `warga` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `warga`
--

INSERT INTO `warga` (`id`, `nama`, `nik`, `tanggal_lahir`, `alamat`, `no_hp`, `email`, `password`) VALUES
(18, 'Zainullah x fauzan', '3528061303980007', '2025-04-05', 'Palengaan Daya, Palengaan\r\nPamekasan', '087882947999', 'a@gmail.com', 'g'),
(19, 'Fauzan', '3528061303980000', '2025-04-05', 'Palengaan Daya, Palengaan\r\nPamekasan', '087882947999', 'ddddd@gmail.com', 'd'),
(21, 'Riantonolos', '3528061303980009', '2025-07-21', 'slampar', '087882947999', 'rian@gmail.com', 'rian');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id_banner`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `detail_surat`
--
ALTER TABLE `detail_surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengajuan` (`id_pengajuan`);

--
-- Indexes for table `dusun`
--
ALTER TABLE `dusun`
  ADD PRIMARY KEY (`id_dusun`);

--
-- Indexes for table `galery`
--
ALTER TABLE `galery`
  ADD PRIMARY KEY (`id_galery`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `misi`
--
ALTER TABLE `misi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `potensi_desa`
--
ALTER TABLE `potensi_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `sejarah`
--
ALTER TABLE `sejarah`
  ADD PRIMARY KEY (`id_sejarah`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `struktur`
--
ALTER TABLE `struktur`
  ADD PRIMARY KEY (`id_struktur`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `umkm_desa`
--
ALTER TABLE `umkm_desa`
  ADD PRIMARY KEY (`id_umkm`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `visi`
--
ALTER TABLE `visi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id_banner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_surat`
--
ALTER TABLE `detail_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dusun`
--
ALTER TABLE `dusun`
  MODIFY `id_dusun` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galery`
--
ALTER TABLE `galery`
  MODIFY `id_galery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `misi`
--
ALTER TABLE `misi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `potensi_desa`
--
ALTER TABLE `potensi_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sejarah`
--
ALTER TABLE `sejarah`
  MODIFY `id_sejarah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `struktur`
--
ALTER TABLE `struktur`
  MODIFY `id_struktur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umkm_desa`
--
ALTER TABLE `umkm_desa`
  MODIFY `id_umkm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `visi`
--
ALTER TABLE `visi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `warga`
--
ALTER TABLE `warga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banner`
--
ALTER TABLE `banner`
  ADD CONSTRAINT `banner_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `detail_surat`
--
ALTER TABLE `detail_surat`
  ADD CONSTRAINT `detail_surat_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_surat` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `galery`
--
ALTER TABLE `galery`
  ADD CONSTRAINT `galery_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `misi`
--
ALTER TABLE `misi`
  ADD CONSTRAINT `misi_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD CONSTRAINT `pengajuan_surat_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `warga` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `potensi_desa`
--
ALTER TABLE `potensi_desa`
  ADD CONSTRAINT `potensi_desa_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `sejarah`
--
ALTER TABLE `sejarah`
  ADD CONSTRAINT `sejarah_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `struktur`
--
ALTER TABLE `struktur`
  ADD CONSTRAINT `struktur_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `umkm_desa`
--
ALTER TABLE `umkm_desa`
  ADD CONSTRAINT `umkm_desa_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `visi`
--
ALTER TABLE `visi`
  ADD CONSTRAINT `visi_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
