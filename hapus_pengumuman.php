<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM pengumuman WHERE id_pengumuman = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index_admin.php?page=pengumuman");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
$conn->close();
?>