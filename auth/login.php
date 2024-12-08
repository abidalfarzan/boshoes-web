<?php

include('function.php');

$isAdmin = isAdmin();

// Periksa apakah user sudah login
if (isLoggedIn()) {
    if (!$isAdmin) {
        header("Location: ../loaner.php");
        exit;
    } else {
        header("Location: ../admin.php");
        exit;
    }
}

// Periksa apakah tombol "login" ditekan
if (isset($_POST['login'])) {
    $identifier = $_POST['identifier']; // Bisa username atau email
    $password = $_POST['pw'];

    if (checkLogin($identifier, $password)) {
        echo "<script>
                alert('Login berhasil! Anda akan diarahkan ke halaman utama.');
                window.location.href = '../admin.php';
            </script>";
    } else {
        echo "<script>
                alert('Akun tidak ditemukan. Silakan coba lagi.');
                window.history.back();
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    
    <div class="container">

        <div class="title">
            <h1>Login Page</h1>
        </div>
        
        <form method="POST">
            
            <div class="input">

                <div class="inputs">
                    <label for="identifier">Username atau Email</label>
                    <input type="text" name="identifier" placeholder="Username atau Email" required>
                </div>
                <div class="inputs">
                    <label for="password">Password</label>
                    <input type="password" name="pw" placeholder="Password" required>
                </div>

                <button type="submit" name="login" value="login">Login</button>

                <p>Haven't make an account yet? <a href="register.php">Register</a></p>

            </div>

        </form> 

    </div>
    
</body>
</html>
