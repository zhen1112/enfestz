<?php
require 'koneksi.php';
session_start();

if (isset($_GET['produk_id']) && isset($_GET['nim'])) {
    $produk_id = $_GET['produk_id'];
    $_SESSION['produk_id'] = $produk_id;
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
    $prodi = isset($_SESSION['prodi']) ? $_SESSION['prodi'] : '';
    $university = isset($_SESSION['university']) ? $_SESSION['university'] : '';
} else if (isset($_GET['produk_id'])){
    $produk_id = $_GET['produk_id'];
    $_SESSION['produk_id'] = $produk_id;
}else{
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
    </style>
    <title>Enfest Festival</title>
</head>

<body>
    
  <div class="kembali">
  <a href="kembali.php">Kembali</a>
  </div>
    <div class="container">
        <img src="images/prod1.jpg" alt="">
        <h2>Silahkan Isi Form Pembelian Tiket!</h2>
<form action="db.php" method="post">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM tiket WHERE produk_id = '$produk_id'");
            while ($rows = mysqli_fetch_array($query)) {
                $jenis = $rows['jenis_tiket'];
                $harga = $rows['harga_tiket'];
            ?>
<div class="form-group">
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama" placeholder="<?= $name; ?>" value="<?= $name; ?>" required>
</div>
<div class="form-group">
    <label for="fakultas">Fakultas:</label>
    <input type="text" id="fakultas" name="fakultas" placeholder="Fakultas" value="" required>
</div>
<div class="form-group">
    <label for="jurusan">Jurusan:</label>
    <input type="text" id="jurusan" name="jurusan" placeholder="<?= $prodi; ?>" value="<?= $prodi; ?>" required>
</div>
<div class="form-group">
    <label for="nim">NIM:</label>
    <input type="text" id="nim" name="nim" placeholder="<?= isset($_SESSION['nim']) ? $_SESSION['nim'] : ''; ?>" value="<?= isset($_SESSION['nim']) ? $_SESSION['nim'] : ''; ?>" required>
</div>
<div class="form-group">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
</div>
                <div class="details">
                    <div class="form-group">
                        <label for="jenis-tiket">Jenis Tiket: <?= $jenis ?></label>
                        <input type="hidden" id="jenis-tiket" name="jenis-tiket" value="<?= $jenis ?>">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga : Rp<?= $harga ?></label>
                        <input type="hidden" id="harga" name="harga" value="<?= $harga ?>">
                    </div>
                </div>
                <button type="submit">Bayar</button>
            <?php
            }
            ?>
        </form>
    </div>
    <div class="kon">
        <img src="images/prod2.jpg" alt="">
    </div>
</body>

</html>
