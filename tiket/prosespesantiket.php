<?php
include '../koneksi/koneksi.php';

$id_pesan      = $_POST['id_pesan'];
$harga         = $_POST['harga'];
$dari          = $_POST['dari'];
$tujuan        = $_POST['tujuan'];
$jlh_penumpang = $_POST['jlh_penumpang'];
$no_kursi      = $_POST['no_kursi'];
$id_pel        = $_POST['id_pel'];

// Cek dulu: ID pesan tidak boleh kembar
$cek = mysqli_prepare($koneksi, "SELECT id_pesan FROM pesan_tiket WHERE id_pesan=?");
mysqli_stmt_bind_param($cek, "s", $id_pesan);
mysqli_stmt_execute($cek);
if (mysqli_num_rows(mysqli_stmt_get_result($cek)) > 0) {
    echo "ID Pesan <b>" . htmlspecialchars($id_pesan) . "</b> sudah dipakai. ";
    echo "<a href='javascript:history.back()'>Kembali</a>";
    exit;
}

// Semua kolom varchar -> semua tipe "s" (string)
$stmt = mysqli_prepare($koneksi,
    "INSERT INTO pesan_tiket (id_pesan, harga, dari, tujuan, jlh_penumpang, no_kursi, id_pel)
     VALUES (?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssssss",
    $id_pesan, $harga, $dari, $tujuan, $jlh_penumpang, $no_kursi, $id_pel);

if (mysqli_stmt_execute($stmt)) {
    header("Location: pesantiket.php");
    exit;
}
echo "Gagal menyimpan: " . mysqli_error($koneksi);