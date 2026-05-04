<?php
require_once '../../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$kode = $_POST['kode'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$alamat = $_POST['alamat'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$jk = $_POST['jk'];
$pekerjaan = $_POST['pekerjaan'];

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

$foto = '';
if(!empty($_FILES['foto']['name'])){
    $foto = time().'_'.$_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/".$foto);
}

if(empty($foto)){
    $fotos = ['sehun.jpg','suho.jpg','kai.jpg','irene.jpg','seulgi.jpg'];
    $foto = $fotos[array_rand($fotos)];
}

if(empty($errors)){
$conn->query("INSERT INTO anggota 
(kode_anggota,nama,email,telepon,alamat,tanggal_lahir,jenis_kelamin,pekerjaan,tanggal_daftar,status,foto) 
VALUES 
('$kode','$nama','$email','$telepon','$alamat','$tanggal_lahir','$jk','$pekerjaan',CURDATE(),'Aktif','$foto')");

header("Location: index.php");
exit;
}
}
?>

<form method="POST" enctype="multipart/form-data">
<input name="kode" placeholder="Kode"><br>
<input name="nama" placeholder="Nama"><br>
<input name="email" placeholder="Email"><br>
<input name="telepon" placeholder="Telepon"><br>
<input name="alamat" placeholder="Alamat"><br>
<input type="date" name="tanggal_lahir"><br>

<input type="file" name="foto"><br>

<select name="jk">
<option value="Laki-laki">Laki-laki</option>
<option value="Perempuan">Perempuan</option>
</select><br>

<input name="pekerjaan" placeholder="Pekerjaan"><br>

<button>Tambah</button>
</form>
