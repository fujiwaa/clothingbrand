<?php
// Ganti dengan ID tracking yang sesuai
$trackingId = 'atfmiyCEkm9NyKnk9AfM4MpX'; 

// Endpoint yang akan diakses
$url = 'https://api.biteship.com/v1/trackings/' . $trackingId;

// API key untuk otorisasi
$api_key = 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiU09VTE5JViIsInVzZXJJZCI6IjY2OWFkMjM1YzYzMTgwMDAxMmEwM2I4ZCIsImlhdCI6MTcyMTY0Mzc0NX0.b3grHp9Ep0vWR7rp1_3BC97_6uYOdigopQUvvUh6j0k';

// Set header untuk request
$headers = array(
    'Authorization: ' . $api_key,
    'Content-Type: application/json',
);

// Inisialisasi cURL
$ch = curl_init();

// Set URL endpoint yang akan diakses
curl_setopt($ch, CURLOPT_URL, $url);

// Set metode HTTP GET
curl_setopt($ch, CURLOPT_HTTPGET, 1);

// Set header yang akan dikirim
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Agar hasil respons tidak langsung ditampilkan ke layar
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Eksekusi cURL dan simpan hasil respons
$response = curl_exec($ch);

// Cek apakah ada error dalam proses cURL
if(curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

// Tutup cURL
curl_close($ch);

$result = json_decode($response, true);

// Tampilkan hasil respons dari server
print_r($result);