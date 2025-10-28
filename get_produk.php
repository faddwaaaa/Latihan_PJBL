<?php
require 'functions.php';
$db = new Fungsi();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $produk = $db->getProdukById($id);

    if ($produk) {
        echo json_encode($produk);
    } else {
        echo json_encode(null);
    }
}
?>
