<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    die("Anda harus login sebagai admin untuk mengakses halaman ini.");
}

$id_admin = $_SESSION['id_admin'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $keterangan = $_POST['keterangan'];

    $sql = "INSERT INTO umkm_desa (title, keterangan, id_admin) VALUES ('$title', '$keterangan', '$id_admin')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_admin.php?admin=home_admin");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Tambah Data UMKM</title>
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
            width: 400px;
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
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .tombol {

            display: block;

            width: 100%;

        }

        input[type="submit"],
        .kembali {
            display: block;

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

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .kembali {
            background-color: #007bff;
            color: white;
        }

        .kembali:hover {
            background-color: #0069d9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tambah Data UMKM</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="title">Judul:</label>
            <input type="text" name="title" id="title" required><br>

            <label for="keterangan">Keterangan:</label>
            <textarea name="keterangan" id="keterangan" required></textarea><br>

            <div class="tombol">
                <input type="submit" value="Simpan">
                <a href="index_admin.php?admin=home_admin" class="kembali">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>