<?php
require '../../config/database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan");
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);
    $tanggal_lahir = $_POST['tanggal_lahir'];

    if (empty($nama)) $errors[] = "Nama wajib diisi";
    if (empty($email)) $errors[] = "Email wajib diisi";
    if (empty($telepon)) $errors[] = "Telepon wajib diisi";
    if (empty($tanggal_lahir)) $errors[] = "Tanggal lahir wajib diisi";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid";
    }

    if (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        $errors[] = "Format telepon harus 08xxxxxxxxxx";
    }

    $umur = date('Y') - date('Y', strtotime($tanggal_lahir));
    if ($umur < 10) {
        $errors[] = "Umur minimal 10 tahun";
    }

    $stmt = $conn->prepare("SELECT id_anggota FROM anggota WHERE email = ? AND id_anggota != ?");
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $cek = $stmt->get_result();

    if ($cek->num_rows > 0) {
        $errors[] = "Email sudah digunakan";
    }

    $foto = $data['foto'];

    if (!empty($_FILES['foto']['name'])) {

        if (!empty($data['foto']) && file_exists("uploads/" . $data['foto'])) {
            unlink("uploads/" . $data['foto']);
        }

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = time() . '_' . uniqid() . '.' . $ext;

        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
    }

    if (empty($errors)) {

        $stmt = $conn->prepare("
            UPDATE anggota 
            SET nama=?, email=?, telepon=?, tanggal_lahir=?, foto=?
            WHERE id_anggota=?
        ");

        $stmt->bind_param(
            "sssssi",
            $nama, $email, $telepon, $tanggal_lahir, $foto, $id
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
            <?php foreach ($errors as $e): ?>
                <li><?= $e ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <input name="nama" value="<?= htmlspecialchars($data['nama']) ?>"><br>
    <input name="email" value="<?= htmlspecialchars($data['email']) ?>"><br>
    <input name="telepon" value="<?= htmlspecialchars($data['telepon']) ?>"><br>

    <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>"><br>

    <p>Foto saat ini:</p>
    <img src="uploads/<?= $data['foto'] ?>" width="100"><br>

    <input type="file" name="foto"><br>

    <button type="submit">Update</button>
</form>
