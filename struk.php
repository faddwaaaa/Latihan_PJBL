<?php
require 'functions.php';
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}

$dbStruk = new Fungsi();

$id_transaksi = $_GET['id'];

$result = $dbStruk->query("
    SELECT t.*, p.nama_produk, u.username
    FROM transaksi t
    JOIN produk p ON t.id_produk = p.id_produk
    JOIN user u ON t.id_user = u.id_user
    WHERE t.id_transaksi = '$id_transaksi'
");

$data = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk #<?= $data['id_transaksi'] ?></title>
<style>
body {
    font-family: 'Courier New', monospace;
    width: 300px;
    margin: auto;
    background: #fff;
    color: #000;
}
h2, h3, p {
    text-align: center;
    margin: 0;
    padding: 0;
}
hr {
    border: 1px dashed #000;
    margin: 10px 0;
}
.table {
    width: 100%;
    border-collapse: collapse;
}
.table td {
    font-size: 14px;
    padding: 2px 0;
}
.text-right { text-align: right; }
.text-center { text-align: center; }
.total {
    font-weight: bold;
    font-size: 16px;
}
.footer {
    text-align: center;
    margin-top: 15px;
    font-size: 13px;
}
@media print {
    body { margin: 0; }
}
@media print {
    .no-print {
        display: none !important;
    }
}

</style>
</head>

<body>
    <h2>Karis Jaya Shop</h2>
    <p>Jl. Indonesia No.02, Kemangkon Purbalingga<br>Jawa Tengah</p>
    <p>No. Telp 0812345678</p>
    <hr>

    <table width="100%">
        <tr>
            <td><?= date('Y-m-d', strtotime($data['tanggal'])) ?></td>
            <td class="text-right"><?= date('H:i:s', strtotime($data['tanggal'])) ?></td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td class="text-right"><?= htmlspecialchars($data['username']) ?></td>
        </tr>
        <tr>
            <td>No.</td>
            <td class="text-right">#<?= $data['id_transaksi'] ?></td>
        </tr>
    </table>

    <hr>

    <table class="table">
        <tr>
            <td>1. <?= $data['nama_produk'] ?></td>
            <td class="text-right">Rp <?= number_format($data['harga_jual']) ?></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;<?= $data['jumlah'] ?> x <?= number_format($data['harga_jual']) ?></td>
            <td class="text-right">Rp <?= number_format($data['subtotal']) ?></td>
        </tr>
    </table>

    <hr>

    <table class="table">
        <tr>
            <td>Total QTY:</td>
            <td class="text-right"><?= $data['jumlah'] ?></td>
        </tr>
        <tr>
            <td>Sub Total</td>
            <td class="text-right">Rp <?= number_format($data['subtotal']) ?></td>
        </tr>
        <tr class="total">
            <td>Total</td>
            <td class="text-right">Rp <?= number_format($data['subtotal']) ?></td>
        </tr>
        <tr>
            <td>Bayar (Cash)</td>
            <td class="text-right">Rp <?= number_format($data['subtotal']) ?></td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">Rp 0</td>
        </tr>
    </table>

    <div class="footer">
        <p>Terimakasih Telah Berbelanja</p>
        <p>Barang yang sudah dibeli tidak dapat dikembalikan.</p>
        <p><?= date('d/m/Y H:i') ?></p>
    </div>
    <button class="no-print"><a href="data_transaksi.php">Kembali</a></button>

</body>
</html>
