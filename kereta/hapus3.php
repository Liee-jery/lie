
<?php

include '../koneksi/koneksi.php';

$id = $_GET['id'];

$query3 = "DELETE FROM kereta WHERE id='$id'";

if (mysqli_query($koneksi, $query3)) {

    header("Location: ../tampilPetugas.php?status=hapus");
    exit();

} else {

    echo "Gagal menghapus data: " . mysqli_error($koneksi);

}

?>