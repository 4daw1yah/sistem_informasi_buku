<?php
    require("function.php");
    $id = $_GET['id'];

    if(hapus_kategori($id) > 0){ 
        echo "<script>alert('Data kategori berhasil dihapus!'); document.location.href = 'data_kategori.php';</script>";
    }else{
        echo "<script>document.location.href = 'data_kategori.php';</script>";
    }
?>