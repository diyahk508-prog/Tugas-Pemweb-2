<?php
require_once '../../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $kode = trim($_POST['kode']);
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);
    $alamat = trim($_POST['alamat']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jk'];
    $pekerjaan = trim($_POST['pekerjaan']);


    if (empty($kode)) $errors[] = "Kode wajib diisi";
    if (empty($nama)) $errors[] = "Nama wajib diisi";
    if (empty($email)) $errors[] = "Email wajib diisi";
    if (empty($telepon)) $errors[] = "Telepon wajib diisi";
    if (empty($alamat)) $errors[] = "Alamat wajib diisi";
    if (empty($tanggal_lahir)) $errors[] = "Tanggal lahir wajib diisi";
    if (empty($jk)) $errors[] = "Jenis kelamin wajib dipilih";
    if (empty($pekerjaan)) $errors[] = "Pekerjaan wajib diisi";


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }


    if (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        $errors[] = "Telepon harus format 08xxxxxxxxxx";
    }


    $umur = date('Y') - date('Y', strtotime($tanggal_lahir));
    if ($umur < 10) {
        $errors[] = "Umur minimal 10 tahun";
    }

    $foto = '';

    if (!empty($_FILES['foto']['name'])) {

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = time() . '_' . uniqid() . '.' . $ext;

        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
    }

    if (empty($foto)) {
        $fotos = ['sehun.jpg','suho.jpg','kai.jpg','irene.jpg','seulgi.jpg'];
        $foto = $fotos[array_rand($fotos)];
    }

    if (empty($errors)) {

        $stmt = $conn->prepare("
            INSERT INTO anggota 
            (kode_anggota, nama, email, telepon, alamat, tanggal_lahir, jenis_kelamin, pekerjaan, tanggal_daftar, status, foto)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), 'Aktif', ?)
        ");

        $stmt->bind_param(
            "sssssssss",
            $kode, $nama, $email, $telepon, $alamat, $tanggal_lahir, $jk, $pekerjaan, $foto
        );

        $stmt->execute();

        header("Location: index.php");
        exit;
    }
}
?>

<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <input name="kode" placeholder="Kode"><br>
    <input name="nama" placeholder="Nama"><br>
    <input name="email" placeholder="Email"><br>
    <input name="telepon" placeholder="Telepon (08xxxxxxxxxx)"><br>
    <input name="alamat" placeholder="Alamat"><br>

    <input type="date" name="tanggal_lahir"><br>

    <select name="jk">
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
    </select><br>

    <input name="pekerjaan" placeholder="Pekerjaan"><br>

    <input type="file" name="foto"><br>

    <button type="submit">Tambah Anggota</button>
</form>
