<?php
session_start();
require '../../config.php';
$title = 'Status Pesanan';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);

    require '../../lib/admin/header.php';
?>
    <div class="container-fluid p-0 vh-100 bg-body-secondary d-flex position-relative">

        <?php include '../../lib/admin/sidebar.php'; ?>

        <div class="main w-100 px-5 overflow-auto">

            <div class="top-nav d-flex justify-content-between pt-4 align-items-center">
                <h4>Status Pesanan</h4>
                <div class="menu-group d-flex gap-3">
                    <a href="#" class="text-dark"><i class="fa-regular fa-calendar p-2"></i></a>
                    <a href="#" class="text-dark"><i class="fa-solid fa-bell p-2"></i></a>
                    <div>
                        <img src="<?= $web_baseurl ?>assets/images/profile/<?php echo $data_user['profile']; ?>" width="32">
                    </div>
                    <?php include '../../lib/admin/dropdown.php'; ?>
                </div>
            </div>

            <div class="content mt-5">

                <!-- TABS -->
                <div class="nav-tab w-75">
                    <?php
                    $linkActive = 'border-2 border-primary border-bottom';
                    $textActive = 'text-dongker';

                    $statusFilter = '';
                    if (isset($_GET['status'])) {
                        $statusFilter = $_GET['status'];
                    }
                    ?>
                    <ul style="list-style-type: none;" class="d-flex p-0 justify-content-between">
                        <li class="p-2 <?php echo ($statusFilter == '') ? $linkActive : 'border-bottom' ?>">
                            <a href="<?= $web_baseurl; ?>admin/pesanan/index" class="text-decoration-none <?php echo ($statusFilter == '') ? $textActive : 'text-secondary' ?>">Semua</a>
                        </li>
                        <li class="p-2 <?php echo ($statusFilter == 'belum-bayar') ? $linkActive : 'border-bottom' ?>">
                            <a href="<?= $web_baseurl; ?>admin/pesanan/index?status=belum-bayar" class="text-decoration-none <?php echo ($statusFilter == 'belum-bayar') ? $textActive : 'text-secondary'; ?>">Belum Bayar</a>
                        </li>
                        <li class="p-2 <?php echo ($statusFilter == 'perlu-dikirim') ? $linkActive : 'border-bottom' ?>">
                            <a href="<?= $web_baseurl; ?>admin/pesanan/index?status=perlu-dikirim" class="text-decoration-none <?php echo ($statusFilter == 'perlu-dikirim') ? $textActive : 'text-secondary'; ?>">Perlu Dikirim</a>
                        </li>
                        <li class="p-2 <?php echo ($statusFilter == 'dikirim') ? $linkActive : 'border-bottom' ?>">
                            <a href="<?= $web_baseurl; ?>admin/pesanan/index?status=dikirim" class="text-decoration-none <?php echo ($statusFilter == 'dikirim') ? $textActive : 'text-secondary'; ?>">Dikirim</a>
                        </li>
                        <li class="p-2 <?php echo ($statusFilter == 'selesai') ? $linkActive : 'border-bottom' ?>">
                            <a href="<?= $web_baseurl; ?>admin/pesanan/index?status=selesai" class="text-decoration-none <?php echo ($statusFilter == 'selesai') ? $textActive : 'text-secondary'; ?>">Selesai</a>
                        </li>
                        <li class="p-2 <?php echo ($statusFilter == 'pembatalan') ? $linkActive : 'border-bottom' ?>">
                            <a href="<?= $web_baseurl; ?>admin/pesanan/index?status=pembatalan" class="text-decoration-none <?php echo ($statusFilter == 'pembatalan') ? $textActive : 'text-secondary'; ?>">Pembatalan</a>
                        </li>
                        <li class="p-2 <?php echo ($statusFilter == 'pengembalian') ? $linkActive : 'border-bottom' ?>">
                            <a href="<?= $web_baseurl; ?>admin/pesanan/index?status=pengembalian" class="text-decoration-none <?php echo ($statusFilter == 'pengembalian') ? $textActive : 'text-secondary'; ?>">Pengembalian</a>
                        </li>
                        <li class="p-2 <?php echo ($statusFilter == 'pengiriman-gagal') ? $linkActive : 'border-bottom' ?>">
                            <a href="<?= $web_baseurl; ?>admin/pesanan/index?status=pengiriman-gagal" class="text-decoration-none <?php echo ($statusFilter == 'pengiriman-gagal') ? $textActive : 'text-secondary'; ?>">Pengiriman Gagal</a>
                        </li>
                    </ul>
                </div>

                <!-- WAKTU PESANAN DIBUAT -->
                <form action="" method="post">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <span>Waktu pesanan dibuat</span>
                        <input type="date" name="date_filter" class="form-control border border-dark bg-body-secondary shadow-none" style="width: 12rem;">
                        <div class="button-group">
                            <button class="btn btn-sm outline-dongker-adm rounded-3">Export</button>
                        </div>
                    </div>
                </form>

                <div class="mt-5 pb-4">
                    <!-- CARI -->
                    <form action="" method="post">
                        <div class="d-flex gap-4">
                            <div class="w-50">
                                <div class="input-group px-2 rounded-3 border border-dark">
                                    <select class="form-control bg-body-secondary border-0 shadow-none border-start-0" name="search_criteria" id="search_criteria">
                                        <option value="Nama Pembeli">Nama Pembeli</option>
                                        <option value="No Pesanan">No Pesanan</option>
                                        <option value="Produk">Produk</option>
                                    </select>
                                    <span class="input-group-text border-0 bg-body-secondary"><i class="fa fa-chevron-down"></i></span>
                                </div>
                            </div>
                            <div class="input-group px-2 rounded-3 border border-dark">
                                <span id="showPassword" class="input-group-text border-0 bg-body-secondary"><i class="fa-solid fa-magnifying-glass fs-6"></i></span>
                                <input type="text" name="search_value" placeholder="Masukkan pencarian" class="form-control bg-body-secondary border-0 shadow-none border-start-0" aria-label="showPassword">
                            </div>
                            <button class="btn outline-dongker-adm w-25 rounded-4">Cari Produk</button>
                        </div>
                    </form>

                    <!-- HEADING PRODUK PENGGANTI TABEL -->
                    <div class="mt-3 fw-semibold text-secondary d-flex text-center justify-content-between p-2">
                        <div class="" style="width: 25%;">Nama Produk</div>
                        <div class="" style="width: 20%;">Jumlah harus dibayar</div>
                        <div class="" style="width: 10%;">Status</div>
                        <div class="w-25">Jasa kirim</div>
                        <div class="" style="width: 10%;">Aksi</div>
                    </div>

                    <!-- LIST PRODUK PENGGANTI TABEL -->
                    <div class="vstack gap-3 mt-2">

                        <?php
                        $query = "SELECT order_list.*, user.full_name, user.profile FROM order_list LEFT JOIN user ON order_list.user_id = user.id";
                        $query .= " ORDER BY order_list.id DESC";
                        
                        $filters = [];
                        
                        if ($statusFilter) {
                            $filters[] = "order_list.status = '$statusFilter'";
                        }
                        
                        if (isset($_POST['search_criteria']) && isset($_POST['search_value'])) {
                            $searchCriteria = $_POST['search_criteria'];
                            $searchValue = $_POST['search_value'];
                            if ($searchCriteria == 'Nama Pembeli') {
                                $filters[] = "user.full_name LIKE '%$searchValue%'";
                            } elseif ($searchCriteria == 'No Pesanan') {
                                $filters[] = "order_list.order_id LIKE '%$searchValue%'";
                            } elseif ($searchCriteria == 'Produk') {
                                $filters[] = "order_list.product_name LIKE '%$searchValue%'";
                            }
                        }
                        
                        if (!empty($filters)) {
                            $query .= " WHERE " . implode(' AND ', $filters);
                        }
                        
                        $order = mysqli_query($db, $query);
                        
                        $processedOrders = [];
                        
                        while ($data_order = mysqli_fetch_array($order)) {
                            if (!isset($processedOrders[$data_order['order_id']])) {
                                $processedOrders[$data_order['order_id']] = $data_order;
                            }
                        }
                        
                        foreach ($processedOrders as $orderId => $orderData) {
                            $cek_address = $db->query("SELECT * FROM address WHERE user_id = '".$orderData['user_id']."' ORDER BY id DESC LIMIT 1");
                            $data_address = mysqli_fetch_array($cek_address);
                        ?>
                
                            <!-- ITEM -->
                            <div class="card rounded-4">
                                <div class="card-body p-0">
                
                                    <div class="card border-0 px-3 shadow rounded-4">
                                        <div class="card-body hstack justify-content-between">
                                            <div class="hstack gap-3">
                                                <img src="<?= $web_baseurl; ?>assets/images/profile/<?php echo $orderData['profile']; ?>" width="36" height="36" alt="">
                                                <span class="fw-semibold"><?php echo $orderData['full_name']; ?></span>
                                                <i class="fa-solid fa-message"></i>
                                            </div>
                
                                            <small class="text-secondary">No. Pesanan : <?php echo $orderData['order_id']; ?></small>
                                        </div>
                                    </div>
                
                                    <div class="d-flex p-3 justify-content-between align-items-center">
                                        <div class="d-flex gap-2 w-25">
                                            <img src="<?= $web_baseurl; ?>assets/images/product/<?php echo $orderData['product_image']; ?>" width="82" height="82" alt="">
                                            <div class="vstack justify-content-center">
                                                <span><?php echo $orderData['product_name']; ?></span>
                                                <small class="text-secondary">Size : <?php echo $orderData['size']; ?></small>
                                            </div>
                                        </div>
                                        <div class="text-center" style="width: 20%;">
                                            <p>x<?php echo $orderData['quantity']; ?> Rp. <?php echo number_format($orderData['price'] * $orderData['quantity'], 0, ',', '.'); ?></p>
                                            <small><?php echo $orderData['payment']; ?></small>
                                        </div>
                                        <div class="text-center" style="width: 10%;">
                                            <span><?php echo $orderData['status']; ?></span>
                                        </div>
                                        <div class="text-center" style="width: 25%;">
                                            <p><?php echo $orderData['expedition']; ?> <?php echo $orderData['expedition_type']; ?></p>
                                            <small><?php echo $orderData['receipt']; ?></small>
                                        </div>
                                        <div class="" style="width: 10%;">
                                            <span><a href="javascript:;" onclick="tracking('<?php echo $web_baseurl; ?>admin/pesanan/tracking?id=<?php echo $orderData['id']; ?>')" class="text-decoration-none text-dongker">Periksa rincian</a></span>
                                        </div>
                
                                    </div>
                
                                </div>
                            </div>
                        <?php } ?>

                    </div>

                </div>

            </div>

            <!-- Modal LACAK PESANAN -->
            <div class="modal modal-lg fade" id="modal-tracking" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" id="modal-tracking-content"></div>
                </div>
            </div>

        </div>

    </div>

<script type="text/javascript">
    function tracking(url) {
        $.ajax({
            type: "GET",
            url: url,
            beforeSend: function() {
                $('#modal-tracking-content').html('Sedang memuat...');
            },
            success: function(result) {
                $('#modal-tracking-content').html(result);
            },
            error: function() {
                $('#modal-tracking-content').html('Terdapat kesalahan, Silakan refresh halaman ini.');
            }
        });
        $('#modal-tracking').modal("show");
    }
</script>

<?php
    include '../../lib/admin/footer.php';
} else {
    header("Location: " . $web_baseurl . "profile");
}
?>