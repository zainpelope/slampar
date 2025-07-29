<?php
include('../../koneksi.php');

$id_sejarah = $_GET['id']; 
$query = "DELETE FROM sejarah WHERE id_sejarah = $id_sejarah";

if ($conn->query($query)) {
    header("Location: ../../index_admin.php?page=sejarah");
} else {
    echo "Terjadi kesalahan: " . $conn->error;
}
?>
