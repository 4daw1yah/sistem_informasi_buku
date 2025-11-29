<?php
session_start();
if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require("function.php");

$id = $_GET['id'];

$buku = query("SELECT b.*, k.nama_kategori 
               FROM buku b
               LEFT JOIN kategori k ON b.id_kategori = k.id
               WHERE b.id = $id")[0];

$kategori_list = query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");


if(isset($_POST['tombol_submit'])){
    if(ubah_buku($_POST) > 0){
        echo "<script>alert('Data buku berhasil diubah!'); document.location.href = 'index.php';</script>";
    }else{
        echo "<script>alert('Data buku gagal diubah atau tidak ada perubahan!'); document.location.href = 'index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.2rem;
            font-weight: bold;
        }
        .form-control {
            border-radius: 0; 
            border-left: none;
            border-right: none;
            border-top: none;
            padding-left: 0;
        }
        .container-form {
            padding-top: 20px;
            max-width: 800px; 
        }
    </style>
</head>
<body>
    
    <div style="color: white; padding: 10px 20px;">
        <span style="font-size: 1.2rem;">SISTEM INFORMASI BUKU</span>
    </div>

    <div class="container container-form">
        <h1 class="mb-2">Ubah Data Buku</h1>
        <a href="index.php" class="text-primary d-inline-block mb-4" style="text-decoration: none;">Kembali</a>
        
        <div class="col-lg-8 col-md-10">
            <form action="" method="POST" enctype="multipart/form-data"> 
                <input type="hidden" name="id" value="<?= htmlspecialchars($buku['id']) ?>">
                <input type="hidden" name="gambarLama" value="<?= htmlspecialchars($buku['gambar']) ?>">
                
                <div class="form-group">
                    <label for="judul">Judul Buku</label>
                    <input type="text" class="form-control" id="judul" name="judul" required autocomplete="off" 
                           value="<?= htmlspecialchars($buku['judul']) ?>" placeholder="judul buku">
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required placeholder="deskripsi singkat buku"><?= htmlspecialchars($buku['deskripsi']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="harga">Harga (Rp)</label>
                    <input type="number" class="form-control" id="harga" name="harga" required autocomplete="off" 
                           value="<?= htmlspecialchars($buku['harga']) ?>" placeholder="harga">
                </div>
                
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" required autocomplete="off" 
                           value="<?= htmlspecialchars($buku['stok']) ?>" placeholder="stok">
                </div>
                
                <div class="form-group">
                    <label for="id_kategori">Kategori</label>
                    <select class="form-select form-control" id="id_kategori" name="id_kategori" required>
                        <option value="">Pilih Kategori</option>
                        <?php foreach($kategori_list as $kat) : ?>
                            <option value="<?= $kat['id'] ?>"
                                <?= ($kat['id'] == $buku['id_kategori']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kat['nama_kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                <div class="mt-4">      
                    <button type="submit" name="tombol_submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>