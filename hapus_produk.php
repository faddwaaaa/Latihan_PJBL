<?php
require 'functions.php';

$dbHapus = new Fungsi();

$id = $_GET['id'];

// jalankan fungsi hapus
if ($dbHapus->hapusProduk($id) > 0) {
    echo "
        <script>
            alert('Produk berhasil dihapus!');
            document.location.href = 'admin_produk.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Produk gagal dihapus!');
            document.location.href = 'admin_produk.php';
        </script>
    ";
}
?>
