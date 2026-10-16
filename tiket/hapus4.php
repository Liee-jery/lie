<?php
include '../koneksi/skoneksi.php';

$id = $_GET['id'];
$stmt = mysqli_prepare($koneksi, "DELETE FROM pesan_tiket WHERE id_pesan=?");
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);

header("Location: ../pesantiket.php");
exit;