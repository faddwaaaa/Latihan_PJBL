<?php
require 'functions.php';
$dbEdit = new Fungsi();

$id = $_GET['id'];

$produk = $dbEdit->query("SELECT * FROM produk WHERE id_produk = $id")[0];

if (isset($_POST['submit'])) {
    $_POST['id_produk'] = $id;
    if ($dbEdit->editProduk($_POST) > 0) {
        echo "
            <script>
                alert('Produk berhasil diperbarui!');
                document.location.href = 'admin_produk.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Produk gagal diperbarui!');
                document.location.href = 'admin_produk.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body class="container py-5">

    <h3 class="mb-4"><i class="fa-solid fa-pen-to-square"></i> Edit Produk</h3>

    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="<?= $produk['nama_produk']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" value="<?= $produk['stok']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Beli</label>
            <input type="number" name="harga_beli" class="form-control" value="<?= $produk['harga_beli']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Jual</label>
            <input type="number" name="harga_jual" class="form-control" value="<?= $produk['harga_jual']; ?>" required>
        </div>

        <a href="admin_produk.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></a> 
        <button type="submit" name="submit" class="btn btn-success"> Simpan Perubahan </button>
    </form>

</body>
</html>
