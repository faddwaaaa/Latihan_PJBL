<?php
require 'functions.php';
session_start();

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new Fungsi();
$id_user = $_SESSION['user_id'];

// Ambil semua transaksi user + join nama produk
$query = "
    SELECT 
        t.id_transaksi,
        p.nama_produk,
        t.jumlah,
        t.harga_jual,
        t.subtotal,
        t.keuntungan,
        t.tanggal
    FROM transaksi AS t
    INNER JOIN produk AS p ON p.id_produk = t.id_produk
    WHERE t.id_user = '$id_user'
    ORDER BY t.tanggal DESC
";

$transaksi = $db->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th { background: #198754; color: #fff; }
    </style>
</head>

<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📊 Data Transaksi Penjualan</h3>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>

    <a href="user_produk.php" class="btn btn-primary mb-3">Jual Produk</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Jual</th>
                <th>Subtotal</th>
                <th>Keuntungan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($transaksi as $t) { ?>
                <tr>
                    <td class='text-center'><?= $no++ ?></td>
                    <td><?= $t['nama_produk'] ?></td>
                    <td class='text-center'><?= $t['jumlah'] ?></td>
                    <td class='text-center'>Rp <?= number_format($t['harga_jual']) ?></td>
                    <td class='text-center'>Rp <?= number_format($t['subtotal']) ?></td>
                    <td class='text-success fw-bold text-center'>Rp <?= number_format($t['keuntungan']) ?></td>
                    <td class='text-center'><?= date('d-m-Y H:i', strtotime($t['tanggal'])) ?></td>
                </tr>

            <?php
            }
            // Kalau kosong
            if (empty($transaksi)) {
                echo "<tr><td colspan='7' class='text-center text-muted'>Belum ada transaksi</td></tr>";
            }
            ?>
        </tbody>
    </table>

</div>
</body>
</html>
