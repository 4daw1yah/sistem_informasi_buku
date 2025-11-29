<?php
$conn = mysqli_connect("localhost", "root", "", "sistem_informasi_buku");
if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
