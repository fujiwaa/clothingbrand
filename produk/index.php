<?php
session_start();
require '../config.php';
$title = 'Produk';
require '../lib/header.php';
require '../lib/navigation-two.php';
?>
<!-- CONTENT -->
<div class="container d-flex flex-column">
    <div class="sorting px-2 pt-4">
        <span>Urutkan produk berdasarkan</span>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <select name="sort_by" id="sort_by" class="form-control" onchange="this.form.submit()">
                <option value="newest" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'newest') echo 'selected'; ?>>Terbaru</option>
                <option value="popular" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'popular') echo 'selected'; ?>>Terlaris</option>
                <option value="highest_price" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'highest_price') echo 'selected'; ?>>Harga tertinggi</option>
                <option value="lowest_price" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'lowest_price') echo 'selected'; ?>>Harga terendah</option>
            </select>
        </form>
    </div>

    <div class="content py-5">
        <div class="row">

            <!-- SIDENAV PRODUK -->
            <div class="col-md-3">
                <div class="card p-4 rounded-0">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="<?php echo $web_baseurl; ?>produk" class="text-decoration-none text-primary">Semua Produk</a></li>
                            <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Produk Unggulan</a></li>
                            <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Diskon</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card p-4 rounded-0">
                    <div class="card-body">
                        <span>Kategori</span>
                        <ul class="list-group text-uppercase mt-2">
                            <?php
                            $cek_category = $db->query("SELECT * FROM category ORDER BY name ASC");
                            while ($data_category = mysqli_fetch_array($cek_category)) {
                            ?>

                                <li class="list-group-item"><a href="<?php echo $web_baseurl; ?>produk/produk-kategori?category=<?php echo $data_category['name']; ?>" class="text-decoration-none <?php echo (strpos($_SERVER['REQUEST_URI'], $data_category['name']) == true) ? 'text-primary' : 'text-dark' ?>"><?php echo $data_category['name']; ?></a></li>
                            <?php } ?>

                        </ul>
                    </div>
                </div>
            </div>

            <!-- PRODUK -->
            <div class="col-md-9">
                <div class="row" style="row-gap: 0.5rem;">
                    <?php
                    $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'newest';
                    $sort_sql = '';

                    if ($sort_by == 'popular') {
                        $sort_sql = 'ORDER BY rating DESC';
                    } elseif ($sort_by == 'highest_price') {
                        $sort_sql = 'ORDER BY price DESC';
                    } elseif ($sort_by == 'lowest_price') {
                        $sort_sql = 'ORDER BY price ASC';
                    } else {
                        $sort_sql = 'ORDER BY created_at DESC';
                    }

                    $product_query = mysqli_query($db, "SELECT * FROM product WHERE status = 'Tersedia' $sort_sql");

                    while ($data_product = mysqli_fetch_array($product_query)) {
                        $images = explode(',', $data_product['image']);
                    ?>
                        <div class="col-4">
                            <a href="<?php echo $web_baseurl; ?>produk/produk-preview?id=<?php echo $data_product['id']; ?>" class="text-decoration-none">
                                <div class="card border-0 position-relative">
                                    <img src="<?php echo $web_baseurl; ?>assets/images/product/<?php echo $images[0]; ?>" class="" alt="baju">
                                    <span class="badge rounded-1 text-bg-dark position-absolute w-25" style="bottom: 108px; left: 8px;"><small><?php echo ($data_product['stock'] > 0) ? 'Ada Stok' : 'Habis' ?></small></span>
                                    <div class="card-body">
                                        <span class="d-block"><?php echo $data_product['name']; ?></span>
                                        <span>Rp. <?php echo number_format($data_product['price'], 0, ',', '.'); ?></span>
                                        <span class="fs-12 mt-1 d-block"><i class="fa-solid fa-star"> <?php echo $data_product['rating']; ?></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include '../lib/footer.php'; ?>