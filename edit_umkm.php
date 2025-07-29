<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_umkm = $_GET['id'];

    $sql = "SELECT * FROM umkm_desa WHERE id_umkm = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_umkm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $keterangan = $row['keterangan'];
    } else {
        echo "Data UMKM tidak ditemukan.";
        exit;
    }

    $stmt->close();
} else {
    echo "id_umkm tidak valid.";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $keterangan = $_POST['keterangan'];


    if (empty($title)) {
        echo "Judul tidak boleh kosong.";
    } elseif (empty($keterangan)) {
        echo "Keterangan tidak boleh kosong.";
    } else {

        $sql = "UPDATE umkm_desa SET title = ?, keterangan = ? WHERE id_umkm = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $keterangan, $id_umkm);

        if ($stmt->execute()) {
            header("Location: index_admin.php?admin=home_admin");
            exit;
        } else {
            error_log("Error saat mengupdate data UMKM: " . $stmt->error);
            echo "Terjadi kesalahan saat mengupdate data. Silakan coba lagi nanti.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Data UMKM</title>
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
        <h1>Edit Data UMKM</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id_umkm; ?>">
            <label for="title">Judul:</label>
            <input type="text" name="title" id="title" value="<?php echo $title; ?>" required><br>

            <label for="keterangan">Keterangan:</label>
            <textarea name="keterangan" id="keterangan" required><?php echo $keterangan; ?></textarea><br>

            <input type="submit" value="Simpan">
        </form>
        <a href="index_admin.php?admin=home_admin" class="kembali">Kembali</a>
    </div>
</body>

</html>