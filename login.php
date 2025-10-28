<?php
session_start();
require 'functions.php';

$db = new Fungsi();

// jika sudah login arahkan
if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == 'admin') {
        header("Location: admin_produk.php");
        exit;
    } elseif ($_SESSION['user_type'] == 'user') {
        header("Location: user_produk.php");
        exit;
    }
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $db->loginUser($username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_name'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type'];

        if ($user['user_type'] == 'admin') {
            header("Location: admin_produk.php");
        } else {
            header("Location: user_produk.php");
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Sistem Penjualan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

  <div class="card shadow-lg p-4" style="width: 360px;">
    <h4 class="text-center mb-3 text-primary"><i class="fa fa-briefcase"></i> Login Sistem Penjualan</h4>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger py-2"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username..." required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>

  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
