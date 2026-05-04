<?php
$page_title = "Data Anggota";
require_once '../../config/database.php';
require_once '../../includes/header.php';

$limit = 10;
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $limit;

$search = $_GET['search'] ?? '';

if ($search) {
    $param = "%$search%";
    $stmt = $conn->prepare("SELECT * FROM anggota WHERE nama LIKE ? OR email LIKE ? OR telepon LIKE ? LIMIT ? OFFSET ?");
    $stmt->bind_param("sssii", $param, $param, $param, $limit, $offset);
} else {
    $stmt = $conn->prepare("SELECT * FROM anggota LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

$total = $conn->query("SELECT COUNT(*) as total FROM anggota")->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);
?>

<div class="container">
<h2>Data Anggota</h2>

<a href="create.php" class="btn btn-primary mb-3">Tambah</a>
<a href="export.php" class="btn btn-success mb-3">Export Excel</a>

<form method="GET" class="mb-3">
<input type="text" name="search" value="<?= $search ?>" placeholder="Cari...">
<button class="btn btn-primary">Cari</button>
</form>

<table class="table table-bordered">
<tr>
<th>No</th>
<th>Foto</th>
<th>Nama</th>
<th>Email</th>
<th>Telepon</th>
<th>Jenis Kelamin</th>
<th>Status</th>
<th>Aksi</th>
</tr>

<?php $no=$offset+1; while($row=$result->fetch_assoc()): ?>
<tr>
<td><?= $no++ ?></td>

<td>
<?php if($row['foto'] && file_exists("uploads/".$row['foto'])): ?>
<img src="uploads/<?= $row['foto'] ?>" width="60">
<?php else: ?>
<img src="uploads/sehun.jpg" width="60">
<?php endif; ?>
</td>

<td><?= $row['nama'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['telepon'] ?></td>

<td>
<span class="badge bg-info"><?= $row['jenis_kelamin'] ?></span>
</td>

<td>
<span class="badge bg-<?= $row['status']=='Aktif'?'success':'secondary' ?>">
<?= $row['status'] ?>
</span>
</td>

<td>
<a href="edit.php?id=<?= $row['id_anggota'] ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="delete.php?id=<?= $row['id_anggota'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<?php for($i=1;$i<=$total_pages;$i++): ?>
<a href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
<?php endfor; ?>

</div>

<?php require '../../includes/footer.php'; ?>
