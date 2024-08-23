<?php
// Endpoint yang akan diakses
$url = 'https://api.biteship.com/v1/rates/couriers';

// Data yang akan dikirim melalui POST request
$data = [
    // 'origin_area_id' => 'IDNP11IDNC402IDND4879IDZ61212',
    // 'destination_area_id' => 'IDNP10IDNC87IDND6968IDZ52261',
    // 'origin_latitude' => -7.4207162,
    // 'origin_longitude' => 112.7094401,
    // 'destination_latitude' => -6.9623157,
    // 'destination_longitude' => 109.0564449,
    'origin_postal_code' => 61252,
    'destination_postal_code' => 52261,
    // 'type' => 'origin_suggestion_to_closest_destination',
    'couriers' => 'jne,jnt,sicepat', // Ganti dengan nama kurir yang sesuai
    'items' => [
        [
            'name' => 'Kaos Klasik Kode', // Ganti dengan nama item Anda
            'description' => 'Klasik Kode Limited Edition', // Opsional
            'sku' => 'KK01', // Opsional
            'value' => 100000, // Ganti dengan nilai item Anda
            'quantity' => 1, // Jumlah item
            'weight' => 500, // Berat item dalam gram
            'height' => 10, // Tinggi item dalam cm (Opsional)
            'length' => 20, // Panjang item dalam cm (Opsional)
            'width' => 15 // Lebar item dalam cm (Opsional)
        ]
    ]
];

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