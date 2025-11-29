<?php
session_start();
if( isset($_SESSION["login"]) ) {
    header("Location: index.php");
    exit;
}

require("function.php");

$error = "";
$success = "";

if(isset($_POST['tombol_register'])){
    $result = register($_POST);
    
    
    if(is_int($result) && $result > 0){
        $success = "Registrasi berhasil! Silakan login.";
    } else {
        $error = $result; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIMBS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .register-card {
            width: 100%;
            max-width: 450px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #fff;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <h2 class="text-center mb-4">Register</h2>

        <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($success); ?> <a href="login.php" class="alert-link">Klik di sini untuk Login</a>
            </div>
        <?php endif; ?>

        <?php if ($error && !is_int($error)): ?>
            <div class="alert alert-danger" role="alert">
                Registrasi Gagal: *<?= htmlspecialchars($error); ?>*
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username..." required autocomplete="off" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email..." required autocomplete="off" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password..." required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Ulangi password..." required>
            </div>
            
            <button type="submit" name="tombol_register" class="btn btn-primary w-100 mt-2">Register</button>
        </form>

        <p class="text-center mt-3">
            Sudah punya akun? <a href="login.php">Login</a>
        </p>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>