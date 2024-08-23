<?php

// Endpoint yang akan diakses
$url = 'https://api.biteship.com/v1/locations';

// Data yang akan dikirim dalam format JSON
$data = json_encode(array(
    'name' => 'Apotik Gambir',
    'contact_name' => 'Ahmad',
    'contact_phone' => '08123456789',
    'address' => 'Jl. Gambir Selatan no 5. Blok F 92. Jakarta Pusat.',
    'note' => 'Dekat tulisan warung Bu Indah',
    'postal_code' => '10110',
    'latitude' => '-6.232123121',
    'longitude' => '102.22189911',
));

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

// Set metode HTTP POST
curl_setopt($ch, CURLOPT_POST, 1);

// Set data yang akan dikirim
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

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

// Tampilkan hasil respons dari server
echo $response;

?>
<?php

// Endpoint yang akan diakses
$url = 'https://api.biteship.com/v1/locations';

// Data yang akan dikirim dalam format JSON
$data = json_encode(array(
    'name' => 'Apotik Gambir',
    'contact_name' => 'Ahmad',
    'contact_phone' => '08123456789',
    'address' => 'Jl. Gambir Selatan no 5. Blok F 92. Jakarta Pusat.',
    'note' => 'Dekat tulisan warung Bu Indah',
    'postal_code' => '10110',
    'latitude' => '-6.232123121',
    'longitude' => '102.22189911',
));

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

// Set metode HTTP POST
curl_setopt($ch, CURLOPT_POST, 1);

// Set data yang akan dikirim
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

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

// Tampilkan hasil respons dari server
echo $response;

?>