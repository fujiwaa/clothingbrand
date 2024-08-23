<?php

// Data untuk dikirim dalam body request
$data = array(
    'shipper_contact_name' => 'John Doe',
    'shipper_contact_phone' => '123456789',
    'shipper_contact_email' => 'john.doe@example.com',
    'origin_contact_name' => 'Jane Smith',
    'origin_contact_phone' => '987654321',
    'origin_address' => '123 Main St, Cityville',
    'origin_postal_code' => '12345',
    'origin_coordinate' => array(
        'latitude' => 37.774929,
        'longitude' => -122.419418
    ),
    'destination_contact_name' => 'David Brown',
    'destination_contact_phone' => '555666777',
    'destination_address' => '456 Elm St, Townsville',
    'destination_postal_code' => '54321',
    'courier_company' => 'Example Courier',
    'courier_type' => 'Standard',
    'delivery_type' => 'now',
    'items' => array(
        array(
            'name' => 'Product A',
            'description' => 'Red T-shirt',
            'value' => 2000,
            'quantity' => 1,
            'weight' => 500,
            'height' => '',
            'length' => '',
            'width' => ''
        ),
        array(
            'name' => 'Product B',
            'value' => 3000,
            'quantity' => 2,
            'weight' => 700,
            'height' => 8,
            'length' => 25,
            'width' => 18
        )
    )
);

$api_key = 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiU09VTE5JViIsInVzZXJJZCI6IjY2OWFkMjM1YzYzMTgwMDAxMmEwM2I4ZCIsImlhdCI6MTcyMjAyNzY5Nn0.rdVVVGyxz8RjX9PLqHFztZRHLiJtaKD_UwsYLWKwX-U';
        
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.biteship.com/v1/orders');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: ' . $api_key,
    'Content-Type: application/json',
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$result = json_decode($response, true);
print_r($result);
?>