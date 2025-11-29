<?php
    require("function.php");

    if(isset($_POST['ubah_kategori'])){
        if(ubah_kategori($_POST) > 0){
            echo "<script>alert('Data kategori berhasil diubah!'); document.location.href = 'data_kategori.php';</script>";
        }else{
            echo "<script>alert('Data kategori gagal diubah!'); document.location.href = 'data_kategori.php';</script>";
        }
    } else {
        header("Location: data_kategori.php");
        exit;
    }
?>