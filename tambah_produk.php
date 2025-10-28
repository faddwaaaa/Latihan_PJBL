<?php
require 'functions.php';
$dbTambah = new Fungsi();

// Ambil semua produk untuk dropdown
$produkList = $dbTambah->query("SELECT * FROM produk ORDER BY nama_produk ASC");

if (isset($_POST["simpan"])) {
    if ($dbTambah->tambahProduk($_POST) > 0) {
        echo "<script>
                alert('Produk berhasil ditambahkan!');
                document.location.href = 'admin_produk.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan produk!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="container py-5">

  <h3 class="mb-4"><i class="fa-solid fa-box"></i> Tambah Produk</h3>

  <form action="" method="POST" id="formProduk">
    <div class="mb-3">
      <label class="form-label">Pilih Produk</label>
      <select name="id_produk" id="id_produk" class="form-select" required>
        <option value="">-- Pilih Produk --</option>
        <?php foreach ($produkList as $p): ?>
          <option value="<?= $p['id_produk']; ?>"><?= htmlspecialchars($p['nama_produk']); ?></option>
        <?php endforeach; ?>
        <option value="baru">+ Tambah Produk Baru</option>
      </select>
    </div>

    <div class="mb-3" id="namaBaru" style="display:none;">
      <label class="form-label">Nama Produk Baru</label>
      <input type="text" name="nama_produk" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Stok</label>
      <input type="number" name="stok" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Harga Beli</label>
      <input type="number" name="harga_beli" id="harga_beli" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Harga Jual</label>
      <input type="number" name="harga_jual" id="harga_jual" class="form-control">
    </div>

    <a href="admin_produk.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></a>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const selectProduk = document.getElementById('id_produk');
    const namaBaru = document.getElementById('namaBaru');
    const hargaBeli = document.getElementById('harga_beli');
    const hargaJual = document.getElementById('harga_jual');

    selectProduk.addEventListener('change', function() {
      const id = this.value;

      if (id === 'baru') {
        namaBaru.style.display = 'block';
        hargaBeli.value = '';
        hargaJual.value = '';
        return;
      } else {
        namaBaru.style.display = 'none';
      }

      if (id) {
        fetch(`get_produk.php?id=${id}`)
          .then(response => response.json())
          .then(data => {
            if (data) {
              hargaBeli.value = data.harga_beli;
              hargaJual.value = data.harga_jual;
            }
          })
          .catch(err => console.error(err));
      }
    });
  </script>
</body>
</html>
