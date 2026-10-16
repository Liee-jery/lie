
<?php

include '../koneksi/koneksi.php';

$id     = $_POST['id'];
$nik    = $_POST['nik'];
$nama   = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_hp  = $_POST['no_hp'];
$email  = $_POST['email'];

$query2 = "UPDATE pelanggan SET
          nik='$nik',
          nama='$nama',
          alamat='$alamat',
          no_hp='$no_hp',
          email='$email'
          WHERE id='$id'";

if (mysqli_query($koneksi, $query2)) {

    header("Location: index.php?status=ubah");
    exit();

}else {
    echo "Gagal mengubah data: ", mysqli_error($koneksi);
}

?>
```