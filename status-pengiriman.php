<?php
require 'config.php';

$order = mysqli_query($db, "SELECT * FROM order_list WHERE status IN ('Dikemas', 'Dikirim') ORDER BY id DESC");
if (mysqli_num_rows($order) == 0) {
    echo "Pesanan tidak ditemukan<br>";
} else {
    while($data_order = mysqli_fetch_array($order)) {
        
        $id = $data_order['id'];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.biteship.com/v1/trackings/' . $data_order['tracking_id']);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . configuration('web-key-biteship'),
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        print_r($result);
        
        if ($result['status'] == 'confirmed') {
            $status = 'Dikemas';
        } else if ($result['status'] == 'allocated') {
            $status = 'Dikemas';
        } else if ($result['status'] == 'pickingUp') {
            $status = 'Dikemas';
        } else if ($result['status'] == 'picked') {
            $status = 'Dikirim';
        } else if ($result['status'] == 'droppingOff') {
            $status = 'Dikirim';
        } else if ($result['status'] == 'returnInTransit') {
            $status = 'Dikirim';
        } else if ($result['status'] == 'onHold') {
            $status = 'Dikirim';
        } else if ($result['status'] == 'delivered') {
            $status = 'Selesai';
        } else if ($result['status'] == 'rejected') {
            $status = 'Dikembalikan';
        } else if ($result['status'] == 'courierNotFound') {
            $status = 'Dibatalkan';
        } else if ($result['status'] == 'returned') {
            $status = 'Dibatalkan';
        } else if ($result['status'] == 'cancelled') {
            $status = 'Dibatalkan';
        } else if ($result['status'] == 'disposed') {
            $status = 'Dibatalkan';
        } else {
            $status = 'Dikemas';
        }
        
        if ($result['status'] == true) {
            $update = $db->query("UPDATE order_list SET status = '$status', updated_at = '$datetime' WHERE id = '$id'");
            if ($update) {
                echo "Pesanan ID => <b>$id</b> Status => <b>$status</b><br>";
            } else {
                echo "Gagal Menampilkan Pesanan<br>";
            }
        }
    }
}
?>