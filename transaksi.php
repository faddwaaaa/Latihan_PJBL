<?php
require 'functions.php';

session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}

$db = new Fungsi();
$id_produk = $_GET['id'];

// Ambil data produk berdasarkan ID
$produk = $db->query("SELECT * FROM produk WHERE id_produk = '$id_produk'")[0];

if (isset($_POST['submit'])) {
    $jumlah = $_POST['jumlah'];
    $harga_jual = $produk['harga_jual'];
    $harga_beli = $produk['harga_beli'];
    $subtotal = $jumlah * $harga_jual;
    $keuntungan = ($harga_jual - $harga_beli) * $jumlah;
    $id_user = $_SESSION['user_id'];

    $db->query("INSERT INTO transaksi (id_user, id_produk, jumlah, harga_jual, subtotal, keuntungan, tanggal)
                VALUES ('$id_user', '$id_produk', '$jumlah', '$harga_jual', '$subtotal', '$keuntungan', NOW())");

    $id_transaksi = $db->getConnection()->insert_id;

    $db->query("UPDATE produk SET stok = stok - $jumlah WHERE id_produk = '$id_produk'");

    header("Location: struk.php?id=$id_transaksi");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4>Transaksi Penjualan</h4>
        </div>

        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" class="form-control" value="<?= $produk['nama_produk']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="text" class="form-control" value="Rp <?= number_format($produk['harga_jual']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Stok Tersedia</label>
                    <input type="text" class="form-control" value="<?= $produk['stok']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" min="1" max="<?= $produk['stok']; ?>" required>
                </div>

                <a href="user_produk.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></a> 
                <button type="submit" name="submit" class="btn btn-success">Simpan Transaksi</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
