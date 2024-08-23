<?php
// Ganti dengan ID lokasi yang sesuai
$locationId = '66ae42648a1ba600117d2cef'; 

// Endpoint yang akan diakses
$url = 'https://api.biteship.com/v1/locations/' . $locationId;

// API key untuk otorisasi
$api_key = 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiU09VTE5JViIsInVzZXJJZCI6IjY2OWFkMjM1YzYzMTgwMDAxMmEwM2I4ZCIsImlhdCI6MTcyMjAyNzY5Nn0.rdVVVGyxz8RjX9PLqHFztZRHLiJtaKD_UwsYLWKwX-U';

// Set header untuk request
$headers = array(
    'Authorization: ' . $api_key,
    'Content-Type: application/json',
);

// Inisialisasi cURL
$ch = curl_init();

// Set URL endpoint yang akan diakses
curl_setopt($ch, CURLOPT_URL, $url);

// Agar hasil respons tidak langsung ditampilkan ke layar
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Set header yang akan dikirim
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

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