<?php
include '../koneksi.php';

$conn->query("UPDATE kontak SET status = 'dibaca' WHERE status = 'baru'");

$sql = "SELECT * FROM kontak ORDER BY id_kontak DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kotak Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .delete-btn {
            color: #fff;
            background-color: #dc3545;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .back-btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .close {
            font-size: 1.5rem;
            color: #fff;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .close:hover {
            color: #c82333;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>

<body>

    <div class="container my-5">


        <?php if ($result->num_rows > 0): ?>
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Pesan Masuk</h4>
                    <button class="close" onclick="window.location.href='../index_admin.php?page=masuk'">&times;</button>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Subjek</th>
                                    <th>Pesan</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['subjeck']); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                                        <td><?php echo date("d-m-Y H:i:s", strtotime($row['created_at'])); ?></td>
                                        <td>
                                            <form action="../admin/delete_kontak.php" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                                <input type="hidden" name="id_kontak" value="<?php echo $row['id_kontak']; ?>">
                                                <button type="submit" class="delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus pesan ini">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">Belum ada pesan masuk.</div>
        <?php endif; ?>
        <br>
        <div class="justify-content-center align-items-center">
            <a href="../index_admin.php?admin=home_admin" class="btn btn-primary btn-lg w-100">Kembali</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-wEmeIV1mKuiNp12sAOF3m27B2QF2xnQL3cbsX7PsGh1S5n0XTsg1BWp3BO5uwsIl" crossorigin="anonymous"></script>
    <script>
        // Enable tooltips
        var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>

<?php
$conn->close();
?>