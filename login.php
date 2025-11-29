<?php
session_start();
if( isset($_SESSION["login"]) ) {
    header("Location: index.php");
    exit;
}

require("function.php");

$error = "";

if(isset($_POST['tombol_login'])){
    $result = login($_POST); 
    
    if($result === true){
        header("Location: index.php");
        exit;
    }else{
        $error = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #fff;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2 class="text-center mb-4">Login</h2>

        <?php 
        if ($error): ?>
            <div class="alert alert-danger" role="alert">
                Login Gagal: *<?= htmlspecialchars($error); ?>*
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            
            <div class="mb-3">
                <label for="username" class="form-label">Nama Pengguna</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="username" 
                    name="username" 
                    required 
                    autocomplete="off"
                    placeholder="Masukkan nama pengguna..."
                >
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Kata sandi</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" 
                    required
                    placeholder="Masukkan kata sandi..."
                >
            </div>
            
            <button type="submit" name="tombol_login" class="btn btn-primary w-100 mt-2">Login</button>
        </form>

        <p class="text-center mt-3">
            Sudah punya akun? <a href="register.php">Register</a>
        </p>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>