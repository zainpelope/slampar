<?php
include('../koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT isi FROM visi WHERE id = '$id'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $visi = $row['isi'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $visi_baru = $_POST['visi'];
    $query = "UPDATE visi SET isi = '$visi_baru' WHERE id = '$id'";
    if ($conn->query($query)) {
        echo "<script>alert('Visi berhasil diupdate!'); window.location.href='../index_admin.php?page=visi-misi';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate visi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Visi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h3 class="text-center mb-4">Edit Visi</h3>
        
        <div class="card p-4 shadow-sm">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="visi" class="form-label">Visi:</label>
                    <textarea id="visi" name="visi" class="form-control" rows="5" required><?php echo $visi; ?></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="../index_admin.php?page=visi-misi" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb+4gTxonb3c4K57v5Q9zKM3GO9rHInJi6+Ji6elGpo4L88gQ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-kenU1KFdBIe4zZZe4D2rP6pPToU2Jl5j6gDsxmnfEX7FQy5Yc7t7TjmjOkI0y9H5" crossorigin="anonymous"></script>
</body>
</html>