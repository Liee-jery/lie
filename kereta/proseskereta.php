<?php

include '../koneksi/koneksi.php';

$id            = $_POST['id'];
$nama_kereta   = $_POST['nama_kereta'];
$kelas         = $_POST['kelas'];
$no_kursi         = $_POST['no_kursi'];


$query = "INSERT INTO kereta (id, nama_kereta, kelas, no_kursi)
          VALUES ('$id', '$nama_kereta', '$kelas', '$no_kursi')";

if (mysqli_query($koneksi, $query)) {

    header("Location: ../index.php?status=sukses");
    exit();

} else {

    echo "Gagal menyimpan data: " . mysqli_error($koneksi);

}

?>