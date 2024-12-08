<?php

// session_start();
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

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['pw'];
    $confirmPassword = $_POST['pw2'];

    // Validasi password
    if ($password !== $confirmPassword) {
        echo "<script>
                alert('Password dan Konfirmasi Password tidak sama. Silakan ulangi.');
                window.history.back();
            </script>";
        exit;
    }

    // Registrasi user
    if (registerUser($username, $email, $password)) {
        echo "<script>
                alert('Registrasi berhasil! Anda akan diarahkan ke halaman login.');
                window.location.href = 'login.php';
            </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal. Silakan coba lagi.');
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
    <title>Register Page</title>
    <link rel="stylesheet" href="style/register.css">
</head>
<body>
    
    <div class="container">

        <div class="title">
            <h1>Register Page</h1>
        </div>
        
        <form method="POST">
            
            <div class="input">

                <div class="inputs">
                    <label for="username">Username</label>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="inputs">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="inputs">
                    <label for="password">Password</label>
                    <input type="password" name="pw" placeholder="Password" required>
                </div>
                <div class="inputs">
                    <label for="password2">Confirm Password</label>
                    <input type="password" name="pw2" placeholder="Confirm Password" required>
                </div>

                <button type="submit" name="register">Register</button>

                <p>Already have an account? <a href="login.php">Login</a></p>

            </div>

        </form> 

    </div>
    
</body>
</html>