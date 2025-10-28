<?php
session_start();
require 'functions.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_type'])) {
  header("Location: login.php");
  exit;
}

$dbTampil = new Fungsi();
if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
    $keyword = mysqli_real_escape_string($dbTampil->koneksi, $_GET['keyword']);
    $produk = $dbTampil->query("SELECT * FROM produk 
                                WHERE nama_produk LIKE '%$keyword%' 
                                OR harga_beli LIKE '%$keyword%' 
                                OR harga_jual LIKE '%$keyword%' 
                                OR stok LIKE '%$keyword%' 
                                ORDER BY id_produk ASC");
} else {
    $produk = $dbTampil->query("SELECT * FROM produk ORDER BY id_produk ASC");
}

$no = 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Data Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-light">

  <div class="container mt-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Data Produk</h2>
      <div class="d-flex align-items-center">
        <span class="me-3 text-secondary">
          Halo, <b><?= htmlspecialchars($_SESSION['user_name']); ?></b>
        </span>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
      </div>
    </div>

    <!-- Pencarian & Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <form class="d-flex me-2" method="GET" action="">
        <input class="form-control me-2" type="search" name="keyword" placeholder="Cari produk..." 
               value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
        <button class="btn btn-outline-success" type="submit">Cari</button>
      </form>
      <a href="tambah_produk.php" class="btn btn-primary">+ Tambah Produk</a>
    </div>

    <!-- Tabel Produk -->
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead class="table-primary text-center">
            <tr>
              <th>No</th>
              <th>Nama Produk</th>
              <th>Harga Beli</th>
              <th>Harga Jual</th>
              <th>Stok</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($produk)): ?>
              <tr>
                <td colspan="6" class="text-center text-muted">Belum ada produk</td>
              </tr>
            <?php else: ?>
              <?php foreach ($produk as $row): ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                  <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.'); ?></td>
                  <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                  <td class="text-center"><?= $row['stok']; ?></td>
                  <td class="text-center">
                    <a href="edit_produk.php?id=<?= $row['id_produk']; ?>" class="btn btn-warning btn-sm">
                      <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <a href="hapus_produk.php?id=<?= $row['id_produk']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Yakin ingin menghapus produk ini?');">
                      <i class="fa-solid fa-trash"></i> Hapus
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
