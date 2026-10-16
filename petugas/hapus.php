
<?php

include '../koneksi/koneksi.php';

$id = $_GET['id'];

$query = "DELETE FROM petugas WHERE id='$id'";

if (mysqli_query($koneksi, $query)) {

    header("Location: ../index.php?status=hapus");
    exit();

} else {

    echo "Gagal menghapus data: " . mysqli_error($koneksi);

}

?>