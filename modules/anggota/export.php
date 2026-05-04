<?php
require '../../config/database.php';

// Header untuk download Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=data_anggota.xls");

// Judul kolom
echo "No\tNama\tEmail\tTelepon\tJenis Kelamin\tStatus\n";

// Ambil data dari database
$data = $conn->query("SELECT * FROM anggota");

$no = 1;
while($row = $data->fetch_assoc()){
    echo $no++ . "\t";
    echo $row['nama'] . "\t";
    echo $row['email'] . "\t";
    echo $row['telepon'] . "\t";
    echo $row['jenis_kelamin'] . "\t";
    echo $row['status'] . "\n";
}
?>