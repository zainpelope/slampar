<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM pengumuman WHERE id_pengumuman = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if (isset($_POST['submit'])) {
            $judul = $_POST['judul'];
            $keterangan = $_POST['keterangan'];
            $tanggal = $_POST['tanggal'];

            $sql_update = "UPDATE pengumuman SET judul = '$judul', keterangan = '$keterangan', tanggal = '$tanggal' WHERE id_pengumuman = $id";

            if ($conn->query($sql_update) === TRUE) {
                header("Location: index_admin.php?page=pengumuman");
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Pengumuman</title>
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
                    text-align: center;
                    color: #333;
                }

                label {
                    display: block;
                    margin-bottom: 5px;
                    color: #555;
                }

                input[type="text"],
                textarea,
                input[type="date"] {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 15px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                }

                .button-container {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    margin-top: 15px;
                }

                .button-container input[type="submit"],
                .button-container a {
                    width: 100%;
                    padding: 10px 15px;
                    margin-bottom: 10px;
                    border: none;
                    border-radius: 4px;
                    text-align: center;
                    text-decoration: none;
                    cursor: pointer;
                    box-sizing: border-box;
                }

                .button-container input[type="submit"] {
                    background-color: #4CAF50;
                    color: white;
                }

                .button-container input[type="submit"]:hover {
                    background-color: #45a049;
                }

                .button-container a {
                    background-color: #f44336;
                    color: white;
                }

                .button-container a:hover {
                    background-color: #da190b;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Edit Pengumuman</h1>
                <form method="post">
                    <label for="judul">Judul:</label>
                    <input type="text" id="judul" name="judul" value="<?php echo $row['judul']; ?>" required>

                    <label for="keterangan">Keterangan:</label>
                    <textarea id="keterangan" name="keterangan" rows="4" required><?php echo $row['keterangan']; ?></textarea>

                    <label for="tanggal">Tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>" required>

                    <div class="button-container">
                        <input type="submit" name="submit" value="Simpan Perubahan">
                        <a href="index_admin.php?page=pengumuman">Kembali</a>
                    </div>
                </form>
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