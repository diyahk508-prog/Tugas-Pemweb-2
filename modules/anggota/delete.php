<?php
session_start();
require '../../config/database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['error'] = "ID tidak valid!";
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT foto, nama FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    $_SESSION['error'] = "Data tidak ditemukan!";
    header("Location: index.php");
    exit;
}

if (isset($_POST['confirm'])) {


    if (!empty($data['foto'])) {
        $filePath = "uploads/" . $data['foto'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }


    $stmt = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['success'] = "Anggota berhasil dihapus!";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Hapus</title>
</head>
<body>

<h2>Konfirmasi Hapus</h2>

<p>Yakin ingin menghapus anggota berikut?</p>

<ul>
    <li><b>Nama:</b> <?= htmlspecialchars($data['nama']) ?></li>
</ul>

<form method="POST">
    <button type="submit" name="confirm" style="color:white; background:red; padding:10px;">
        Ya, Hapus
    </button>

    <a href="index.php" style="margin-left:10px;">
        Batal
    </a>
</form>

</body>
</html>
