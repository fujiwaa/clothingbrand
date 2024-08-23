<?php
session_start();
require '../config.php';
$title = 'Rating Produk';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cek_order = $db->query("SELECT * FROM order_list WHERE id = '$id'");
    $data_order = mysqli_fetch_assoc($cek_order);
    if (mysqli_num_rows($cek_order) == 0) {
        header("Location: ".$web_baseurl."profile");
    } else {
        
        if (isset($_POST['submit'])) {
            $rating = $_POST['rating'];
            $komentar = $_POST['komentar'];
            $image = '';
            
            if (isset($_FILES['fotoRatingProduk']) && $_FILES['fotoRatingProduk']['error'] == 0) {
                $imageName = uniqid() . '_' . $_FILES['fotoRatingProduk']['name'];
                $imagePath = '../assets/images/rating/' . $imageName;
                
                if(move_uploaded_file($_FILES['fotoRatingProduk']['tmp_name'], $imagePath)) {
                    $image = $imageName;
                } else {
                    $pesan = "<div class='alert alert-danger'>Gagal mengunggah foto.</div>";
                }
            }
            
            $cek_product = $db->query("SELECT * FROM product WHERE name = '".$data_order['product_name']."'");
            $data_product = mysqli_fetch_assoc($cek_product);
            
            if (empty($rating) || empty($komentar) || empty($image)) {
                $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input dan unggah foto.</div>";
            } else {
                $insert = $db->query("INSERT INTO rating (order_id, product_id, product_image, product_name, image, rating, description, created_at, updated_at) VALUES ('$id', '".$data_product['id']."', '".$data_order['product_image']."', '".$data_order['product_name']."', '$image', '$rating', '$komentar', '$datetime', '$datetime')");
                if ($insert) {
                    $pesan = "<div class='alert alert-success'>Rating berhasil diterima.</div>";
                } else {
                    $pesan = "<div class='alert alert-danger'>Rating gagal diterima, Sistem sedang error!</div>";
                }
            }
        }

require '../lib/header.php';
require '../lib/navigation-two.php';
?>
<!-- CONTENT -->

<div class="container mt-4 pb-5">
    <div class="heading d-flex gap-5 align-items-center">
        <a href="<?php echo $web_baseurl; ?>profile" class="text-decoration-none text-dark"><i class="fa-solid fa-arrow-left"></i></a>
        <h5 class="fw-semibold">Penilaian Produk</h5>
    </div>

    <div class="product py-5">
        <div class="row">
            
            <?php
            if ($pesan == "<div class='alert alert-success'>Rating berhasil diterima.</div>") {
            ?>
            
            <!-- AFTER SUBMIT REVIEW -->
            <div class="col-12">
                        <div class="card border-top-0 shadow rounded-4 mt-3 pb-5 px-4">
                            <div class="card-body text-center">
                                <img src="<?php echo $web_baseurl; ?>assets/images/thankyou.png" alt="" srcset="">
                                <p class="text-primary">Atas ulasan yang telah anda berikan</p>
                                <hr>
                            </div>
                        </div>
                    </div>
                    
            <?php } else { ?>
            
            <!-- BEFORE SUBMIT REVIEW -->
            <div class="col">
                <img src="<?php echo $web_baseurl; ?>assets/images/product/<?php echo $data_order['product_image']; ?>" alt="" srcset="">
            </div>
            <div class="col">
                <h5><?php echo $data_order['product_name']; ?></h5>
                <div class="card border-top-0 shadow rounded-4 mt-3 pb-5 px-4">
                    <div class="card-body">
                        <?php
                        if (isset($_POST['submit'])) {
                            echo $pesan;
                        }
                        ?>

                        <form class="d-flex flex-column" method="post" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label for="foto" class="form-label fw-semibold">Rating Produk</label>

                                <div class="stars hstack gap-3">
                                    <input type="radio" class="btn-check" name="rating" value="1.0" id="star1" autocomplete="off">
                                    <label for="star1"><i class="fa-solid fa-star"></i></label>
                                    <input type="radio" class="btn-check" name="rating" value="2.0" id="star2" autocomplete="off">
                                    <label for="star2"><i class="fa-solid fa-star"></i></label>
                                    <input type="radio" class="btn-check" name="rating" value="3.0" id="star3" autocomplete="off">
                                    <label for="star3"><i class="fa-solid fa-star"></i></label>
                                    <input type="radio" class="btn-check" name="rating" value="4.0" id="star4" autocomplete="off">
                                    <label for="star4"><i class="fa-solid fa-star"></i></label>
                                    <input type="radio" class="btn-check" name="rating" value="5.0" id="star5" autocomplete="off">
                                    <label for="star5"><i class="fa-solid fa-star"></i></label>
                                </div>

                            </div>

                            <div class="mb-3">
                                <label for="fotoRatingProduk" class="form-label fw-semibold">Unggah Foto</label>
                                <span><i class="fa-solid fa-upload"></i></span>
                                <input type="file" accept="image/*" class="form-control d-none" name="fotoRatingProduk" id="fotoRatingProduk">

                                <div class="preview-foto">
                                    <img id="imagePreview" width="132">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="komentar" class="form-label fw-semibold">Komentar</label>
                                <textarea class="form-control" name="komentar" id="komentar"></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn mt-4 text-white w-25 align-self-center" style="background-color: #40679E;">Kirim Ulasan</button>
                        </form>

                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>

</div>

<?php
    }
} else {
    header("Location: ".$web_baseurl."produk");
}
require '../lib/footer.php';
?>