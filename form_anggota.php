<?php
$nama = $email = $telepon = $alamat = $jk = $tgl_lahir = $pekerjaan = "";
$errors = [];
$success = false;


function hitungUmur($tgl_lahir) {
    $today = new DateTime();
    $birth = new DateTime($tgl_lahir);
    return $today->diff($birth)->y;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jk'] ?? "";
    $tgl_lahir = $_POST['tgl_lahir'];
    $pekerjaan = $_POST['pekerjaan'];

    if (empty($nama) || strlen($nama) < 3) {
        $errors['nama'] = "Nama minimal 3 karakter";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid";
    }

    
    if (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        $errors['telepon'] = "Format telepon tidak valid (08xxxxxxxxxx)";
    }

    
    if (empty($alamat) || strlen($alamat) < 10) {
        $errors['alamat'] = "Alamat minimal 10 karakter";
    }

    
    if (empty($jk)) {
        $errors['jk'] = "Pilih jenis kelamin";
    }

    
    if (empty($tgl_lahir) || hitungUmur($tgl_lahir) < 10) {
        $errors['tgl_lahir'] = "Umur minimal 10 tahun";
    }

    
    if (empty($pekerjaan)) {
        $errors['pekerjaan'] = "Pilih pekerjaan";
    }

    
    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="mb-4">Form Registrasi Anggota</h3>

    <?php if ($success): ?>
        <div class="alert alert-success">
            Registrasi berhasil!
        </div>

        <div class="card p-3">
            <p><strong>Nama:</strong> <?= $nama ?></p>
            <p><strong>Email:</strong> <?= $email ?></p>
            <p><strong>Telepon:</strong> <?= $telepon ?></p>
            <p><strong>Alamat:</strong> <?= $alamat ?></p>
            <p><strong>Jenis Kelamin:</strong> <?= $jk ?></p>
            <p><strong>Tanggal Lahir:</strong> <?= $tgl_lahir ?></p>
            <p><strong>Pekerjaan:</strong> <?= $pekerjaan ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" class="mt-4">

    
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama"
                class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                value="<?= $nama ?>">
            <div class="invalid-feedback"><?= $errors['nama'] ?? "" ?></div>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email"
                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                value="<?= $email ?>">
            <div class="invalid-feedback"><?= $errors['email'] ?? "" ?></div>
        </div>

        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon"
                class="form-control <?= isset($errors['telepon']) ? 'is-invalid' : '' ?>"
                value="<?= $telepon ?>">
            <div class="invalid-feedback"><?= $errors['telepon'] ?? "" ?></div>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat"
                class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>"><?= $alamat ?></textarea>
            <div class="invalid-feedback"><?= $errors['alamat'] ?? "" ?></div>
        </div>

        <div class="mb-3">
            <label>Jenis Kelamin</label><br>
            <input type="radio" name="jk" value="Laki-laki" <?= $jk == "Laki-laki" ? "checked" : "" ?>> Laki-laki
            <input type="radio" name="jk" value="Perempuan" <?= $jk == "Perempuan" ? "checked" : "" ?>> Perempuan
            <div class="text-danger"><?= $errors['jk'] ?? "" ?></div>
        </div>

        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tgl_lahir"
                class="form-control <?= isset($errors['tgl_lahir']) ? 'is-invalid' : '' ?>"
                value="<?= $tgl_lahir ?>">
            <div class="invalid-feedback"><?= $errors['tgl_lahir'] ?? "" ?></div>
        </div>


        <div class="mb-3">
            <label>Pekerjaan</label>
            <select name="pekerjaan"
                class="form-control <?= isset($errors['pekerjaan']) ? 'is-invalid' : '' ?>">
                <option value="">-- Pilih --</option>
                <option <?= $pekerjaan == "Pelajar" ? "selected" : "" ?>>Pelajar</option>
                <option <?= $pekerjaan == "Mahasiswa" ? "selected" : "" ?>>Mahasiswa</option>
                <option <?= $pekerjaan == "Pegawai" ? "selected" : "" ?>>Pegawai</option>
                <option <?= $pekerjaan == "Lainnya" ? "selected" : "" ?>>Lainnya</option>
            </select>
            <div class="invalid-feedback"><?= $errors['pekerjaan'] ?? "" ?></div>
        </div>

        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>

</body>
</html>