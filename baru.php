<?php
include "koneksi.php";
session_start();
if (isset($_GET['produk_id'])) {
  $_SESSION['produk_id'] = $_GET['produk_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="baru.css">
    <title>Document</title>
</head>
<body>
    <div class="atas">
        <a href="">Tentang enfest</a>
        <a href="">Hubungi Kami</a>
        <a href="">ikut jadi panitia</a>
    </div>
    <div class="top-nav">
        <img src="images/logo.png" alt="" class="logo">
        <form class="example" action="/action_page.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
        <a href="" class="bar"><i class="fa fa-bars"></i></a>
        <div class="isi">
            <img src="images/compass.png" alt="">
            <a href="" class="acara">#acara</a>
            <img src="images/calendar.png" alt="">
            <a href="" class="acara">#tanggal</a>
        </div>
        <div class="logreg">
            <a href="" class="login">Login</a>
            <a href="" class="daftar">Daftar</a>
        </div>
    </div>
    <div class="smartphone">
        <h1>Masuk Ke Akunmu</h1>
        <p>Untuk menggunakan semua fitur di loket</p>
        <a href="" class="daftar">Daftar</a>
        <a href="" class="masuk">Masuk</a>
    </div>
    <div class="carousel">
        <input type="radio" name="slider" id="slide1" checked>
        <div class="slide">
            <img src="images/band2.jpg" alt="">
        </div>

        <input type="radio" name="slider" id="slide2">
        <div class="slide">
            <img src="images/ban1.jpg" alt="">
        </div>

        <input type="radio" name="slider" id="slide3">
        <div class="slide">
            <img src="images/prod1.jpg" alt="">
        </div>

        <button class="carousel-prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="carousel-next" onclick="changeSlide(1)">&#10095;</button>
    </div>

    <?php
    $query = mysqli_query($conn, "SELECT * FROM tiket");
    while ($row = mysqli_fetch_array($query)) {
        $jenis = $row['jenis_tiket'];
        $harga = $row['harga_tiket'];
        $gambar = $row['gambar'];
    ?>
    <div class="carousel">
        <div class="produk">
            <h1>Event Pilihan</h1>
            <a href="form.php?produk_id=<?= $row['id']; ?>">
                <img src="images/<?= $gambar; ?>" alt="<?= $jenis; ?>">
                <p><?= $jenis; ?></p>
                <p>Rp<?= $harga; ?></p>
            </a>
        </div>
    </div>
    <?php
    }
    ?>

    <script>
        let currentIndex = 0;
        const slides = document.querySelectorAll('.slide');

        function changeSlide(offset) {
            currentIndex = (currentIndex + offset + slides.length) % slides.length;
            document.getElementById(`slide${currentIndex + 1}`).checked = true;
        }
    </script>

    <script>
        let currentIndex = 0;
        const produkItems = document.querySelectorAll('.produk');
        const totalItems = produkItems.length;

        function changeSlide(direction) {
            currentIndex = (currentIndex + direction + totalItems) % totalItems;
            updateCarousel();
        }

        function updateCarousel() {
            const newTransformValue = -currentIndex * 100 + '%';
            document.querySelector('.carousel').style.transform = 'translateX(' + newTransformValue + ')';
        }

        // Anda mungkin perlu menambahkan event listener atau metode lainnya untuk memanggil changeSlide() pada klik tombol atau interval waktu.
    </script>
</body>
</html>
