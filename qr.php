<?php
session_start();
if (!isset($_SESSION['order_id'])) {
    header("Location: index.php");
    exit();
}

// Include database connection
require 'koneksi.php';
include 'sendmail.php';

// Retrieve order_id from the session
$order_id = $_SESSION['order_id'];

function encryptData($data, $key) {
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivSize);
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted);
}

// Dekripsi fungsi
function decryptData($data, $key) {
    $data = base64_decode($data);
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $ivSize);
    $encrypted = substr($data, $ivSize);
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

$query = "SELECT * FROM `order` where `id` = '$order_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $orderData = mysqli_fetch_assoc($result);
    $nama = $orderData['nama'];
    $data = $orderData['jenis_tiket'] . ' ' . $orderData['nama'] . ' ' . $orderData['fakultas'] . ' ' . $orderData['jurusan'] . ' ' . $orderData['nim'];
    $key = 'UNIBAENFEST2024';
    $encrypted = encryptData($data, $key);
    
    // Generate QR code
    function generateQRCode($encrypted, $size = 200)
    {
        $url = "https://chart.googleapis.com/chart?chs={$size}x{$size}&cht=qr&chl=" . urlencode($encrypted);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    // Combine form data into a single string
    $qrData = $encrypted;

    // Generate QR code
    $qrCode = generateQRCode($qrData);

    // Save the QR code as an image file
    $folder = 'dataqr/'; // Nama folder
    $encryptedFilename = md5($encrypted) . '.png';
    $filepath = $folder . $encryptedFilename;

    
    // Simpan gambar QR Code
    file_put_contents($folder . $encryptedFilename, $qrCode);

    // Insert encrypted data into encrypted_data table
    $insertQuery = "INSERT INTO encrypted_data (data, qr) VALUES ('$encrypted', '$encryptedFilename')";
    if (!mysqli_query($conn, $insertQuery)) {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        exit();
    }  
} else {
    echo "Error: Unable to fetch order details from the database.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="invoice.css">
    <title>QR Code Generator</title>
</head>
<body>
    <div class="intro">
    <h1>TERIMAKASIH PEMABAYARAN SUDAH DI TERIMA</h1>
    </div>
    <div class="isian">
    <form id="myForm" action="destroy.php" method="post">
    <img src="images/banner.jpg" alt="" class="banner">
    <h1>Kode Invoice: <?= $reference;?></h1>
    <p class="decor">Silahkan Simpan Qr Code untuk di scan saat memasuki acara</p>
    <p>Tata Cara Pengambilan Tiket:</p>
    <div class="container">
    <ol>
    <li>Datang Ke lokasi pengambilan tiket membawa bukti pembayaran/QR code yang sudah di beli di website</li>
    <li>Petugas acara akan memindai QR code peserta menggunakan perangkat pemindai QR code atau aplikasi khusus. Pemindaian ini akan memverifikasi keabsahan tiket dan konfirmasi pendaftaran.</li>
    
    <li>Jika QR code valid, peserta akan mendapatkan verifikasi dan diizinkan untuk masuk ke dalam acara. Jika QR code tidak valid atau telah digunakan sebelumnya, peserta mungkin akan diarahkan untuk mendapatkan bantuan dari petugas penyelenggara acara.</li>
    
    <li>Setelah memasuki acara, peserta dapat menikmati kegiatan dan program yang diselenggarakan.</li>
    </ol>

    </div>
    <img src="data:image/png;base64,<?php echo base64_encode($qrCode); ?>" alt="qrcode" >
    <button type="submit" name="destroy_session">Kembali</button>
    </form>
    </div>
</body>
</html>
