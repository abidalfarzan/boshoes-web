<?php
include('auth/function.php');

// Periksa apakah user sudah login
if (!isLoggedIn()) {
    echo "<script>
            alert('Anda harus login terlebih dahulu.');
            window.location.href = 'auth/login.php';
        </script>";
    exit;
}

if (isset($_POST['fav'])) {
    $id = $_POST['id'];
    
    // Ambil data dari tabel produk berdasarkan ID
    $queryShoes = mysqli_query($conn, "SELECT * FROM shoes WHERE id = '$id'");
    $shoesData = mysqli_fetch_assoc($queryShoes);

    if ($shoesData) {
        // Masukkan data ke tabel cart
        $insertFavorite = mysqli_query($conn, "INSERT INTO favorite (name, description, picture) VALUES (
            '{$shoesData['name']}',
            '{$shoesData['description']}',
            '{$shoesData['picture']}'
        )");

        if ($insertFavorite) {
            echo "<script>alert('Produk berhasil ditambahkan ke keranjang!');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menambahkan ke keranjang.');</script>";
        }
    } else {
        echo "<script>alert('Produk tidak ditemukan.');</script>";
    }
}

$i = 1;

$result = $conn->query("SELECT * FROM shoes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style/loaner.css">
</head>
<body>

    <header class="header">

        <nav class="navbar">
            <div for="right" class="right">
                <a href="index.php" class="logo"><img src="img/logo.png" alt="Logo"></a>
                <a href="auth/logout.php" class="logout"><img src="img/logout.png" alt="Logout"></a>
            </div>
            <div for="left" class="left">
                <a href="favorites.php" class="favorites"><img src="img/bags.png" alt="Favorites"></a>
            </div>
        </nav>

    </header>

    <main class="main">

        <div class="container1">
            <div class="content">
                <h1>WELCOME TO <span>LOANER PAGE!</span></h1>
                <h2>Halo, Loaner!</h2>
            </div>

        </div>

        <div class="container2">

            <h1 class="shoes_data">Shoes Data</h1>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>❤️</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td>
                                    <?php if ($row['picture']): ?>
                                        <img src="images/<?= $row['picture'] ?>" alt="Gambar Produk" width="80">
                                    <?php else: ?>
                                        Tidak ada gambar
                                    <?php endif; ?>
                                </td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['description'] ?></td>
                                <td class="aksi">
                                    <form action="" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="fav">
                                            <h1 class="favorite">❤️</h1>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php $i++; endwhile; else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Tidak ada Data Sepatu</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>
