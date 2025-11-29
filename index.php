<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require("function.php");

// PAGINATION
$jumlahDataPerHalaman = 4;
$jumlahData = count(query("SELECT * FROM buku"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$buku = query("
    SELECT b.*, k.nama_kategori 
    FROM buku b
    LEFT JOIN kategori k ON b.id_kategori = k.id
    LIMIT $awalData, $jumlahDataPerHalaman
");

if(isset($_POST['tombol_search'])){
    $buku = search_buku($_POST['keyword']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand text-white" href="#">Sistem Informasi Buku</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">

                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="p-3">
    <div class="container">

        <h1>Halo, Selamat Datang <?= $_SESSION['username'] ?></h1>
        <a href="logout.php">Logout</a>

        <h2 class="mt-3">Data Buku</h2>

        <div class="d-flex justify-content-between align-items-center">
            <a href="tambah_buku.php">
                <button class="mb-2 btn-sm btn-primary">Tambah Buku</button>
            </a>

            <!-- PAGINATION -->
            <nav>
                <ul class="pagination">
                    <?php if($halamanAktif > 1): ?>
                        <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?>">&laquo;</a></li>
                    <?php endif; ?>

                    <?php for($i=1; $i <= $jumlahHalaman; $i++): ?>
                        <li class="page-item <?= $i == $halamanAktif ? 'active' : '' ?>">
                            <a class="page-link" href="?halaman=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if($halamanAktif < $jumlahHalaman): ?>
                        <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?>">&raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <!-- SEARCH -->
            <form class="mb-2" action="" method="POST">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" placeholder="Cari buku..." autocomplete="off">
                    <button class="btn btn-primary" type="submit" name="tombol_search">Cari</button>
                </div>
            </form>
        </div>

        <!-- TABEL -->
        <table class="table table-striped table-hover">
            <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>

            <?php $no = 1; ?>
            <?php foreach($buku as $b): ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $b['judul'] ?></td>
                <td><?= $b['deskripsi'] ?></td>
                <td>Rp <?= number_format($b['harga']) ?></td>
                <td><?= $b['stok'] ?></td>
                <td><?= $b['nama_kategori'] ?></td>

                <td>
                    <img src="img/<?= $b['gambar'] ?>" style="border:2px solid red;"><?= "img/" . $b['gambar'] ?>
                </td>

                <td>
                    <a href="ubah_buku.php?id=<?= $b['id'] ?>">
                        <button class="btn btn-sm btn-success">Edit</button>
                    </a>
                    <a href="hapus_buku.php?id=<?= $b['id'] ?>">
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </a>
                </td>
            </tr>
            <?php $no++; ?>
            <?php endforeach; ?>
        </table>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
