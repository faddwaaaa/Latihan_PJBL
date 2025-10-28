<?php
session_start();
require 'functions.php';

if (!isset($_SESSION['user_name'])) {
  header("Location: login.php");
  exit;
}

$db = new Fungsi();
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($db->koneksi, $_GET['keyword']) : '';
$query = "SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR harga_jual LIKE '%$keyword%' OR stok LIKE '%$keyword%' ORDER BY id_produk ASC";
$produk = $db->query($query);
$no = 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>User - Sistem Penjualan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .ascii-box {
      border: 2px dashed #6e8efb;
      border-radius: 10px;
      padding: 15px;
      background-color: #ffffff;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    .header-box {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }
    .logout-btn {
      background-color: #dc3545;
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      transition: 0.3s;
    }
    .logout-btn:hover {
      background-color: #b02a37;
    }
    .table-box {
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
    }
    table th {
      background-color: #e7e9ff;
    }
  </style>
</head>
<body>

<div class="container mt-4">
  <div class="ascii-box">
    <div class="header-box">
    <div>
        <h5 class="mb-0"><i class="fa-solid fa-book"></i> Sistem Penjualan</h5>
        <small>Kasir: <?= htmlspecialchars($_SESSION['user_name']); ?> &nbsp;&nbsp; | &nbsp;&nbsp; Tanggal: <?= date('d M Y'); ?></small>
    </div>
    <div>
        <a href="data_transaksi.php" class="btn btn-warning me-2">
            <i class="fa-solid fa-receipt"></i> Riwayat Transaksi
        </a>
        <a href="logout.php" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Keluar</a>
    </div>
  </div>

    <div class="mt-3 mb-3">
      <form class="d-flex" method="GET" action="">
        <label class="me-2"><i class="fa-solid fa-magnifying-glass"></i> Cari Produk:</label>
        <input type="text" name="keyword" class="form-control w-25" value="<?= htmlspecialchars($keyword); ?>">
        <button class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
    </div>

    <table class="table table-bordered table-striped table-box">
      <thead class="table-primary text-center">
        <tr>
          <th>No</th>
          <th>Nama Produk</th>
          <th>Harga Jual</th>
          <th>Stok</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($produk)): ?>
          <tr><td colspan="5" class="text-center text-muted">Tidak ada produk ditemukan</td></tr>
        <?php else: ?>
          <?php foreach ($produk as $p): ?>
            <tr class="text-center">
              <td><?= $no++; ?></td>
              <td class="text-start"><?= htmlspecialchars($p['nama_produk']); ?></td>
              <td>Rp<?= number_format($p['harga_jual'], 0, ',', '.'); ?></td>
              <td><?= $p['stok']; ?></td>
              <td>
                <a href="transaksi.php?id=<?= $p['id_produk']; ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-cart-shopping"></i> Jual </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
