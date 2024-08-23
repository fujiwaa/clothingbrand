<?php
session_start();
require '../config.php';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);
    
    if (isset($_GET['id'])) {
        $order_id = $_GET['id'];
        
        $cek_order = $db->query("SELECT * FROM order_list WHERE id = '$order_id'");
        $data_order = mysqli_fetch_assoc($cek_order);
        
        if ($data_order['tracking_id']) {
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
        } else {
            $result = '';
        }
?>

                <?php if (!$data_order['tracking_id']) { ?>
                
                <div class="modal-header d-flex justify-content-around border-bottom-0">
                    <span>
                        <a href="#" class="text-decoration-none text-dark" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark fs-4"></i></a>
                    </span>
                    <span class="fw-bold text-center fs-4">Lacak Pesanan</span>
                    <span>
                        <a href="#" class="text-decoration-none text-dark" data-bs-dismiss="modal" aria-label="Close"></i></a>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="card mb-5 px-2 rounded-4 shadow">
                        <div class="card-body d-flex justify-content-between justify-content-center align-items-center gap-3">
                            <img src="<?= $web_baseurl; ?>assets/images/product/<?php echo $data_order['product_image']; ?>" width="96" height="96" alt="">
                            <div class="vstack">
                                <span class="fw-semibold"><?php echo $data_order['product_name']; ?></span>
                                <span>Dikirim dengan <?php echo $data_order['expedition']; ?></span>
                                <span>Estimasi diterima paling lambat <span class="text-primary"><?php echo format_date(date('Y-m-d H:i:s', strtotime($data_order['created_at'].' + 5 days'))); ?></span></span>
                            </div>
                            <span class="text-secondary">NO. Resi : <?php echo $data_order['receipt']; ?></span>
                        </div>
                    </div>
                                    
                    <!-- Tracking History -->
                    <div id="tracking" class="px-3 pb-3">
                        <p>Riwayat pelacakan tidak tersedia.</p>
                    </div>
                </div>
                <?php } else { ?>
                
                <div class="modal-header d-flex justify-content-around border-bottom-0">
                    <span>
                        <a href="#" class="text-decoration-none text-dark" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark fs-4"></i></a>
                    </span>
                    <span class="fw-bold text-center fs-4">Lacak Pesanan</span>
                    <span>
                        <a href="#" class="text-decoration-none text-dark" data-bs-dismiss="modal" aria-label="Close"></i></a>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="card mb-5 px-2 rounded-4 shadow">
                        <div class="card-body d-flex justify-content-between justify-content-center align-items-center gap-3">
                            <img src="<?= $web_baseurl; ?>assets/images/product/<?php echo $data_order['product_image']; ?>" width="96" height="96" alt="">
                            <div class="vstack">
                                <span class="fw-semibold"><?php echo $data_order['product_name']; ?></span>
                                <span>Dikirim dengan <?php echo $data_order['expedition']; ?></span>
                                <span>Estimasi diterima paling lambat <span class="text-primary"><?php echo format_date(date('Y-m-d H:i:s', strtotime($data_order['created_at'].' + 5 days'))); ?></span></span>
                            </div>
                            <span class="text-secondary">NO. Resi : <?php echo $data_order['receipt']; ?></span>
                        </div>
                    </div>
                                    
                    <!-- Tracking History -->
                    <div id="tracking" class="px-3 pb-3">
                        <?php if ($result['success'] && isset($result['history']) && !empty($result['history'])): ?>
                            <?php foreach ($result['history'] as $index => $event): ?>
                                <div class="ps-4 pb-2 border-start border-3 border-secondary position-relative">
                                    <div class="circle bg-secondary position-absolute" style="width: 10px; height: 10px; border-radius: 50%; top:0; left: -6px"></div>
                                    <span class="fw-semibold d-block"><?php echo htmlspecialchars($event['note']); ?></span>
                                    <small class="text-primary"><?php echo format_date_resi($event['updated_at']); ?></small>
                                    <?php if ($index === count($result['history']) - 1): ?>
                                        <div class="circle bg-secondary position-absolute" style="width: 10px; height: 10px; border-radius: 50%; bottom: 0; left: -6px"></div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                        <?php else: ?>
                            <p>Riwayat pelacakan tidak tersedia.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php } ?>
<?php
    } else {
        header("Location: ".$web_baseurl."profile");
    }
} else {
    header("Location: ".$web_baseurl."profile");
}
?>