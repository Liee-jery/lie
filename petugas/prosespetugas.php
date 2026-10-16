<?php

include '../koneksi/koneksi.php';

$id     = $_POST['id'];
$nik    = $_POST['nik'];
$nama   = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_hp  = $_POST['no_hp'];

$query = "INSERT INTO petugas (id, nik, nama, alamat, no_hp)
          VALUES ('$id', '$nik', '$nama', '$alamat', '$no_hp')";

if (mysqli_query($koneksi, $query)) {

    header("Location: ../tampilPetugas.php?status=sukses");
    exit();

} else {

    echo "Gagal menyimpan data: " . mysqli_error($koneksi);

}

?>