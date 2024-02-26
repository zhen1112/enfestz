<?php
function decryptData($data, $key) {
    $data = base64_decode($data);
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $ivSize);
    $encrypted = substr($data, $ivSize);
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

$key = 'UNIBAENFEST2024'; // Kunci yang sama yang digunakan untuk enkripsi
$datanya = trim(fgets(STDIN));
$encryptedData = $datanya;
$decryptedData = decryptData($encryptedData, $key);
echo $decryptedData;
?>
