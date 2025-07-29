<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM banner WHERE id_banner=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_admin.php?admin=home_admin");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID banner tidak valid.";
    exit();
}
