<?php
session_start();
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];
    $_SESSION['nim'] = $nim;

    $url = "https://api-frontend.kemdikbud.go.id/hit_mhs/$nim";
    $headers = array(
        'Sec-Ch-Ua: "Not_A Brand";v="8", "Chromium";v="120"',
        'Accept: application/json, text/plain, */*',
        'Sec-Ch-Ua-Mobile: ?0',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.6099.216 Safari/537.36',
        'Sec-Ch-Ua-Platform: "Windows"',
        'Origin: https://pddikti.kemdikbud.go.id',
        'Sec-Fetch-Site: same-site',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Dest: empty',
        'Referer: https://pddikti.kemdikbud.go.id/',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: en-US,en;q=0.9',
        'Priority: u=1, i',
        'Connection: close',
    );

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);
    $data = json_decode($response, true);

    // Check if decoding was successful
    if ($data) {
        // Access the "text" value
        $mahasiswa = $data['mahasiswa'][0]['text'];

        // Extract name and university
        $matches = array();
        preg_match('/^(.*?)\(\d+\), PT : (.*?), Prodi: (.*?)$/', $mahasiswa, $matches);

        if (count($matches) >= 4) {
            $name = trim($matches[1]);
            $university = trim($matches[2]);
            $prodi = trim($matches[3]);

            $_SESSION['name'] = $name;
            $_SESSION['prodi'] = $prodi;
            $_SESSION['university'] = $university;

            echo "Name: $name<br>";
            echo "University: $university<br>";
            echo "Program Study: $prodi";

            if ($university == "UNIVERSITAS BINA BANGSA") {
                header("Location: presale.php?produk_id=1&nim=$nim");
                exit();
            }
        } else {
            header("Location: index.php");
        }
    } else {
        echo 'Failed to decode JSON response.';
    }
}
?>