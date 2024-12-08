<?php
session_start(); // Inisialisasi session

// Hapus semua data session
session_unset(); 

// Hancurkan session
session_destroy(); 

// Redirect ke halaman login
header("Location: login.php");
exit;
?>