<?php
    require("function.php");
    $id = $_GET['id'];

    if(hapus_buku($id) > 0){
        echo "<script>alert('Data buku berhasil dihapus!'); document.location.href = 'index.php';</script>";
    }else{
        echo "<script>alert('Data buku gagal dihapus!'); document.location.href = 'index.php';</script>";
    }
?>