<?php
require 'config.php';

$privateKey = 'sJhwJ-0FEcR-I8Xqm-TqOBY-Uu7OO';

$json = file_get_contents('php://input');
$callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';

if ($callbackSignature !== hash_hmac('sha256', $json, $privateKey)) {
    echo "Sistem Sedang Error";
} else if ('payment_status' !== $_SERVER['HTTP_X_CALLBACK_EVENT']) {
    echo "Sistem Sedang Error";
} else {
    $data = json_decode($json, true);
    
    if ($data) {
        if (is_array($data)) {
            $id = $data['merchant_ref'];
            
            if ($data['status'] === 'PAID') {
                $items = array();
                $data_order = null;
                
                $cek_order = $db->query("SELECT * FROM order_list WHERE order_id = '$id' ORDER BY id DESC");
                while ($row = mysqli_fetch_array($cek_order)) {
                    if ($data_order === null) {
                        $data_order = $row;
                    }
                
                    $items[] = array(
                        'name' => $row['product_name'],
                        'description' => '',
                        'sku' => '',
                        'value' => $row['price'],
                        'quantity' => $row['quantity'],
                        'weight' => 500,
                        'height' => '',
                        'length' => '',
                        'width' => ''
                    );
                }
                
                if ($data_order !== null) {
                    $user_id = $data_order['user_id'];
                    $shipping = $data_order['expedition'];
                    $shipping_type = $data_order['expedition_type'];
                }
                
                $cek_address = $db->query("SELECT * FROM address WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1");
                $data_address = mysqli_fetch_array($cek_address);
                
                $data_shipping = array(
                    'shipper_contact_name' => '',
                    'shipper_contact_phone' => '',
                    'shipper_contact_email' => '',
                    'origin_contact_name' => configuration('web-sender'),
                    'origin_contact_phone' => configuration('web-phone'),
                    'origin_address' => configuration('web-address'),
                    'origin_postal_code' => configuration('web-postal-code'),
                    'destination_contact_name' => $data_address['full_name'],
                    'destination_contact_phone' => $data_address['phone'],
                    'destination_address' => $data_address['address'] . ', ' . $data_address['city'],
                    'destination_postal_code' => $data_address['postal_code'],
                    'courier_company' => $shipping,
                    'courier_type' => $shipping_type,
                    'delivery_type' => 'now',
                    'items' => $items
                );
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.biteship.com/v1/orders');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_shipping));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: ' . configuration('web-key-biteship'),
                    'Content-Type: application/json',
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $result_shipping = json_decode($response, true);
                
                if ($result_shipping['success'] == true) {
                    $tracking_id = $result_shipping['courier']['tracking_id'];
                    $receipt = $result_shipping['courier']['waybill_id'];
                    
                    $db->query("UPDATE order_list SET status = 'Dikemas', tracking_id = '$tracking_id', receipt = '$receipt', updated_at = '$datetime' WHERE order_id = '$id'");
                } else {
                    $db->query("UPDATE order_list SET status = 'Lunas', updated_at = '$datetime' WHERE order_id = '$id'");
                }
            } else if ($data['status'] === 'EXPIRED') {
                $db->query("UPDATE order_list SET status = 'Dibatalkan', updated_at = '$datetime' WHERE order_id = '$id'");
            } else {
                $db->query("UPDATE order_list SET status = 'Belum dibayar', updated_at = '$datetime' WHERE order_id = '$id'");
            }
        }
    }
}
?>