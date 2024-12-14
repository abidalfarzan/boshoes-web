<?php
require('../db/connect.php'); // Pastikan file ini berisi koneksi database

include('../auth/function.php');

// Periksa apakah user sudah login
if (!isLoggedIn()) {
    echo "<script>
            alert('Anda harus login terlebih dahulu.');
            window.location.href = 'auth/login.php';
        </script>";
    exit;
}

if (isset($_POST['add'])) {	
    $name = $_POST['name'];
    $description = $_POST['description'];
    $pictureName = null;

    // Proses upload gambar
    if (!empty($_FILES['picture']['name'])) {
        $targetDir = "../images/"; // Folder penyimpanan gambar
        $pictureName = basename($_FILES['picture']['name']);
        $targetFilePath = $targetDir . $pictureName;

        if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetFilePath)) {
            // File berhasil diupload
        } else {
            echo "<script>alert('Gagal mengupload gambar');</script>";
        }
    }

    // Insert data ke database
    $stmt = $conn->prepare("INSERT INTO shoes (name, description, picture) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $description, $pictureName);
    if ($stmt->execute()) {
        echo "<script>
                alert('Produk berhasil ditambahkan');
                window.location.href = '../admin.php';
            </script>";
    } else {
        echo "<script>alert('Gagal menambahkan produk');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Shoes</title>
    <link rel="stylesheet" href="style/create.css">
</head>

<body>
    <div class="container">

        <div class="menu">
            <a href="../admin.php"><img src="../img/back.png" alt="Back"></a>
            <h1 class="shoes_title">Tambah Produk</h1>
        </div>

        <form method="POST" enctype="multipart/form-data">

        <div class="input">

            <div class="inputs">
                <label for="name">Nama Produk:</label>
                <input type="text" name="name" required>
            </div>
    
            <div class="inputs">
                <label for="description">Deskripsi:</label>
                <textarea name="description" required></textarea>
            </div>
    
            <div class="inputs">
                <label for="picture">Gambar:</label>
                <input type="file" name="picture" accept="image/*"><br><br>
            </div>
    
            <button type="add" name="add">Tambah Produk</button>

        </div>
            
        </form>

    </div>
</body>

</html>
