<?php

session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/boshoes/db/connect.php');

function registerUser($username, $email, $password) {
    global $conn;

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert data ke database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}

// Fungsi untuk memeriksa login
function checkLogin($identifier, $password) {
    global $conn;

    // Periksa apakah identifier adalah email atau username
    $stmt = $conn->prepare("SELECT id, password, email FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $hashedPassword, $email);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $userId; // Simpan user ID di session
            $_SESSION['email'] = $email;   // Simpan email di session
            return true; // Login berhasil
        }
    }

    $stmt->close();
    return false; // Login gagal
}

// Fungsi untuk memeriksa apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Daftar email admin
define("ADMIN_EMAIL", "admin@boshoes.com");

// Fungsi untuk mengecek apakah user adalah admin
function isAdmin() {
    return isset($_SESSION['email']) && $_SESSION['email'] === ADMIN_EMAIL;
}
?>
