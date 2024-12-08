<?php
require('../db/connect.php'); // Pastikan jalur ke file connect.php sudah benar

if ( isset($_POST['id']) && !empty($_POST['id']) ) {
    $id = $_POST['id'];

    // Ambil informasi produk untuk menghapus file gambar jika ada
    $stmt = $conn->prepare("SELECT picture FROM shoes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($picture);
    $stmt->fetch();
    $stmt->close();

    // Hapus file gambar dari folder images jika ada
    if ($picture && file_exists("../images/" . $picture)) {
        unlink("../images/" . $picture);
    }

    // Hapus data produk dari database
    $stmt = $conn->prepare("DELETE FROM favorite WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>
                alert('Produk berhasil dihapus');
                window.location.href = '../favorites.php';
            </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus produk');
                window.history.back();
            </script>";
    }

    $stmt->close();
}
?>
