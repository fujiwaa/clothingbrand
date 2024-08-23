<?php
session_start();
require '../config.php';
$title = 'Preview Produk';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cek_product = $db->query("SELECT * FROM product WHERE id = '$id'");
    $data_product = mysqli_fetch_assoc($cek_product);
    if (mysqli_num_rows($cek_product) == 0) {
        header("Location: ".$web_baseurl."produk");
        exit;
    } else {
        $cek_rating = mysqli_num_rows($db->query("SELECT * FROM rating WHERE product_id = '$id'"));
        $avg_rating = mysqli_fetch_assoc(mysqli_query($db, "SELECT AVG(rating) AS avg_rating FROM rating WHERE product_id = '$id'"))['avg_rating'];
        $image_rating = mysqli_num_rows(mysqli_query($db, "SELECT * FROM rating WHERE product_id = '$id' AND image != ''"));
        
        $images = explode(',', $data_product['image']);

require '../lib/header.php';
require '../lib/navigation-two.php';
?>
<!-- CONTENT -->
<div class="container mt-4 pb-5">

    <div class="product">

        <div class="row">

            <!-- IMAGES WITH MODAL -->
            <div class="col-md-6">
                <img src="<?php echo $web_baseurl; ?>assets/images/product/<?php echo $images[0]; ?>" class="object-fit-cover" style="width: 100%; height: 480px" alt="" srcset="">
                <div class="list-images d-flex gap-2 mt-4">
                    <?php
                    $no = 1;
                    foreach ($images as $image) {
                    ?>
                    <img src="<?php echo $web_baseurl; ?>assets/images/product/<?php echo $image; ?>" data-bs-toggle="modal" data-bs-target="#gambar<?php echo $no; ?>" width="64" class="rounded-3" style="cursor: pointer;">
                    <div class="modal fade" id="gambar<?php echo $no; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body d-flex justify-content-center">
                                    <img src="<?php echo $web_baseurl; ?>assets/images/product/<?php echo $image; ?>" alt="" srcset="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $no++; } ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 pb-5 px-0 px-md-4">
                    <div class="card-body">
                        <div class="subtitle mb-3">
                            <span class="badge bg-dongker"><?php echo ($data_product['stock'] > 0) ? 'Ada Stok' : 'Habis' ?></span>
                            <span class="badge bg-dongker"><?php echo ucwords(strtolower($data_product['category'])); ?></span>
                        </div>

                        <form id="productForm" action="<?php echo $web_baseurl; ?>cart/ajax/items" class="d-flex flex-column" method="post">

                            <div class="item-details">
                                <h5 class="fw-semibold"><?php echo $data_product['name']; ?></h5>
                                <span class="d-block">Rp. <?php echo number_format($data_product['price'],0,',','.'); ?></span>
                                <span><i class="fa-solid fa-star"></i> <?php echo $data_product['rating']; ?></span>
                            </div>

                            <div class="size-chart mt-4">
                                <span class="fw-semibold mb-3 d-block">Size Chart :</span>
                                <?php
                                $sizes = explode(',', $data_product['size']);
                                foreach ($sizes as $size) {
                                ?>
                                
                                <input type="radio" class="btn-check" name="sizeChart" id="size<?php echo $size; ?>" autocomplete="off" value="<?php echo $size; ?>">
                                <label class="btn btn-outline-primary" for="size<?php echo $size; ?>"><?php echo $size; ?></label>
                                <?php } ?>
                                
                            </div>
                            <hr>

                            <div class="button-group d-flex flex-column gap-3 align-items-center">
                                <div class="d-flex">
                                    <a href="#" name="decreaseBtn" id="decreaseBtn"  class="btn btn-sm outline-dongker bg-dongker"><i class="fa-solid fa-minus"></i></a>
                                    <input name="numberProduct" id="numberProduct" style="width: 4rem;" type="text" value="1" class="form-control text-center border-0 shadow-none">
                                    <a href="#" name="increaseBtn" id="increaseBtn" class="btn btn-sm outline-dongker bg-dongker"><i class="fa-solid fa-plus fs-12"></i></a>
                                </div>
                                
                                <button type="submit" name="addToCart" value="<?php echo $data_product['id']; ?>" class="btn outline-dongker w-100 rounded-4 py-2 text-center"><i class="fa-solid fa-cart-shopping"></i> Tambah ke keranjang</button>
                                <?php if ($_SESSION['user']) { ?>
                                <button type="submit" name="buyNow" value="<?php echo $data_product['id']; ?>" class="btn outline-dongker bg-dongker w-100 rounded-4 py-2 text-center">Beli sekarang</button>
                                <?php } else { ?>
                                <a href="<?php echo $web_baseurl; ?>profile" class="btn bg-secondary-subtle w-100 rounded-4 py-2 text-secondary text-center">Beli sekarang</a>
                                <?php } ?>
                            </div>

                            <div class="description mt-4">
                                <p><?php echo $data_product['description']; ?></p>
                            </div>

                            <div class="shipping-address mb-3">
                                <div class="card px-md-4 px-2 py-2 rounded-5 border-primary">
                                    <div class="card-body">
                                        <h6>Pengiriman</h6>
                                        <div class="address-cost">
                                            <div class="address d-flex justify-content-between">
                                                <span>Kirim Ke</span>
                                                <select class="form-control border-0 text-end" style="max-width: 10rem;" name="alamat" id="">
                                                    <option value="">Jakarta</option>
                                                    <option value="">ing elit. Recusandae, voluptatum?</option>
                                                </select>
                                            </div>
                                            <div class="cost my-3 d-flex justify-content-between">
                                                <span>Estimasi Biaya Pengiriman</span>
                                                <a href="#" class="text-decoration-none">Cek Harga</a>
                                            </div>
                                        </div>
                                        <span>Dikirim dalam 24jam<br>(Setelah pembayaran dikonfirmasi)</span>
                                    </div>
                                </div>
                            </div>

                            <a href="<?php echo $web_baseurl; ?>profile" class="btn outline-dongker w-100 rounded-5 py-3"><i class="fa-brands fa-rocketchat"></i> Kirim pesan ke Soulniv</a>

                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <?php
    if ($cek_rating > 0) {
    ?>
    <!-- TESTIMONIAL -->
    <div class="testimonials">
        <h5>Testimoni dan Rating</h5>
        <div class="rating">
            <span><i class="fa-solid fa-star"></i> <?php echo number_format($avg_rating, 2); ?> (<?php echo $cek_rating; ?>)</span>
        </div>
        <div class="filter-button mt-3">
            <a href="#" class="btn rounded-4 px-3 bg-dongker">Semua</a>
            <a href="#" class="btn rounded-4 px-3 outline-dongker">Dengan Foto (<?php echo $image_rating; ?>)</a>
        </div>
        <div class="list-testimonial mt-4">
            <div class="row gap-3">
                <?php
                $rating = mysqli_query($db, "SELECT * FROM rating WHERE product_id = '$id' ORDER BY id DESC");
                while($data_rating = mysqli_fetch_array($rating)) {
                    $cek_user = $db->query("SELECT * FROM user WHERE id = '".$data_rating['user_id']."'");
                    $data_user = mysqli_fetch_assoc($cek_user);
                    
                    $cek_order = $db->query("SELECT * FROM order_list WHERE id = '".$data_rating['order_id']."'");
                    $data_order = mysqli_fetch_assoc($cek_order);
                ?>
                <div class="col-12">
                    <div class="card ps-4 py-3 rounded-4 border-primary">
                        <div class="card-body d-flex justify-content-between">
                            <div class="information">
                                <span class="fs-6 d-block fw-semibold"><?php echo $data_user['full_name']; ?></span>
                                <small><?php echo format_date($data_rating['created_at']); ?></small>
                                <div class="item-rating">
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
                                <small>Size : <?php echo $data_order['size']; ?></small>
                                <span class="d-block mt-3"><?php echo nl2br($data_rating['description']); ?></span>
                                <small>Kualitas produk bagus, Pelayanan memuaskan</small>
                            </div>
                            <?php
                            if ($data_rating['image']) {
                            ?>
                            <div class="images">
                                <img src="<?php echo $web_baseurl; ?>assets/images/rating/<?php echo $data_rating['image']; ?>" style="width: 8rem; height: 8rem;" alt="" srcset="">
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>

</div>

<script>
    document.getElementById('productForm').addEventListener('submit', function(event) {
        var sizeSelected = document.querySelector('input[name="sizeChart"]:checked');
        if (!sizeSelected) {
            event.preventDefault();
            alert('Pilih Size Chart terlebih dahulu!');
        }
    });
</script>

<?php
    }
} else {
    header("Location: ".$web_baseurl."produk");
}
require '../lib/footer.php';
?>