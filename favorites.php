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

$i = 1;

$result = $conn->query("SELECT * FROM favorite");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites Page</title>
    <link rel="stylesheet" href="style/favs.css">
</head>
<body>

    <header class="header">

        <nav class="navbar">
            <div for="right" class="right">
                <a href="index.php" class="logo"><img src="img/logo.png" alt="Logo"></a>
                <!-- <a href="auth/logout.php" class="logout"><img src="img/logout.png" alt="Logout"></a> -->
            </div>
            <div for="left" class="left">
                <a href="loaner.php" class="back"><img src="img/backs.png" alt="Back"></a>
            </div>
        </nav>

    </header>

    <main class="main">

        <div class="container1">
            <div class="content">
                <h1>This is your <span>FAVORITES PAGE!</span></h1>
            </div>
        </div>

        <div class="container2">

            <h1 class="shoes_data">Favorites Data</h1>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>🗑️</th>
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
                                    <form action="crud/deleteFav.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit">
                                            <img src="img/delete.png" alt="Delete" class="delete">
                                        </button>
                                        <a href="https://mail.google.com/"></a>
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

            <!-- <div class="contact-admin">
                <p>Mau minjem? <a href="mailto:admin@boshoes.com">Hubungi Admin!</a></p>
            </div> -->
        </div>

    </main>

</body>
</html>
