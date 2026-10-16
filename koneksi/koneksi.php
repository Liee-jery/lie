<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "kereta_api"; // Ganti dengan nama database Anda

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>