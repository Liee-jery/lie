
<?php

include '../koneksi/koneksi.php';

$id = $_GET['id'];

$query2 = "DELETE FROM pelanggan WHERE id='$id'";

if (mysqli_query($koneksi, $query2)) {

    header("Location: ../index.php?status=hapus");
    exit();

} else {

    echo "Gagal menghapus data: " . mysqli_error($koneksi);

}

?>