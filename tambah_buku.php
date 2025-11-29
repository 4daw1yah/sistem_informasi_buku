<?php
session_start();
if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require("function.php");

$kategori_list = query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");

if(isset($_POST['tombol_submit'])){
    if(tambah_buku($_POST) > 0){
        echo "<script>
                alert('Data buku berhasil ditambahkan!');
                document.location.href = 'index.php';
              </script>";
    }else{
        echo "<script>
                alert('Gagal menambahkan buku!');
                document.location.href = 'tambah_buku.php';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="p-4 container">
    <h1 class="mb-4">Tambah Data Buku</h1>
    <a href="index.php" class="mb-3 d-inline-block">Kembali</a>
    
    <div class="col-md-6">
        <form action="" method="POST" enctype="multipart/form-data"> 
            
            <div class="mb-3">
                <label class="form-label fw-bold">Judul Buku</label>
                <input type="text" class="form-control" name="judul" required autocomplete="off">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Harga (Rp)</label>
                <input type="number" class="form-control" name="harga" required autocomplete="off">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Stok</label>
                <input type="number" class="form-control" name="stok" required autocomplete="off">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Kategori</label>
                <select class="form-select" name="id_kategori" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach($kategori_list as $kat) : ?>
                        <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Gambar Cover</label>
                <input type="file" class="form-control" name="gambar" id="gambar" required> 
                <small class="form-text text-muted">Maksimal 5MB. Format JPG, JPEG, PNG.</small>
            </div>
            
            <div class="mb-3">      
                <button type="submit" name="tombol_submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
