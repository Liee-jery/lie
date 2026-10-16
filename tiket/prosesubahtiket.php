<?php
include '../koneksi/koneksi.php';

$stmt = mysqli_prepare($koneksi,
    "UPDATE pesan_tiket
     SET harga=?, dari=?, tujuan=?, jlh_penumpang=?, no_kursi=?, id_pel=?
     WHERE id_pesan=?");
mysqli_stmt_bind_param($stmt, "sssssss",
    $_POST['harga'], $_POST['dari'], $_POST['tujuan'],
    $_POST['jlh_penumpang'], $_POST['no_kursi'], $_POST['id_pel'], $_POST['id_pesan']);

if (mysqli_stmt_execute($stmt)) {
    header("Location: pesantiket.php");
    exit;
}
echo "Gagal mengubah data: " . mysqli_error($koneksi);