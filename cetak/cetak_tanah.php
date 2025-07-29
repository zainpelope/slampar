<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../koneksi.php');

if (isset($_GET['id'])) {
    $id_pengajuan = $_GET['id'];

    $stmt = $conn->prepare("SELECT ds.*, ps.jenis_surat FROM detail_surat ds
                            JOIN pengajuan_surat ps ON ds.id_pengajuan = ps.id
                            WHERE ds.id_pengajuan = ?");
    $stmt->bind_param("i", $id_pengajuan);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
?>
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Surat Keterangan Tanah</title>
            <style>
                @page {
                    size: A4;
                    /* Keep A4 size */
                    margin: 2cm;
                    /* Uniform margin around the page */
                }

                body {
                    font-family: 'Times New Roman', Times, serif;
                    margin: 0;
                    padding: 0;
                    /* Reset body padding, as @page margin handles it */
                }

                .container {
                    padding: 1.5cm 0;
                    /* Add internal padding for content within the page margins */
                }

                .header {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                    position: relative;
                    margin-bottom: 20px;
                    /* Space below the header */
                }

                .logo {
                    width: 100px;
                    height: 100px;
                    position: absolute;
                    left: 0;
                    /* Align logo to the very left of the header area */
                    top: 50%;
                    transform: translateY(-50%);
                }

                .header-text {
                    flex-grow: 1;
                    text-align: center;
                    margin-left: 90px;
                    /* Adjust to make space for the logo */
                    margin-right: 50px;
                    /* Balance the text in the center */
                }

                h3,
                h4,
                p {
                    margin: 2px 0;
                }

                hr {
                    border: 1px solid black;
                    margin-top: 10px;
                    margin-bottom: 20px;
                    /* Space below the horizontal rule */
                }

                .isi {
                    margin-top: 20px;
                    font-size: 16px;
                    text-align: justify;
                    line-height: 1.6;
                    /* Improve readability */
                }

                .isi p {
                    margin-bottom: 10px;
                    /* Add some space between paragraphs */
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                    margin-bottom: 20px;
                    /* Space below the table */
                }

                table tr td {
                    padding: 4px 0;
                    /* Padding for table cells */
                    vertical-align: top;
                }

                table tr td:first-child {
                    width: 30%;
                    /* Adjust width for labels */
                }

                .ttd-content {
                    margin-top: 50px;
                    /* Space above the signature block */
                    text-align: left;
                    float: right;
                    width: 40%;
                    /* Control the width of the signature block */
                }

                .ttd-content p {
                    margin: 5px 0;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <div class="header">
                    <img src="../pmk.png" alt="Logo Desa" class="logo">
                    <div class="header-text">
                        <h3>PEMERINTAH KABUPATEN PAMEKASAN</h3>
                        <h4>KECAMATAN TLANAKAN</h4>
                        <h4>KEPALA DESA LARANGAN SLAMPAR</h4>
                        <p>Alamat : Jl. Raya Larangan Slampar, Pamekasan - Telp: 081703709509</p>
                    </div>
                </div>
                <hr>
                <h3 style="text-align: center; text-decoration: underline; margin-bottom: 10px;">SURAT KETERANGAN TANAH</h3>
                <p style="text-align: center; margin-bottom: 30px;">Nomor: 941/84/721.401.10/<?= date('Y'); ?></p>

                <div class="isi">
                    <p>Yang bertanda tangan di bawah ini Kepala Desa Larangan Slampar Kecamatan Tlanakan Kabupaten Pamekasan, menerangkan dengan sebenar-benarnya bahwa:</p>
                    <br>
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>: <?= $data['nama_lengkap']; ?></td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>: <?= $data['nik']; ?></td>
                        </tr>
                        <tr>
                            <td>Tempat, Tanggal Lahir</td>
                            <td>: <?= $data['tempat_lahir']; ?>, <?= date('d-m-Y', strtotime($data['tanggal_lahir'])); ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>: <?= $data['agama']; ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>: <?= $data['pekerjaan']; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: <?= $data['alamat']; ?></td>
                        </tr>

                    </table>
                    <br>
                    <p>Benar yang bersangkutan memiliki sebidang tanah dengan keterangan sebagai berikut:</p>
                    <br>
                    <table>
                        <tr>
                            <td>Status Tanah</td>
                            <td>: <?= $data['status_tanah']; ?></td>
                        </tr>
                        <tr>
                            <td>Luas Tanah</td>
                            <td>: <?= $data['luas_tanah']; ?></td>
                        </tr>
                        <tr>
                            <td>Lokasi Tanah</td>
                            <td>: <?= $data['letak_tanah']; ?></td>
                        </tr>
                        <tr>
                            <td>Status Kepemilikan Tanah</td>
                            <td>: <?= $data['status_kepemilikan']; ?></td>
                        </tr>
                        <tr>
                            <td>Batas Utara</td>
                            <td>: <?= $data['batas_utara']; ?></td>
                        </tr>
                        <tr>
                            <td>Batas Selatan</td>
                            <td>: <?= $data['batas_selatan']; ?></td>
                        </tr>
                        <tr>
                            <td>Batas Timur</td>
                            <td>: <?= $data['batas_timur']; ?></td>
                        </tr>
                        <tr>
                            <td>Batas Barat</td>
                            <td>: <?= $data['batas_barat']; ?></td>
                        </tr>
                    </table>
                    <br>
                    <p>Surat keterangan ini dibuat untuk keperluan : <?= $data['keperluan']; ?></p>
                    <br>
                    <p>Demikian surat keterangan ini dibuat dengan sebenarnya dan untuk dapat dipergunakan sebagaimana mestinya.</p>
                </div>

                <div class="ttd-content">
                    <p>Pamekasan, <?= date('d-m-Y'); ?></p>
                    <p>Kepala Desa Larangan Slampar</p>
                    <div style="text-align: justify; margin-top: 73px;">
                        <p><b>HOYYIBAH</b></p>
                    </div>
                </div>
            </div>

            <script>
                window.print();
            </script>
        </body>

        </html>
<?php
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "ID pengajuan tidak valid.";
}
?>