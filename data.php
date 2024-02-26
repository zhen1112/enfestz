<?php
session_start();

$jenis_tiket = '';
$harga = '';
$gambar = '';
$nama = '';
$produk_id = '';

if (isset($_GET['produk_id'])) {
    $produk_id = $_GET['produk_id'];
    $_SESSION['produk_id'] = $produk_id;
    require 'koneksi.php';
    $query = mysqli_query($conn, "SELECT * FROM tiket WHERE produk_id = '$produk_id'");

    while ($rows = mysqli_fetch_array($query)) {
        $jenis_tiket = $rows['jenis_tiket'];
        $harga = $rows['harga_tiket'];
        $gambar = $rows['gambar'];
    }

    // Store form data in a session variable named 'form_data'
    $_SESSION['form_data'] = [
        'nama'        => $_POST['nama'],
        'fakultas'    => $_POST['fakultas'],
        'jurusan'     => $_POST['jurusan'],
        'nim'         => $_POST['nim'],
        'jenis-tiket' => $_POST['jenis-tiket'],
        'harga'       => $_POST['harga']
    ];
} elseif (isset($_SESSION['produk_id'])) {
    $produk_id = $_SESSION['produk_id'];
    require 'koneksi.php';
    $query = mysqli_query($conn, "SELECT * FROM tiket WHERE produk_id = '$produk_id'");
    
    while ($rows = mysqli_fetch_array($query)) {
        $jenis_tiket = $rows['jenis_tiket'];
        $harga = $rows['harga_tiket'];
        $gambar = $rows['gambar'];
        $nama = $_POST['nama'];
    }
    $_SESSION['form_data'] = [
        'jenis_tiket' => $jenis_tiket,
        'harga'       => $harga,
        'gambar'      => $gambar,
        'nama'        => $nama,
        'produk_id'   => $produk_id,
    ];
}

$apiKey       = 'mchm9w4EYRgRZv6rMzViNAjcm5kw2GA4I2F1MGSn';
$privateKey   = '4Mwii-1X2nx-MBngP-1zqDO-TcTSA';
$merchantCode = 'T28993';

// Retrieve form data from the session
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$merchantRef  = 'TIKET'.$form_data['jenis_tiket'].'';
$amount       = $form_data['harga'];
$nama         = isset($_POST['nama']) ? $_POST['nama'] : '';

$data = [
    'method'         => 'QRIS',
    'merchant_ref'   => $merchantRef,
    'amount'         => $amount,
    'customer_name'  => $nama,
    'customer_email' => 'emailpelanggan@domain.com',
    'customer_phone' => '081234567890',
    'order_items'    => [
        [
            'sku'         => $form_data['jenis_tiket'],
            'name'        => $form_data['jenis_tiket'],
            'price'       => $amount,
            'quantity'    => 1,
            'product_url' => 'https://www.enfest.elibnn.info/form.php?'.$form_data['produk_id'].'',
            'image_url'   => 'https://www.enfest.elibnn.info/images/'.$form_data['gambar'].'',
        ]
    ],
    'return_url'   => 'http://localhost/tiket/check.php',
    'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
    'signature'    => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_FRESH_CONNECT  => true,
    CURLOPT_URL            => 'https://tripay.co.id/api/transaction/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER         => false,
    CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
    CURLOPT_FAILONERROR    => false,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query($data),
    CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
]);

$response = curl_exec($curl);
$error = curl_error($curl);
curl_close($curl);

$responseArray = json_decode($response, true);

if ($responseArray && isset($responseArray['success']) && $responseArray['success'] === true) {
    $checkoutUrl = $responseArray['data']['checkout_url'];
    $reference = $responseArray['data']['reference'];

    // Store reference in a session variable named 'reference'
    $_SESSION['reference'] = $reference;

    echo "Checkout URL: $checkoutUrl";

    // Redirect the user to the checkout URL
    header("Location: $checkoutUrl");
    exit();
} else {
    echo "Error: Unable to retrieve checkout URL from the response.";
}
?>