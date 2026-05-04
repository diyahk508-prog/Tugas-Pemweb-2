<?php
require '../../config/database.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM anggota WHERE id_anggota=$id")->fetch_assoc();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$nama = $_POST['nama'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$tanggal_lahir = $_POST['tanggal_lahir'];

// VALIDASI
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors[] = "Email tidak valid";
}

if(!preg_match('/^08[0-9]{8,11}$/', $telepon)){
    $errors[] = "Format telepon harus 08xxxxxxxxxx";
}

$umur = date('Y') - date('Y', strtotime($tanggal_lahir));
if($umur < 10){
    $errors[] = "Umur minimal 10 tahun";
}

// FOTO
$foto = $data['foto'];

if(!empty($_FILES['foto']['name'])){
    $foto = time().'_'.$_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/".$foto);
}

if(empty($errors)){
$conn->query("UPDATE anggota SET 
nama='$nama',
email='$email',
telepon='$telepon',
tanggal_lahir='$tanggal_lahir',
foto='$foto'
WHERE id_anggota=$id");

header("Location: index.php");
exit;
}
}
?>

<form method="POST" enctype="multipart/form-data">
<input name="nama" value="<?= $data['nama'] ?>"><br>
<input name="email" value="<?= $data['email'] ?>"><br>
<input name="telepon" value="<?= $data['telepon'] ?>"><br>
<input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>"><br>

<input type="file" name="foto"><br>

<button>Update</button>
</form>
