<?php
session_start();
require '../config.php';
$title = 'Dashboard';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);

    $total_produk = mysqli_num_rows($db->query("SELECT * FROM product"));
    
    $cek_produk = $db->query("SELECT SUM(stock) AS total FROM product");
    $total_stok = $cek_produk->fetch_assoc();
    
    $total_order = mysqli_num_rows($db->query("SELECT * FROM order_list WHERE status = 'Selesai'"));

    $sales_data = [];
    $categories = ['Limited Edition', 'Tshirt', 'Hoodie', 'Workshirt', 'Longsleeve'];
    foreach ($categories as $category) {
        $monthly_sales = [];
        for ($month = 1; $month <= 12; $month++) {
            $query = $db->query("SELECT SUM(quantity) AS total FROM order_list WHERE product_category = '$category' AND MONTH(created_at) = $month");
            $result = $query->fetch_assoc();
            $monthly_sales[] = $result['total'] ? $result['total'] : 0;
        }
        $sales_data[$category] = $monthly_sales;
    }

require '../lib/admin/header.php';
?>
<div class="container-fluid p-0 vh-100 bg-body-secondary d-flex position-relative">

    <?php include '../lib/admin/sidebar.php'; ?>

    <div class="main w-100 px-4 overflow-auto">

        <div class="top-nav d-flex justify-content-between pt-4 align-items-center">
            <h3 class="fw-bold">Dashboard</h3>
            <div class="menu-group d-flex gap-3">
                <a href="#" class="text-dark"><i class="fa-regular fa-calendar p-2"></i></a>
                <a href="#" class="text-dark"><i class="fa-solid fa-bell p-2"></i></a>
                <div>
                    <img src="<?= $web_baseurl ?>assets/images/profile/<?php echo $data_user['profile']; ?>" width="32">
                </div>
                <?php include '../lib/admin/dropdown.php'; ?>
            </div>
        </div>

        <div class="content mt-5 mb-5 p-4">

            <!-- 3 CARD -->
            <div class="row">

                <div class="col-4">
                    <div class="card rounded-4 shadow">
                        <div class="card-body px-4 py-3 d-flex justify-content-between">
                            <div>
                                <span class="fs-5 fw-bold d-block"><?php echo $total_produk; ?>+</span>
                                <small>Total produk</small>
                            </div>
                            <div class="card rounded-4 border-0 bg-danger-subtle" style="width: max-content; height: max-content;">
                                <div class="card-body">
                                    <i class="fa-solid fa-box fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card rounded-4 shadow">
                        <div class="card-body px-4 py-3 d-flex justify-content-between">
                            <div>
                                <span class="fs-5 fw-bold d-block"><?php echo $total_stok['total']; ?>+</span>
                                <small>Stok produk</small>
                            </div>
                            <div class="card rounded-4 border-0 bg-warning-subtle" style="width: max-content; height: max-content;">
                                <div class="card-body">
                                    <i class="fa-solid fa-box-open fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card rounded-4 shadow">
                        <div class="card-body px-4 py-3 d-flex justify-content-between">
                            <div>
                                <span class="fs-5 fw-bold d-block"><?php echo $total_order; ?>+</span>
                                <small>Produk terjual</small>
                            </div>
                            <div class="card rounded-4 border-0 bg-primary-subtle" style="width: max-content; height: max-content;">
                                <div class="card-body">
                                    <i class="fa-solid fa-bag-shopping fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- CHART -->
            <div class="mt-5">
                <h3 class="fw-bold">Reports</h3>
                <canvas id="myChart" style="width: 100%; height: 24rem;"></canvas>
            </div>

            <!-- PESANAN & PENILAIAN -->
            <div class="row mt-5">

                <div class="col-md-8">
                    <div class="card rounded-4 shadow">
                        <div class="card-body p-4">
                            <h4 class="fw-bold">Pesanan Terbaru</h4>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No Resi</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Total Order</th>
                                        <th>Total Semua</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $order = mysqli_query($db, "SELECT * FROM order_list ORDER BY id DESC LIMIT 5");
                                    while($data_order = mysqli_fetch_array($order)) {
                                    ?>
                                    
                                    <tr class="table-light">
                                        <td><?php echo $data_order['receipt']; ?></td>
                                        <td style="max-width: 10rem;">
                                            <div>
                                                <img src="<?= $web_baseurl; ?>assets/images/product/<?php echo $data_order['product_image']; ?>" width="32" height="32" alt="">
                                                <span><?php echo $data_order['product_name']; ?></span>
                                            </div>
                                        </td>
                                        <td>Rp <?php echo number_format($data_order['price'], 0, ',', '.'); ?></td>
                                        <td><span class="badge bg-dongker p-2 w-50"><?php echo $data_order['quantity']; ?></span></td>
                                        <td>Rp <?php echo number_format($data_order['price']*$data_order['quantity'], 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card rounded-4 shadow">
                        <div class="card-body p-4">
                            <h4 class="fw-bold">Penilaian Produk</h4>

                            <div class="vstack gap-4">
                                <?php
                                $rating = mysqli_query($db, "SELECT * FROM rating ORDER BY id DESC LIMIT 5");
                                while($data_rating = mysqli_fetch_array($rating)) {
                                ?>
                                
                                <div class="produk d-flex gap-4">
                                    <img src="<?= $web_baseurl; ?>assets/images/product/<?php echo $data_rating['product_image']; ?>" class="shadow rounded-3" width="64" height="64" alt="">
                                    <div>
                                        <span class="d-block"><?php echo $data_rating['product_name']; ?></span>
                                        <div>
                                            <small><?php echo $data_rating['rating']; ?></small>
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $data_rating['rating']) {
                                                    echo '<i class="fa-solid fa-star fs-12 text-warning"></i>';
                                                } else {
                                                    echo '<i class="fa-solid fa-star fs-12"></i>';
                                                }
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>



<?php
    include '../lib/admin/footer.php';
} else {
    header("Location: ".$web_baseurl."profile");
}
?>

<script>
    // CHART
    const ctx = document.getElementById('myChart');

    const listMonth = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sept', 'Okt', 'Nov', 'Des'];
    const salesData = <?php echo json_encode($sales_data); ?>;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: listMonth,
            datasets: [
                {
                    label: 'Limited Edition',
                    data: salesData['Limited Edition'],
                    borderWidth: 1
                },
                {
                    label: 'Tshirt',
                    data: salesData.Tshirt,
                    borderWidth: 1
                },
                {
                    label: 'Hoodie',
                    data: salesData.Hoodie,
                    borderWidth: 1
                },
                {
                    label: 'Workshirt',
                    data: salesData.Workshirt,
                    borderWidth: 1
                },
                {
                    label: 'Longsleeve',
                    data: salesData.Longsleeve,
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>