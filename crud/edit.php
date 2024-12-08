<?php
require('../db/connect.php');
include('auth/function.php');

// Periksa apakah user sudah login
if (!isLoggedIn()) {
    echo "<script>
            alert('Anda harus login terlebih dahulu.');
            window.location.href = 'auth/login.php';
        </script>";
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM shoes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (isset($_POST['edit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $pictureName = $product['picture'];

    // Proses upload gambar baru
    if (!empty($_FILES['picture']['name'])) {
        $targetDir = "../images/";
        $pictureName = basename($_FILES['picture']['name']);
        $targetFilePath = $targetDir . $pictureName;

        if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetFilePath)) {
            // Hapus gambar lama jika ada
            if ($product['picture'] && file_exists("images/" . $product['picture'])) {
                unlink("uploads/" . $product['picture']);
            }
        } else {
            echo "<script>alert('Gagal mengupload gambar');</script>";
        }
    }

    // Update data ke database
    $stmt = $conn->prepare("UPDATE shoes SET name = ?, description = ?, picture = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $description, $pictureName, $id);
    if ($stmt->execute()) {
        echo "<script>
                alert('Produk berhasil diperbarui');
                window.location.href = '../admin.php';
            </script>";
    } else {
        echo "<script>alert('Gagal memperbarui produk');</script>";
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
    <link rel="stylesheet" href="style/edit.css">
</head>

<body>
    <div class="container">

        <div class="menu">
            <a href="../admin.php"><img src="../img/back.png" alt="Back"></a>
            <h1 class="shoes_title">Edit Produk</h1>
        </div>

        <form method="POST" enctype="multipart/form-data">

        <div class="input">

            <div class="inputs">
                <label for="name">Nama Produk:</label>
                <input type="text" name="name" value="<?= $product['name'] ?>">
            </div>
    
            <div class="inputs">
                <label for="description">Deskripsi:</label>
                <textarea name="description"><?= $product['description'] ?></textarea>
            </div>
    
            <div class="inputs">
                <label for="picture">Gambar:</label>
                <input type="file" name="picture" accept="image/*">
                <img src="../images/<?= $product['picture'] ?>" alt="Product Picture" width="150">
            </div>
    
            <button type="add" name="edit">Edit Produk</button>

        </div>
            
        </form>

    </div>
</body>

</html>
