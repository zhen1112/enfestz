<?php
session_start();
if (isset($_SESSION['order_id'])) {
    $apiKey = 'mchm9w4EYRgRZv6rMzViNAjcm5kw2GA4I2F1MGSn';
    // Retrieve order_id from the session
    $order_id = $_GET['tripay_reference'];
    // Include database connection
    require 'koneksi.php';

    // Fetch data from the 'order' table based on order_id
    
    $query = "SELECT * FROM `order` WHERE reference = '$order_id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $orderData = mysqli_fetch_assoc($result);

        // Extracting relevant data from the orderData
        $reference = $orderData['reference'];

        // Perform API request to get transaction details
        $payload = ['reference' => $reference];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api/transaction/detail?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($response === false) {
            echo "Curl error: " . $error;
        } else {
            $responseArray = json_decode($response, true);

            if (isset($responseArray['success']) && $responseArray['success'] == true) {
                $status = $responseArray['data']['status'];
                if ($status == 'UNPAID') {
                    $checkoutUrl = $responseArray['data']['checkout_url'];

                    echo "<script>
                        setTimeout(function() { 
                            alert('Pembelian anda belum di bayar, beralih ke pembayaran..');
                        }, 5000);
                        window.location.href = 'http://localhost/tiket/qr.php';
                    </script>";
                } else {
                    echo "<script>window.location.href = $checkoutUrl;</script>";
                }
            } else {
                echo $response;
            }
        }
    } else {
        echo "Query error: " . mysqli_error($conn);
    }
}
?>
