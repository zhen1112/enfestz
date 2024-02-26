<?php

?>
<style>
  .product-card{
    margin : 0 auto;
    width: 500px;
    height: 500px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
  }
  .image-container img{
    display: flex;
    width: 500px;
  }
</style>
<?php
/*$query = mysqli_query($conn, "SELECT * FROM tiket");
while ($row = mysqli_fetch_array($query)) {
  $id = $row['produk_id'];
  $jenis = $row['jenis_tiket'];
  $harga = $row['harga_tiket'];
  $gambar = $row['gambar'];
*/
?>
<div class="product-card">
  <a href="form.php?produk_id=<?= $id ?>">
    <div class="image-container">
      <img src="images/<?= $gambar ?>" alt="<?= $jenis ?>">
      <img src="images/presaleticket.jpg" alt="">
    </div>
    <div class="detil">
      <p class="jenis"><?= $jenis;?></p>
      <p>Rp<?= $harga ?></p>  
    </div>
  </a>
</div>
<?php
/*
}
*/
?>
