<?php
session_start();
require '../config.php';
$title = 'Produk Kategori';

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $cek_product = $db->query("SELECT * FROM product WHERE category LIKE '%$category%'");
    if (mysqli_num_rows($cek_product) == 0) {
        header("Location: " . $web_baseurl . "produk");
    }

    $cek_category = $db->query("SELECT * FROM category WHERE name = '$category'");
    $data_category = mysqli_fetch_array($cek_category);

    require '../lib/header.php';
    require '../lib/navigation-two.php';
?>
    <!-- CONTENT -->
    <div class="container">
        <div class="card">
            <div class="card-body p-0 position-relative">
                <img src="<?php echo $web_baseurl; ?>assets/images/category/<?php echo $data_category['image']; ?>" class="object-fit-cover" style="width: 100%; height: 320px;" alt="" srcset="">
                <div class="overlay position-absolute bg-dark w-100 h-100 top-0 opacity-50"></div>
                <span class="fs-1 position-absolute text-white fw-semibold" style="bottom: 16px; left: 32px;"><?php echo $category; ?></span>
            </div>
        </div>
    </div>

    <div class="container d-flex flex-column">
        <div class="sorting px-2 pt-4">
            <span>Urutkan produk berdasarkan</span>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                <select name="sort_by" id="sort_by" class="form-control form-select" onchange="this.form.submit()">
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
                                <li class="list-group-item"><a href="<?php echo $web_baseurl; ?>produk" class="text-decoration-none text-secondary">Semua Produk</a></li>
                                <li class="list-group-item"><a href="#" class="text-decoration-none text-secondary">Produk Unggulan</a></li>
                                <li class="list-group-item"><a href="#" class="text-decoration-none text-secondary">Diskon</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card p-4 rounded-0">
                        <div class="card-body">
                            <span>Kategori</span>
                            <ul class="list-group text-uppercase mt-2">
                                <?php
                                $cek_all_category = $db->query("SELECT * FROM category ORDER BY name ASC");
                                while ($data_all_category = mysqli_fetch_array($cek_all_category)) {
                                ?>
                                    <li class="list-group-item"><a href="<?php echo $web_baseurl; ?>produk/produk-kategori?category=<?php echo $data_all_category['name']; ?>" class="text-decoration-none <?php echo ($category == $data_all_category['name']) ? 'text-dongker fw-semibold' : 'text-secondary'; ?>"><?php echo $data_all_category['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- PRODUK -->
                <div class="col-md-8">
                    <div class="row row-cols-1 row-cols-md-3" style="row-gap: 0.5rem;">
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

                        $product_query = mysqli_query($db, "SELECT * FROM product WHERE category LIKE '%$category%' AND status = 'Tersedia' $sort_sql");

                        while ($data_product = mysqli_fetch_array($product_query)) {
                            $images = explode(',', $data_product['image']);
                        ?>
                            <div class="col">
                                <a href="<?php echo $web_baseurl; ?>produk/produk-preview?id=<?php echo $data_product['id']; ?>" class="text-decoration-none">
                                    <div class="card border-0 position-relative">
                                        <img src="<?php echo $web_baseurl; ?>assets/images/product/<?php echo $images[0]; ?>" class="" alt="baju">
                                        <span class="badge rounded-1 text-bg-dark position-absolute w-25" style="bottom: 134px; left: 8px;"><small><?php echo ($data_product['stock'] > 0) ? 'Ada Stok' : 'Habis' ?></small></span>
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

<?php
    require '../lib/footer.php';
} else {
    header("Location: " . $web_baseurl . "produk");
}
?>