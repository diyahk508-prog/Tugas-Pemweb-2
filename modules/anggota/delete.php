<?php
require '../../config/database.php';

$id = $_GET['id'];

$data = $conn->query("SELECT foto FROM anggota WHERE id_anggota=$id")->fetch_assoc();

if ($data['foto'] && file_exists("uploads/".$data['foto'])) {
unlink("uploads/".$data['foto']);
}

$conn->query("DELETE FROM anggota WHERE id_anggota=$id");

header("Location: index.php");