<?php
session_start();
require '../config.php';
$title = 'Beli Sekarang';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);
    
    $cek_address = $db->query("SELECT * FROM address WHERE user_id = '$id' ORDER BY id DESC LIMIT 1");
    $data_address = mysqli_fetch_array($cek_address);
    
    if (isset($_SESSION['buyNow']) && !empty($_SESSION['buyNow'])) {
        $product = $_SESSION['buyNow'];
        
        if (isset($_POST['buy'])) {
            $order_id = generateRandomNumber();
            $product_id = $product['id'];
            $product_image = $product['image'];
            $product_name = $product['name'];
            $product_category = $product['category'];
            $size = $product['size'];
            $quantity = $product['quantity'];
            $price_per_item = $product['price'];
            $price = $price_per_item * $quantity;
            $payment = $_POST['payment'];
            $shipping = explode(',', $_POST['shipping'])[0];
            $shipping_type = explode(',', $_POST['shipping'])[1];
            $shipping_price = explode(',', $_POST['shipping'])[2];
            
            $cek_payment = $db->query("SELECT * FROM payment WHERE code = '$payment'");
            $data_payment = mysqli_fetch_array($cek_payment);
            
            if (empty($payment)) {
                $pesan = "<div class='alert alert-danger'>Mohon memilih Metode Pembayaran.</div>";
            } else if (empty($shipping) || empty($shipping_type)) {
                $pesan = "<div class='alert alert-danger'>Mohon memilih Metode Pengiriman.</div>";
            } else {
                $apiKey       = '71OsCAlwSP73fbxma0lyziO7xLCsAISy2lK3T8j0';
                $privateKey   = 'sJhwJ-0FEcR-I8Xqm-TqOBY-Uu7OO';
                $merchantCode = 'T33194';
                $merchantRef  = $order_id;
                $amount       = $price + $shipping_price;
                
                $data_payment_array = [
                    'method'         => $payment,
                    'merchant_ref'   => $merchantRef,
                    'amount'         => $amount,
                    'customer_name'  => $data_address['full_name'],
                    'customer_email' => $data_address['email'],
                    'customer_phone' => $data_address['phone'],
                    'order_items'    => [
                        [
                            'sku'         => $order_id,
                            'name'        => $product_name,
                            'price'       => $price_per_item,
                            'quantity'    => $quantity,
                            'product_url' => ''.$web_baseurl.'produk/produk-preview?id='.$product_id,
                            'image_url'   => ''.$web_baseurl.'assets/images/product/'.$product_image
                        ],
                        [
                            'sku'         => $order_id . '-ongkir',
                            'name'        => 'Biaya Ongkir',
                            'price'       => $shipping_price,
                            'quantity'    => 1,
                            'product_url' => '',
                            'image_url'   => ''
                        ]
                    ],
                    'return_url'   => ''.$web_baseurl.'profile',
                    'expired_time' => (time() + (24 * 60 * 60)),
                    'signature'    => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
                ];
                
                $curl = curl_init();
                
                curl_setopt_array($curl, [
                    CURLOPT_FRESH_CONNECT  => true,
                    CURLOPT_URL            => 'https://tripay.co.id/api/transaction/create',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER         => false,
                    CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
                    CURLOPT_FAILONERROR    => false,
                    CURLOPT_POST           => true,
                    CURLOPT_POSTFIELDS     => http_build_query($data_payment_array),
                    CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
                ]);
                
                $response = curl_exec($curl);
                $result_payment = json_decode($response, true);
                curl_close($curl);
                
                if ($result_payment['success']) {
                    $payment_url = $result_payment['data']['checkout_url'];
                    
                    $insert = $db->query("INSERT INTO order_list (order_id, user_id, product_id, product_image, product_name, product_category, size, quantity, price, payment, status, expedition, expedition_type, tracking_id, receipt, price_shipping, payment_url, created_at, updated_at) VALUES ('$order_id', '$id', '$product_id', '$product_image', '$product_name', '$product_category', '$size', '$quantity', '$price', '".$data_payment['name']."', 'Belum dibayar', '$shipping', '$shipping_type', '', '', '$shipping_price', '$payment_url', '$datetime', '$datetime')");
                    if ($insert) {
                        header("Location: ".$payment_url);
                    } else {
                        $pesan = "<div class='alert alert-success'>Pesanan gagal, Sistem sedang error!</div>";
                    }
                } else {
                    $pesan = "<div class='alert alert-success'>Pesanan gagal, Pembayaran error!</div>";
                }
            }
        }
        
        $data = [
            'origin_postal_code' => configuration('web-postal-code'),
            'destination_postal_code' => $data_address['postal_code'],
            'couriers' => configuration('web-couriers'),
            'items' => [
                [
                    'name' => $product_name,
                    'description' => '',
                    'sku' => '',
                    'value' => $price,
                    'quantity' => $quantity,
                    'weight' => 500,
                    'height' => '',
                    'length' => '',
                    'width' => ''
                ]
            ]
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.biteship.com/v1/rates/couriers');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . configuration('web-key-biteship'),
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        
        require '../lib/header.php';
        require '../lib/navigation-two.php';
        
?>
<!-- CONTENT -->
<div class="container mt-5 py-5">
    
    <form method="post" id="checkoutForm">
        
    <div class="row g-4">
        
        <?php
        if (isset($_POST['buy'])) {
            echo $pesan;
        }
        ?>
        
        <!-- METHOD PAYMENT -->
        <div class="col-md-8 d-flex flex-column">
            
            <!-- PRODUK -->
            <div class="card rounded-4 border-0 shadow">
                <div class="card-body d-flex justify-content-between gap-4">
                    <img src="<?php echo $web_baseurl; ?>assets/images/product/<?php echo $product['image']; ?>" width="96" alt="" srcset="">

                    <div class="product flex-grow-1 d-flex flex-column justify-content-around">

                        <div class="details-product d-flex justify-content-between">
                            <div class="product">
                                <span class="fw-semibold"><?php echo htmlspecialchars($product['name']); ?></span>
                                <p>Size Chart : <?php echo htmlspecialchars($product['size']); ?></p>
                            </div>
                            <p class="text-primary">Rp. <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                        </div>

                        <div class="action-product d-flex justify-content-between">

                            <!-- FORM INC/DEC PRODUCT -->
                            <div class="d-flex">
                                <a href="<?php echo $web_baseurl; ?>cart/ajax/update-cart-buy-now?action=decrease&id=<?php echo $id; ?>" class="btn btn-sm btn-outline-primary bg-dongker"><i class="fa-solid fa-minus"></i></a>
                                <input name="numberProduct" id="quantity<?php echo $id; ?>" style="width: 4rem;" type="number" min="1" value="<?php echo $product['quantity']; ?>" class="form-control text-center border-0 shadow-none" readonly>
                                <a href="<?php echo $web_baseurl; ?>cart/ajax/update-cart-buy-now?action=increase&id=<?php echo $id; ?>" class="btn btn-sm btn-outline-primary bg-dongker"><i class="fa-solid fa-plus fs-12"></i></a>
                            </div>
                            
                            <button type="button" class="btn text-secondary" data-bs-toggle="modal" data-bs-target="#hapusModal" data-id="<?php echo $id; ?>"><i class="fa-solid fa-trash"></i> <span class="d-none d-md-inline">Hapus dari keranjang</span></button>
                        </div>
                    </div>

                </div>
            </div>

            <h4 class="mt-5 mb-3">Metode Pembayaran</h4>

            <!-- BEFORE CHOOSE METHOD -->
            <div class="row g-2">

                <!-- PAYMENT -->
                <div class="col-md-7">
                    <div class="card p-2 rounded-4 border-primary">
                        <div class="card-body">
                            
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button shadow-none bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            Debit Card
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body" class="">
                                            <?php
                                            $debit = mysqli_query($db, "SELECT * FROM payment WHERE category = 'Kartu Debit' ORDER BY id DESC");
                                            if (mysqli_num_rows($debit) > 0) {
                                            while($data_debit = mysqli_fetch_array($debit)) {
                                            ?>
                                            
                                            <div class="form-check form-check-reverse">
                                                <label class="form-check-label w-100 text-start" for="payment<?php echo $data_debit['id']; ?>">
                                                  <img src="<?php echo $web_baseurl; ?>assets/pembayaran/<?php echo $data_debit['logo']; ?>" width="36" height="36" class="me-2">
                                                  <span class="d-block"><?php echo $data_debit['name']; ?></span>
                                                  
                                                </label>
                                              <input class="form-check-input" type="radio" name="payment" id="payment<?php echo $data_debit['id']; ?>" value="<?php echo $data_debit['code']; ?>">
                                            </div>
                                            <hr/>
                                            <?php } } else { ?>
                                            
                                            <!-- NO DATA -->
                                            <div class="accordion-body">Pembayaran tidak tersedia</div>
                                            <?php } ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button shadow-none bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emoney-collapseOne" aria-expanded="false" aria-controls="emoney-collapseOne">
                                            E-Money
                                        </button>
                                    </h2>
                                    <div id="emoney-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionEmoneyExample">
                                        <div class="accordion-body" class="">
                                            <?php
                                            $emoney = mysqli_query($db, "SELECT * FROM payment WHERE category = 'E-Money' ORDER BY id DESC");
                                            if (mysqli_num_rows($emoney) > 0) {
                                            while($data_emoney = mysqli_fetch_array($emoney)) {
                                            ?>
                                            
                                            <div class="form-check form-check-reverse">
                                                <label class="form-check-label w-100 text-start" for="payment<?php echo $data_emoney['id']; ?>">
                                                  <img src="<?php echo $web_baseurl; ?>assets/pembayaran/<?php echo $data_emoney['logo']; ?>" width="36" height="36" class="me-2">
                                                  <?php echo $data_emoney['name']; ?>
                                                  
                                                </label>
                                              <input class="form-check-input" type="radio" name="payment" id="payment<?php echo $data_emoney['id']; ?>" value="<?php echo $data_emoney['code']; ?>">
                                            </div>
                                            <hr/>
                                            <?php } } else { ?>
                                            
                                            <!-- NO DATA -->
                                            <div class="accordion-body">Pembayaran tidak tersedia</div>
                                            <?php } ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button shadow-none bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#transferBank" aria-expanded="false" aria-controls="transferBank">
                                            Transfer Bank
                                        </button>
                                    </h2>
                                    <div id="transferBank" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body" class="">
                                            <?php
                                            $bank = mysqli_query($db, "SELECT * FROM payment WHERE category = 'Transfer Bank' ORDER BY id DESC");
                                            if (mysqli_num_rows($bank) > 0) {
                                            while($data_bank = mysqli_fetch_array($bank)) {
                                            ?>
                                            
                                            <div class="form-check form-check-reverse">
                                                <label class="form-check-label w-100 text-start" for="payment<?php echo $data_bank['id']; ?>">
                                                  <img src="<?php echo $web_baseurl; ?>assets/pembayaran/<?php echo $data_bank['logo']; ?>" width="36" height="36" class="me-2">
                                                  <?php echo $data_bank['name']; ?>
                                                  
                                                </label>
                                              <input class="form-check-input" type="radio" name="payment" id="payment<?php echo $data_bank['id']; ?>" value="<?php echo $data_bank['code']; ?>">
                                            </div>
                                            <hr/>
                                            <?php } } else { ?>
                                            
                                            <!-- NO DATA -->
                                            <div class="accordion-body">Pembayaran tidak tersedia</div>
                                            <?php } ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button shadow-none bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mitraLainnya" aria-expanded="false" aria-controls="mitraLainnya">
                                            Mitra Lainnya
                                        </button>
                                    </h2>
                                    <div id="mitraLainnya" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body" class="">
                                            <?php
                                            $minimarket = mysqli_query($db, "SELECT * FROM payment WHERE category = 'Minimarket' ORDER BY id DESC");
                                            if (mysqli_num_rows($minimarket) > 0) {
                                            while($data_minimarket = mysqli_fetch_array($minimarket)) {
                                            ?>
                                            
                                            <div class="form-check form-check-reverse">
                                                <label class="form-check-label w-100 text-start" for="payment<?php echo $data_minimarket['id']; ?>">
                                                  <img src="<?php echo $web_baseurl; ?>assets/pembayaran/<?php echo $data_minimarket['logo']; ?>" width="36" height="36" class="me-2">
                                                  <?php echo $data_minimarket['name']; ?>
                                                  
                                                </label>
                                              <input class="form-check-input" type="radio" name="payment" id="payment<?php echo $data_minimarket['id']; ?>" value="<?php echo $data_minimarket['code']; ?>">
                                            </div>
                                            <hr/>
                                            <?php } } else { ?>
                                            
                                            <!-- NO DATA -->
                                            <div class="accordion-body">Pembayaran tidak tersedia</div>
                                            <?php } ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- VOUCHER -->
                <div class="col-md-5">
                    <div class="card p-2 rounded-4 border-primary">
                        <div class="card-body">
                            <h5>Voucher</h5>
                            <div class="input-group p-2 rounded-4 border border-dark-subtle mb-3">
                                <span class="input-group-text border-0 bg-white"><i class="fa-solid fa-ticket"></i></span>
                                <input type="text" name="voucher" placeholder="Pakai voucher diskon" class="form-control border-0 shadow-none border-start-0" aria-label="showPassword">
                                <span class="input-group-text border-0 bg-white"><i class="fa-solid fa-plus"></i></span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- AFTER CHOOSE METHOD, ROW ATAS HILANGIN. dan sebaliknya -->
            <!-- <div class="col">
                <div class="card h-100 px-3 rounded-4 py-3 border-primary">
                    <div class="card-body">
                        <div class="method-details">
                            <img src="assets/pembayaran/bni.png" width="36" alt="" srcset="">
                            <span class="fw-bold">Transfer Bank</span>
                        </div>
                        <div class="time-details my-3">
                            <span class="fw-semibold fs-4 d-block">23:24:35</span>
                            <small class="text-secondary">Mohon segera lakukan pembayaran. Pesanan akan dibatalkan jika melewati batas waktu yang ditentukan.</small>
                        </div>
                        <div class="result-payment">
                            <span class="fs-5 text-primary d-block mb-2 mt-2">Virtual Account Number</span>
                            <span id="numberPaymentValue" class="fw-bold">129728179217892</span>
                            <button id="copyBtn" onclick="copyToClipboard()" class="btn btn-sm bg-secondary text-white" style="cursor: copy;">copy</button>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <!-- INFO DETAIL -->
        <div class="col-md-4">
            <div class="card px-3 rounded-5 py-3 border-primary">
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['user'])) {
                        $id = $_SESSION['user']['id'];
                        $address = mysqli_query($db, "SELECT * FROM address WHERE user_id = '$id' ORDER BY id DESC LIMIT 1");
                        while($data_address = mysqli_fetch_array($address)) {
                    ?>
                    
                    <div class="address-customer">
                        <span class="fw-semibold">Detail pengiriman</span>
                        <div class="card mt-2 border-0 shadow rounded-4">
                            <div class="card-body px-3">
                                <h6><?php echo $data_address['full_name']; ?></h6>
                                <span><?php echo $data_address['phone']; ?> <i class="fa-solid fa-square" style="font-size: 8px;"></i></span>
                                <span class="text-secondary"><?php echo $data_address['email']; ?></span>
                                <p><?php echo $data_address['address']; ?></p>
                                <a href="<?php echo $web_baseurl; ?>settings/edit-pengiriman?id=<?php echo $data_address['id']; ?>" class="text-decoration-none float-end">Ubah</a>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                    
                    <div class="shipping-method mt-3 mb-4">
                        <span class="fw-semibold">Metode pengiriman</span>
                        <div class="card mt-2 border-0 shadow rounded-4">
                            <div class="card-body px-3">
                                <?php
                                if ($result['pricing']) {
                                foreach ($result['pricing'] as $pricing) {
                                    if ($pricing['courier_name'] == 'JNE') {
                                        $image = 'jne.png';
                                    } else if ($pricing['courier_name'] == 'J&T') {
                                        $image = 'jnt.png';
                                    } else if ($pricing['courier_name'] == 'SICEPAT') {
                                        $image = 'sicepat.png';
                                    } else {
                                        $image = '';
                                    }
                                ?>
                                
                                <div class="form-check form-check-reverse">
                                    <label class="form-check-label w-100 text-start" for="<?php echo $pricing['courier_code']; ?>">
                                        <img src="<?php echo $web_baseurl; ?>assets/pengiriman/<?php echo $image; ?>" width="36" height="36" class="me-2">
                                        <?php echo $pricing['courier_name']; ?> <span><?php echo $pricing['courier_service_name']; ?> (<?php echo $pricing['shipment_duration_range']; ?> hari)</span>
                                        <p>(Rp <?php echo number_format($pricing['price'], 0, ',', '.'); ?>)</p>
                                    </label>
                                    <input class="form-check-input" type="radio" name="shipping" id="<?php echo $pricing['courier_code']; ?>" value="<?php echo $pricing['courier_code']; ?>,<?php echo $pricing['type']; ?>,<?php echo $pricing['price']; ?>" onchange="updateTotal(<?php echo $pricing['price']; ?>)">
                                </div>
                                <hr/>
                                <?php } } else { ?>
                                
                                <p class="text-center text-danger">Pengiriman tidak tersedia</p>
                                <?php } ?>
                                
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-4">Ringkasan Biaya</h5>
                    <h6>Subtotal</h6>
                    <div class="mt-3 vstack gap-2">
                        <div class="amount d-flex justify-content-between">
                            <span>Jumlah (<?php echo htmlspecialchars($product['quantity']); ?>)</span>
                            <span class="text-primary">Rp. <?php echo number_format($product['price'] * $product['quantity'], 0, ',', '.'); ?></span>
                        </div>
                        <div class="fee-delivery d-flex justify-content-between">
                            <span>Biaya pengiriman</span>
                            <span id="shippingCost" class="text-primary">Rp. 0</span>
                        </div>
                    </div>
                    <hr>
                    <div class="total d-flex justify-content-between">
                        <span class="fw-semibold">Total</span>
                        <span id="totalCost" class="text-primary">Rp. <?php echo number_format($product['price'] * $product['quantity'], 0, ',', '.'); ?></span>
                    </div>

                    <!-- FORM PAY -->
                    <div class="button-group mt-4 vstack gap-2 align-items-center">
                        <button type="submit" name="buy" class="btn btn-outline-primary w-75 rounded-3">Bayar sekarang</button>
                        <a href="<?php echo $web_baseurl; ?>shop" class="btn btn-outline-primary w-75 rounded-3">Batalkan</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    </form>
    
</div>

<!-- CONFIRMATION MODAL -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-5">
            <div class="modal-body text-center px-5">
                <form id="deleteForm" method="post">
                    <div class="my-5">
                        <h6 class="text-dongker mt-3">Yakin hapus ini dari keranjang?</h6>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-outline-primary rounded-4 my-2 px-4 me-2" name="delete"><img src="<?php echo $web_baseurl; ?>assets/images/delete.png" class="img-fluid me-1" width="20"> Ya, Hapus</button>
                        <button type="button" class="btn btn-outline-primary rounded-4 my-2 px-4" data-bs-dismiss="modal" aria-label="Close">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require '../lib/footer.php';
    } else {
        header("Location: ".$web_baseurl."shop");
    }
} else {
    header("Location: ".$web_baseurl."shop");
}
?>

<script>
    var deleteModal = document.getElementById('hapusModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var productId = button.getAttribute('data-id');
        var form = document.getElementById('deleteForm');
        form.action = '<?php echo $web_baseurl; ?>cart/ajax/remove-cart?id=' + productId;
    });
    function validateForm() {
        var shippingMethods = document.getElementsByName("shipping");
        var shippingChecked = false;
        for (var i = 0; i < shippingMethods.length; i++) {
            if (shippingMethods[i].checked) {
                shippingChecked = true;
                break;
            }
        }
        var paymentMethods = document.getElementsByName("payment");
        var paymentChecked = false;
        for (var i = 0; i < paymentMethods.length; i++) {
            if (paymentMethods[i].checked) {
                paymentChecked = true;
                break;
            }
        }
        if (!shippingChecked) {
            alert("Silakan pilih metode pengiriman terlebih dahulu.");
            return false;
        }
        if (!paymentChecked) {
            alert("Silakan pilih metode pembayaran terlebih dahulu.");
            return false;
        }
        return true;
    }
    document.getElementById("checkoutForm").addEventListener("submit", function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
    function updateTotal(shippingCost) {
        const subtotal = <?php echo $product['price'] * $product['quantity']; ?>;
        const total = subtotal + shippingCost;
        document.getElementById('shippingCost').innerText = 'Rp. ' + shippingCost.toLocaleString('id-ID');
        document.getElementById('totalCost').innerText = 'Rp. ' + total.toLocaleString('id-ID');
    }
</script>