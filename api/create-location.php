<?php
// Endpoint yang akan diakses
$url = 'https://api.biteship.com/v1/locations';

// Data yang akan dikirim melalui POST request
$data = array(
    'name' => 'Rumah',
    'contact_name' => 'Muh Syahrul Minanul Aziz',
    'contact_phone' => '081572323740',
    'address' => 'Jl. KH. Malawi, Kertasinduyasa, Kec. Jatibarang, Kabupaten Brebes, Jawa Tengah 52261',
    'note' => 'Pertigaan',
    'postal_code' => '52261',
    'latitude' => '-6.9623157',
    'longitude' => '109.0564449'
);

// Encode data menjadi JSON
$jsonData = json_encode($data);

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

// Set metode HTTP POST
curl_setopt($ch, CURLOPT_POST, 1);

// Set data yang akan dikirim melalui body request
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

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