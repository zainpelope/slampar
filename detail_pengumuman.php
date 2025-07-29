<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM pengumuman WHERE id_pengumuman = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
?>

        <!DOCTYPE html>
        <html>

        <head>
            <title>Detail Pengumuman</title>
            <style>
                body {
                    font-family: sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }

                .container {
                    background-color: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    width: 500px;
                }

                h1 {
                    color: #333;
                }

                .tanggal {
                    color: #777;
                    margin-bottom: 10px;
                    display: flex;
                    align-items: center;
                    font-style: italic;
                    font-size: 0.9em;
                }

                .tanggal-angka {
                    font-size: 1.2em;
                    margin-right: 5px;
                }

                .tanggal em {
                    font-style: italic;
                    margin-right: 5px;
                }

                .keterangan {
                    margin-bottom: 20px;
                }

                .tombol-kembali-container {
                    text-align: center;
                }

                .kembali {
                    display: block;
                    width: 100%;
                    padding: 10px 15px;
                    background-color: #f44336;
                    color: white;
                    text-decoration: none;
                    border-radius: 4px;
                    box-sizing: border-box;
                }

                .kembali:hover {
                    background-color: #da190b;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h1><?php echo $row['judul']; ?></h1>
                <p class="tanggal">Tanggal :
                    <span class="tanggal-angka"> <?php echo date('d', strtotime($row['tanggal'])); ?> </span>
                    <em> <?php echo strftime('%B', strtotime($row['tanggal'])); ?> </em>
                    <?php echo date('Y', strtotime($row['tanggal'])); ?>
                </p>
                <p class="keterangan"><?php echo $row['keterangan']; ?></p>
                <div class="tombol-kembali-container">
                    <a class="kembali" href="index_admin.php?page=pengumuman">Kembali</a>
                </div>
            </div>
        </body>

        </html>

<?php
    } else {
        echo "Pengumuman tidak ditemukan.";
    }
}
$conn->close();
?>