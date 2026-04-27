<?php
// DATA BUKU (10+)
$buku_list = [
    ["kode"=>"B01","judul"=>"Laskar Pelangi","kategori"=>"Novel","pengarang"=>"Andrea Hirata","penerbit"=>"Bentang","tahun"=>2005,"harga"=>80000,"stok"=>5],
    ["kode"=>"B02","judul"=>"Bumi","kategori"=>"Novel","pengarang"=>"Tere Liye","penerbit"=>"Gramedia","tahun"=>2014,"harga"=>90000,"stok"=>0],
    ["kode"=>"B03","judul"=>"Matematika Dasar","kategori"=>"Pendidikan","pengarang"=>"Budi","penerbit"=>"Erlangga","tahun"=>2018,"harga"=>75000,"stok"=>10],
    ["kode"=>"B04","judul"=>"Fisika Modern","kategori"=>"Pendidikan","pengarang"=>"Andi","penerbit"=>"Erlangga","tahun"=>2020,"harga"=>85000,"stok"=>3],
    ["kode"=>"B05","judul"=>"Sejarah Dunia","kategori"=>"Sejarah","pengarang"=>"Ahmad","penerbit"=>"Yudhistira","tahun"=>2010,"harga"=>70000,"stok"=>0],
    ["kode"=>"B06","judul"=>"Algoritma","kategori"=>"Teknologi","pengarang"=>"Rizky","penerbit"=>"Informatika","tahun"=>2022,"harga"=>120000,"stok"=>7],
    ["kode"=>"B07","judul"=>"Pemrograman PHP","kategori"=>"Teknologi","pengarang"=>"Dewi","penerbit"=>"Informatika","tahun"=>2021,"harga"=>110000,"stok"=>4],
    ["kode"=>"B08","judul"=>"Biologi","kategori"=>"Pendidikan","pengarang"=>"Sari","penerbit"=>"Erlangga","tahun"=>2017,"harga"=>65000,"stok"=>8],
    ["kode"=>"B09","judul"=>"Kimia","kategori"=>"Pendidikan","pengarang"=>"Rina","penerbit"=>"Erlangga","tahun"=>2019,"harga"=>70000,"stok"=>0],
    ["kode"=>"B10","judul"=>"Negeri 5 Menara","kategori"=>"Novel","pengarang"=>"Ahmad Fuadi","penerbit"=>"Gramedia","tahun"=>2009,"harga"=>85000,"stok"=>6],
];

$keyword = $_GET['kategori'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? 'semua';
$sort = $_GET['sort'] ?? 'judul';
$_page = $_GET['page'] ?? 1;

$errors = [];

if ($min_harga && $max_harga && $min_) {
    $errors[] = "Harga minimum tidak boleh lebih dari harga maksimum";
}
if ($tahun && ($tahun < 1900 || $tahun > date("Y"))) {
    $errors[] = "Tahun tidak valid";
}
$hasil = array_filter($buku_list, function($buku) use ($keyword,$kategori,$min_harga,$max_harga,$tahun,$status){

    if ($keyword && !stripos($buku['judul'],$keyword) && !stripos($buku['pengarang'],$keyword)) return false;
    if ($kategori && $buku['kategori'] != $kategori) return false;
    if ($min_harga && $buku['harga'] < $min_harga) return false;
    if ($max_harga && $buku['harga'] > $max_harga) return false;
    if ($tahun && $buku['tahun'] != $tahun) return false;

    if ($status == "tersedia" && $buku['stok'] <= 0) return false;
    if ($status == "habis" && $buku['stok'] > 0) return false;

    return true;
});

// SORTING
usort($hasil, function($a,$b) use ($sort){
    return $a[$sort] <=> $b[$sort];
});

// PAGINATION
$per_page = 10;
$total = count($hasil);
$start = ($page - 1) * $per_page;
$hasil = array_slice($hasil, $start, $per_page);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h3 class="mb-4 text-white bg-primary p-3 rounded">Pencarian Buku</h3>

<!-- ERROR -->
<?php foreach($errors as $e): ?>
<div class="alert alert-danger"><?= $e ?></div>
<?php endforeach; ?>

<!-- FORM -->
<form method="GET" class="row g-2">

<input type="text" name="keyword" placeholder="Keyword" value="<?= $keyword ?>" class="form-control">

<select name="kategori" class="form-control">
    <option value="">Semua Kategori</option>
    <option <?= $kategori=="Novel"?"selected":"" ?>>Novel</option>
    <option <?= $kategori=="Pendidikan"?"selected":"" ?>>Pendidikan</option>
    <option <?= $kategori=="Teknologi"?"selected":"" ?>>Teknologi</option>
</select>

<input type="number" name="min_harga" placeholder="Min Harga" value="<?= $min_harga ?>" class="form-control">
<input type="number" name="max_harga" placeholder="Max Harga" value="<?= $max_harga ?>" class="form-control">

<input type="number" name="tahun" placeholder="Tahun" value="<?= $tahun ?>" class="form-control">

<select name="status" class="form-control">
    <option value="semua">Semua</option>
    <option value="tersedia" <?= $status=="tersedia"?"selected":"" ?>>Tersedia</option>
    <option value="habis" <?= $status=="habis"?"selected":"" ?>>Habis</option>
</select>

<select name="sort" class="form-control">
    <option value="judul">Judul</option>
    <option value="harga">Harga</option>
    <option value="tahun">Tahun</option>
</select>

<button class="btn btn-primary">Cari</button>
</form>

<hr>

<p><b>Total hasil: <?= $total ?></b></p>

<!-- TABLE -->
<table class="table table-bordered">
<tr>
<th>Kode</th><th>Judul</th><th>Kategori</th><th>Harga</th><th>Stok</th>
</tr>

<?php foreach($hasil as $b): ?>
<tr>
<td><?= $b['kode'] ?></td>
<td><?= $b['judul'] ?></td>
<td><?= $b['kategori'] ?></td>
<td><?= $b['harga'] ?></td>
<td><?= $b['stok'] ?></td>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>
