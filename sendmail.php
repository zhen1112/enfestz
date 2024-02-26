<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
if (!isset($_SESSION['order_id'])) {
    header("Location: index.php");
    exit();
}

// Include database connection
require 'koneksi.php';
$order_id = $_SESSION['order_id'];

// Fetch data from the 'order' table based on order_id
$query = "SELECT * FROM `order` WHERE id = $order_id";
$result = mysqli_query($conn, $query);

if ($result) {
    $orderData = mysqli_fetch_assoc($result);

    // Extracting relevant data from the orderData
    $nama = $orderData['nama'];
    $fakultas = $orderData['fakultas'];
    $jurusan = $orderData['jurusan'];
    $nim = $orderData['nim'];
    $jenisTiket = $orderData['jenis_tiket'];
    $reference = $orderData['reference'];
    $email = $orderData['email'];

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                         //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                //Enable SMTP authentication
        $mail->Username   = 'zhenagc@gmail.com';                 //SMTP username
        $mail->Password   = 'twriqpeygukaradr';                  //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable implicit TLS encryption
        $mail->Port       = 465;                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('marketin@enfest.elibnn.info', 'Konfirmasi Pembelian');
        $mail->addAddress($email, $nama);   
        //Content
        $mail->isHTML(true);                                     //Set email format to HTML
        $mail->Subject = 'Konfirmasi Pembelian tiket';
        $mail->Body = '<h1>Kode Invoice: ' . $reference . '</h1>
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
        <img src="dataqr/' . $nama . '.png" alt="qrcode" class="qrcod">';    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Error: Unable to fetch order details from the database.";
    exit();
}
?>
