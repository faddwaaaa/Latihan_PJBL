<?php
class Fungsi {
    public $koneksi;

    public function __construct($host="localhost", $user="root", $pass="", $db="penjualan_db") {
        $this->koneksi = mysqli_connect($host, $user, $pass, $db);
    }

    // function query
    public function query($query){
        $result = mysqli_query($this->koneksi, $query);

        if (stripos($query, 'SELECT') === 0) {
            $rows = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            return $rows;
        }

        return $result; // untuk INSERT, UPDATE, DELETE
    }



    // Login
    public function loginUser($username, $password) {
        $username = mysqli_real_escape_string($this->koneksi, $username);
        $password = md5(mysqli_real_escape_string($this->koneksi, $password));
        
        $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        $result = mysqli_query($this->koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }

    // Create
    public function tambahProduk($data) {
        $id_produk = $data['id_produk'];
        $stok = (int)$data['stok'];
        $harga_beli = isset($data['harga_beli']) ? (int)$data['harga_beli'] : 0;
        $harga_jual = isset($data['harga_jual']) ? (int)$data['harga_jual'] : 0;

        // Jika produk baru
        if ($id_produk === 'baru') {
            $nama = htmlspecialchars($data['nama_produk']);
            $query = "INSERT INTO produk (nama_produk, stok, harga_beli, harga_jual)
                    VALUES ('$nama', '$stok', '$harga_beli', '$harga_jual')";
            mysqli_query($this->koneksi, $query);
        } 
        // Jika produk sudah ada → update stok
        else {
            $query = "UPDATE produk 
                    SET stok = stok + $stok,
                        harga_beli = '$harga_beli',
                        harga_jual = '$harga_jual'
                    WHERE id_produk = '$id_produk'";
            mysqli_query($this->koneksi, $query);
        }

        return mysqli_affected_rows($this->koneksi);
    }


    // Read
    public function getAllProduk() {
        return $this->query("SELECT * FROM produk ORDER BY id_produk DESC");
    }

    public function getProdukById($id) {
        $result = $this->query("SELECT * FROM produk WHERE id_produk = $id");
        return $result ? $result[0] : null;
    }

    // Update
    public function editProduk($data) {
        $id = $data['id_produk'];
        $nama = htmlspecialchars($data['nama_produk']);
        $stok = $data['stok'];
        $harga_beli = $data['harga_beli'];
        $harga_jual = $data['harga_jual'];

        $query = "UPDATE produk SET 
                    nama_produk = '$nama',
                    stok = '$stok',
                    harga_beli = '$harga_beli',
                    harga_jual = '$harga_jual'
                  WHERE id_produk = $id";

        mysqli_query($this->koneksi, $query);
        return mysqli_affected_rows($this->koneksi);
    }

    // Delete
    public function hapusProduk($id) {
        $query = "DELETE FROM produk WHERE id_produk = $id";
        mysqli_query($this->koneksi, $query);
        return mysqli_affected_rows($this->koneksi);
    }

    // Cari Produk
    public function cariProduk($keyword) {
        $keyword = mysqli_real_escape_string($this->koneksi, $keyword);
        $query = "SELECT * FROM produk 
                WHERE nama_produk LIKE '%$keyword%'
                OR harga_beli LIKE '%$keyword%'
                OR harga_jual LIKE '%$keyword%'
                OR stok LIKE '%$keyword%'";
                
        $result = mysqli_query($this->koneksi, $query);
        return $result;
    }
    

    // Laporan Transaksi
    public function getAllTransaksi() {
        $query = "SELECT t.*, p.nama_produk, u.username 
                  FROM transaksi t
                  JOIN produk p ON t.id_produk = p.id_produk
                  JOIN user u ON t.id_user = u.id_user
                  ORDER BY t.tanggal DESC";
        return $this->query($query);
    }
}
?>
