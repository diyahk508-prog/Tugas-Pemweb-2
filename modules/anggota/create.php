<?php
require_once '../../config/database.php';

if ($_SERVER['POST']) {

$kode = $_POST['kode'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$alamat = $_POST['alamat'];
$tgl = $_POST['tanggal_lahir'];
$jk = $_POST['jk'];
$pekerjaan = $_POST['pekerjaan'];

$fotos = ['sehun.jpg','suho.jpg','kai.jpg','irene.jpg','seulgi.jpg'];
$foto = $fotos[array_rand($fotos)];

$conn->query("INSERT INTO anggota 
(kode_anggota,nama,email,telepon,alamat,tanggal_lahir,jenis_kelamin,pekerjaan,tanggal_daftar,status,foto) 
VALUES 
('$kode','$nama','$email','$telepon','$alamat','$tgl','$jk','$pekerjaan',CURDATE(),'Aktif','$foto')");

header("Location: index.php");
}
?>

<form method="POST">
<input name="kode" placeholder="Kode"><br>
<input name="nama" placeholder="Nama"><br>
<input name="email" placeholder="Email"><br>
<input name="telepon" placeholder="Telepon"><br>
<input name="alamat" placeholder="Alamat"><br>
<input type="date" name="tanggal_lahir"><br>

<select name="jk">
<option>Laki-laki</option>
<option>Perempuan</option>
</select><br>

<input name="pekerjaan" placeholder="Pekerjaan"><br>

<button>Tambah</button>
</form>