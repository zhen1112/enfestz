<?php
require 'koneksi.php';
session_start();
if (isset($_GET['produk_id'])) {
  $_SESSION['produk_id'] = $_GET['produk_id'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-icons/11.4.0/simpleicons.svg">
<link rel="stylesheet" href="index.css">

<title>UNIBA ENFEST Z-EXPO 2024</title>
</head>
<body>
<div class="topnav" id="myTopnav">
  <a href="index.php" class="active">Home</a>
  <a href="#about">About</a>
  <a href="login.php" class="admin">Login</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<div class="carousel">
  <input type="radio" name="slider" id="slide1" checked>
  <div class="slide">
    <img src="images/banner1.jpg" alt="">
  </div>
  <input type="radio" name="slider" id="slide2">
  <div class="slide">
    <img src="images/banner2.jpg" alt="">
  </div>
  <input type="radio" name="slider" id="slide3">
  <div class="slide">
    <img src="images/banner3.jpg" alt="">
  </div>
  <button class="carousel-prev" onclick="changeSlide(-1)">&#10094;</button>
  <button class="carousel-next" onclick="changeSlide(1)">&#10095;</button>
</div>
<div class="head">
  <h2>ENTERPRENEUR FESTIVAL & EXPO-Z24</h2>
  <p>PILIH KATEGORI TIKET</p>
</div>
<hr>
<div class="uniba">
    <h1>SILAHKAN ISI NIM ANDA<a href="" onclick=silang()><i class="fa-solid fa-x" style="margin-left: 15px"></i></a></h1>
      <form id="formUniba"action="nim.php" method="get">
        <input type="text" name="nim" onclick="darkenBackground()" value="">
        <button type="submit">Submit</button>
      </form>
</div>
<div class="form-card">
  <?php
  $query = mysqli_query($conn, "SELECT * FROM tiket");
  while ($row = mysqli_fetch_array($query)) {
    $id = $row['produk_id'];
    $jenis = $row['jenis_tiket'];
    $harga = $row['harga_tiket'];
    $gambar = $row['gambar'];
  ?>
    <div class="product-card">
      <a href="form.php?produk_id=<?= $id ?>">
              <img src="images/<?= $gambar ?>" alt="<?= $jenis ?>">
            <div class="detil">
              <p class="jenis"><?= $jenis;?></p>
              <p>Rp<?= $harga ?></p>  
            </div>
      </a>
    </div>
  <?php
  }
  ?>
</div>
<hr class="hrdua">
<div class="ticket">
  <img src="images/ticket.png" alt="">
  <h1>ENTERPRENEUR FESTIVAL & EXPO-Z24</h1>
<div class="ticket-description">
    <div class="ticket-type">
      <h1>Pra Event:</h1>
    </div>
      <div class="ticket-details">
        <p> Tiket pra event merupakan tiket yang disediakan <b>EF'EX-Z24</b> khusus Mahasiswa Universitas Bina Bangsa. Silahkan Isi form ticket ini dengan menggunakan <b>Nomor Induk Mahasiswa Universitas Bina Bangsa Yang SAH!</b>. Gassken Mereun!</p>
      </div>
</div>
<div class="ticket-description">
    <div class="ticket-type"></div>
    <div class="ticket-details">
    </div>
</div>
<div class="ticket-description">
    <div class="ticket-type"></div>
    <div class="ticket-details">
    </div>
</div>
</div>
<footer>
  <div class="displayblok">
    <div class="sponsor-section">
      <div class="sponsor-info">
        <div class="item-sponsor">
        <img src="images/unx.png" alt="Logo Sponsor">
        <img src="images/unx.png" alt="Logo Sponsor">
        <img src="images/unx.png" alt="Logo Sponsor">
        </div>
      </div>
    </div>
    <div class="contact-section">
      <h3>Hubungi Kami</h3>
      <a href="https://wa.me/+6289654418863"><i class="fab fa-whatsapp"></i></a>
      <a href="https://instagram.com/efex_z24"><i class="fab fa-instagram"></i></a>
      <a href=""><i class="fab fa-facebook"></i></a>
      <p>Email: efexgenz24@gmail.com</p>
      <div class="email-input">
        <input type="email" placeholder="">
        <button>Kirim</button>
      </div>
    </div>
    </div>
  </footer>
<script>
  function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
      x.className += " responsive";
    } else {
      x.className = "topnav";
    }
  }
  document.addEventListener("DOMContentLoaded", function() {
    // Mengambil elemen dengan id "formUniba"
    const unibaForm = document.getElementById("formUniba");

    // Mengekstrak nilai ID dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const produkId = urlParams.get('produk_id');

    // Mengambil elemen dengan class "uniba"
    const unibaElement = document.querySelector(".uniba");

    // Mengambil semua tautan <a> di dalam elemen dengan class "product-card"
    const productLinks = document.querySelectorAll(".product-card a");

    // Menentukan kondisi apakah ID sesuai dengan yang diinginkan
    if (produkId === '1') {
      // Jika sesuai, tampilkan elemen dengan class "uniba"
      unibaElement.style.display = "flex";
    }
    productLinks.forEach(link => {
      link.addEventListener("click", function(event) {
        // Mengekstrak produk_id dari tautan
        const linkParams = new URLSearchParams(link.search);
        const linkProdukId = linkParams.get('produk_id');

        // Mencegah tindakan default (navigasi ke form.php) jika $id adalah 1
        if (linkProdukId === '1') {
          event.preventDefault();
          unibaElement.style.display = "flex";
        }
      });
    });
  });
</script>
<script>
        function darkenBackground() {
            document.body.classList.add('dark-background');
        }
</script>
<script>
     let currentIndex = 0;
  const slides = document.querySelectorAll('.slide');
  function changeSlide(offset) {
    currentIndex = (currentIndex + offset + slides.length) % slides.length;
    document.getElementById(`slide${currentIndex + 1}`).checked = true;
  }
</script>
</body>
</html>
