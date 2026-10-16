
<?php

include '../koneksi/koneksi.php';

$id     = $_POST['id'];
$nik    = $_POST['nik'];
$nama   = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_hp  = $_POST['no_hp'];

$query = "UPDATE petugas SET
          nik='$nik',
          nama='$nama',
          alamat='$alamat',
          no_hp='$no_hp'
          WHERE id='$id'";

if (mysqli_query($koneksi, $query)) {

    header("Location: tampilPetugas.php?status=ubah");
    exit();

} else {

    echo "Gagal mengubah data: ",  mysqli_error($koneksi);

}

?>
```