<?php

$conn = mysqli_connect("localhost", "root", "", "sistem_informasi_buku"); 

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function register($data){
    global $conn;

    $username = strtolower(stripslashes($data['username']));
    $email = htmlspecialchars($data['email']);
    $password = mysqli_real_escape_string($conn, $data['password']);
    $konfirmasi_password = mysqli_real_escape_string($conn, $data['confirm_password']);

    $query_check = mysqli_query($conn, "SELECT username, email FROM user WHERE username = '$username' OR email = '$email'");
    if(mysqli_num_rows($query_check) > 0){
        return "username atau email sudah terdaftar, gunakan yang lain";
    }

    if($password !== $konfirmasi_password){
        return "Konfirmasi password tidak sesuai!";
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user (username, email, password) VALUES('$username', '$email', '$password_hash')");

    return mysqli_affected_rows($conn);
}

function login($data){
    global $conn;

    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);

    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row['password'])){
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            return true; 
        } else {
            return "salah password";
        }
    } else {
        return "username salah"; 
    }
}

function upload_gambar() {
    $namaFile   = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $tmpName    = $_FILES['gambar']['tmp_name'];
    $error      = $_FILES['gambar']['error'];

    if ($error === 4) {
        echo "<script>alert('Gambar belum dipilih');</script>";
        return false;
    }

    $extValid = ['jpg', 'jpeg', 'png'];
    $extFile = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if (!in_array($extFile, $extValid)) {
        echo "<script>alert('Yang kamu upload bukan gambar');</script>";
        return false;
    }

    $namaBaru = uniqid() . '.' . $extFile;

    if (!move_uploaded_file($tmpName, 'img/' . $namaBaru)) {
        echo "<script>alert('Upload gagal');</script>";
        return false;
    }

    return $namaBaru;
}

function tambah_buku($data){
    global $conn;

    $judul = htmlspecialchars($data['judul']);
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $harga = htmlspecialchars($data['harga']);
    $stok = htmlspecialchars($data['stok']);
    $id_kategori = htmlspecialchars($data['id_kategori']);

    $gambar = upload_gambar();
    if (!$gambar) {
        return false; 
    }

    
    $query = "INSERT INTO buku 
             (judul, deskripsi, harga, stok, id_kategori, gambar, tanggal_input)
              VALUES (
                '$judul',
                '$deskripsi',
                '$harga',
                '$stok',
                '$id_kategori',
                '$gambar',
                NOW()
              )";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


function hapus_buku($id){
    global $conn;

    $buku = query("SELECT gambar FROM buku WHERE id = $id")[0];
    if (file_exists('img/' . $buku['gambar']) && $buku['gambar'] != 'default.png') {
        unlink('img/' . $buku['gambar']);
    }

    $query = "DELETE FROM buku WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);    
}

function ubah_buku($data){
    global $conn;

    $id = $data['id'];
    $judul = htmlspecialchars($data['judul']);
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $harga = htmlspecialchars($data['harga']);
    $stok = htmlspecialchars($data['stok']);
    $id_kategori = htmlspecialchars($data['id_kategori']);
    $gambarLama = htmlspecialchars($data['gambarLama']); 

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        if (file_exists('img/' . $gambarLama) && $gambarLama != 'default.png') {
            unlink('img/' . $gambarLama);
        }
        $gambar = upload_gambar($judul);
    }
    
    if( !$gambar ) {
        return false;
    }

    $query = "UPDATE buku SET
                judul = '$judul',
                deskripsi = '$deskripsi',
                harga = '$harga',
                stok = '$stok',
                id_kategori = '$id_kategori',
                gambar = '$gambar'
              WHERE id = $id
             ";

     mysqli_query($conn, $query);
     
     return mysqli_affected_rows($conn);
}

function search_buku($keyword){
    $query = "SELECT b.*, k.nama_kategori 
              FROM buku b
              LEFT JOIN kategori k ON b.id_kategori = k.id
              WHERE
              b.judul LIKE '%$keyword%' OR
              b.deskripsi LIKE '%$keyword%' OR
              k.nama_kategori LIKE '%$keyword%'
              ORDER BY b.tanggal_input DESC
            ";
    return query($query);
}


function tambah_kategori($data){
    global $conn;
    $nama_kategori = htmlspecialchars($data['nama_kategori']);

    $result = mysqli_query($conn, "SELECT nama_kategori FROM kategori WHERE nama_kategori = '$nama_kategori'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>alert('Nama kategori sudah ada!');</script>";
        return 0;
    }

    $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus_kategori($id){
    global $conn;

    $check_buku = mysqli_query($conn, "SELECT id FROM buku WHERE id_kategori = $id");
    if(mysqli_num_rows($check_buku) > 0){
        echo "<script>alert('Tidak bisa menghapus! Kategori ini masih digunakan oleh beberapa buku.');</script>";
        return 0;
    }
    
    $query = "DELETE FROM kategori WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubah_kategori($data){
    global $conn;
    $id = $data['id'];
    $nama_kategori = htmlspecialchars($data['nama_kategori']);

    $query = "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function search_kategori($keyword){
    $query = "SELECT * FROM kategori
              WHERE
              nama_kategori LIKE '%$keyword%'
              ORDER BY tanggal_input DESC
            ";
    return query($query);
}

?>