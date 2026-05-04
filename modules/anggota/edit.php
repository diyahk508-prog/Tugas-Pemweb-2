<?php
require '../../config/database.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM anggota WHERE id_anggota=$id")->fetch_assoc();

if ($_SERVER['POST']) {

$nama = $_POST['nama'];
$email = $_POST['email'];

$conn->query("UPDATE anggota SET nama='$nama', email='$email' WHERE id_anggota=$id");

header("Location: index.php");
}
?>

<form method="POST">
<input name="nama" value="<?= $data['nama'] ?>"><br>
<input name="email" value="<?= $data['email'] ?>"><br>
<button>Update</button>
</form>