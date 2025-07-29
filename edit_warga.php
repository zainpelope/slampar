<?php
include('koneksi.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Pastikan ID adalah angka

// Ambil data warga berdasarkan ID
$sql = "SELECT * FROM warga WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan
if (!$data) {
    die("Data tidak ditemukan!");
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];

    // Update data ke database
    $sql = "UPDATE warga SET nama=?, nik=?, tanggal_lahir=?, alamat=?, no_hp=?, email=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $nama, $nik, $tanggal_lahir, $alamat, $no_hp, $email, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index_admin.php?page=warga");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit warga</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label>Nama:</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>" required>
            </div>
            <div class="mb-3">
                <label>NIK:</label>
                <input type="text" name="nik" class="form-control" value="<?= htmlspecialchars($data['nik']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="<?= $data['tanggal_lahir']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Alamat:</label>
                <textarea name="alamat" class="form-control" required><?= htmlspecialchars($data['alamat']); ?></textarea>
            </div>
            <div class="mb-3">
                <label>No HP:</label>
                <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($data['no_hp']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']); ?>">
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="index_admin.php?page=warga" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>