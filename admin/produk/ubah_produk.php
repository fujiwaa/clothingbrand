<?php
session_start();
require '../../config.php';
$title = 'Ubah Produk';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);

    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];
        $cek_product = $db->query("SELECT * FROM product WHERE id = '$product_id'");
        $data_product = mysqli_fetch_assoc($cek_product);
        if (mysqli_num_rows($cek_product) == 0) {
            header("Location: ".$web_baseurl."produk");
        } else {
            
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $category = implode(',', $_POST['category']);
                $price = $_POST['price'];
                $size = $_POST['size'];
                $stock = $_POST['stock'];
                $display = $_POST['display'];
                $description = $_POST['description'];
                
                if (empty($name) || empty($category) || empty($price) || empty($size) || empty($stock) || empty($display) || empty($description)) {
                    $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input.</div>";
                } else {
                    $target_dir = "../../assets/images/product/";
                    $image_paths = [];
                    
                    if (!empty($_FILES['images']['name'][0])) {
                        $old_images = explode(',', $data_product['image']);
                        foreach ($old_images as $old_image) {
                            unlink($target_dir . $old_image);
                        }
                        
                        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                            $file_name = basename($_FILES['images']['name'][$key]);
                            $file_tmp = $_FILES['images']['tmp_name'][$key];
                            $unique_name = uniqid() . '_' . $file_name;
                            $target_file = $target_dir . $unique_name;

                            if (move_uploaded_file($file_tmp, $target_file)) {
                                $image_paths[] = $unique_name;
                            } else {
                                $pesan = "<div class='alert alert-danger'>Gagal mengunggah gambar.</div>";
                            }
                        }
                        $images = implode(',', $image_paths);
                    } else {
                        $images = $data_product['image'];
                    }
                    
                    $update = $db->query("UPDATE product SET image = '$images', name = '$name', category = '$category', price = '$price', size = '$size', stock = '$stock', display = '$display', description = '$description', updated_at = '$datetime' WHERE id = '$product_id'");
                    if ($update) {
                        $pesan = "<div class='alert alert-success'>Produk Baru berhasil diubah.</div>";
                    } else {
                        $pesan = "<div class='alert alert-danger'>Produk Baru gagal diubah, Sistem sedang error!</div>";
                    }
                }
            }
            
            $existing_categories = explode(',', $data_product['category']);
            
            require '../../lib/admin/header.php';
?>
<div class="container-fluid p-0 vh-100 bg-body-secondary d-flex position-relative">

    <?php include '../../lib/admin/sidebar.php'; ?>

    <div class="main w-100 px-5 overflow-auto">

        <div class="top-nav d-flex justify-content-between pt-4 align-items-center">
            <h4><i class="fa-solid fa-arrow-left"></i> Ubah Produk</h3>
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
            <?php
            if (isset($_POST['submit'])) {
                echo $pesan;
            }
            ?>
            
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="" class="form-label col-2">Foto Produk</label>
                    <div class="col-sm-10 vstack gap-2">
                        <span>*Foto 1:1</span>
                        <div id="form-image" class="form-group p-1">
                            <label id="custom" for="images"><i class="fa-regular fa-images"></i> <small>Upload</small></label>
                            <input type="file" name="images[]" id="images" accept="image/*" multiple hidden>
                            <div id="list-images" class="mb-2 hstack flex-wrap gap-1">
                                <?php
                                $existing_images = explode(',', $data_product['image']);
                                foreach ($existing_images as $index => $existing_image) {
                                    echo "<div class='item position-relative' data-item='" . ($index + 1) . "' style='width: max-content;'>
                                            <img id='displayimg' class='rounded-2' src='" . $web_baseurl . "assets/images/product/" . $existing_image . "' width='116' height='118' alt='' srcset=''>
                                            <span data-img='" . ($index + 1) . "' id='remove-list' class='remove-list position-absolute top-0 start-100 translate-middle badge border border-light border-2 rounded-circle bg-danger' style='z-index: 1'>X</span>
                                        </div>";
                                }
                                ?>
                            </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="form-label col-2">Nama Produk</label>
                    <div class="col-sm-10 d-flex gap-3 align-items-center">
                        <div class="input-group bg-body-secondary border border-2 border-primary p-1 d-flex rounded-2 gap-2 align-items-center">
                            <input type="text" name="name" class="form-control border-0 bg-body-secondary shadow-none" placeholder="Tulis nama produk disini" value="<?php echo $data_product['name']; ?>">
                        
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="form-label col-2">Kategori</label>
                    <div class="col-sm-10 d-flex flex-wrap gap-3">
                        <div>
                            <input type="checkbox" class="btn-check" name="category[]" value="HOODIE" id="Hoodie" autocomplete="off"<?php echo in_array('HOODIE', $existing_categories) ? ' checked' : '' ?>>
                            <label class="btn btn-outline-primary btn-dongker" for="Hoodie">Hoodie</label>
                        </div>
                        <div>
                            <input type="checkbox" class="btn-check" name="category[]" value="TSHIRT" id="Tshirt" autocomplete="off"<?php echo in_array('TSHIRT', $existing_categories) ? ' checked' : '' ?>>
                            <label class="btn btn-outline-primary btn-dongker" for="Tshirt">Tshirt</label>
                        </div>
                        <div>
                            <input type="checkbox" class="btn-check" name="category[]" value="WORKSHIRT" id="Workshirt" autocomplete="off"<?php echo in_array('WORKSHIRT', $existing_categories) ? ' checked' : '' ?>>
                            <label class="btn btn-outline-primary btn-dongker" for="Workshirt">Workshirt</label>
                        </div>
                        <div>
                            <input type="checkbox" class="btn-check" name="category[]" value="LONGSLEEVE" id="Longsleeve" autocomplete="off"<?php echo in_array('LONGSLEEVE', $existing_categories) ? ' checked' : '' ?>>
                            <label class="btn btn-outline-primary btn-dongker" for="Longsleeve">Longsleeve</label>
                        </div>
                        <div>
                            <input type="checkbox" class="btn-check" name="category[]" value="LIMITED EDITION" id="Limited" autocomplete="off"<?php echo in_array('LIMITED EDITION', $existing_categories) ? ' checked' : '' ?>>
                            <label class="btn btn-outline-primary btn-dongker" for="Limited">Limited Edition</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="form-label col-2">Harga</label>
                    <div class="col-sm-10 d-flex gap-3 align-items-center">
                        <div class="input-group bg-body-secondary border border-2 border-primary p-1 d-flex rounded-2 gap-2 align-items-center">
                            <input type="number" name="price" class="form-control border-0 bg-body-secondary shadow-none" placeholder="Tulis harga produk disini" value="<?php echo $data_product['price']; ?>">
                            
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="form-label col-2">Size</label>
                    <div class="col-sm-10 d-flex gap-3 align-items-center">
                        <div class="input-group bg-body-secondary border border-2 border-primary p-1 d-flex rounded-2 gap-2 align-items-center">
                            <input type="text" name="size" class="form-control border-0 bg-body-secondary shadow-none" placeholder="Pisahkan dengan koma (,). contoh : S,M,L,XL" value="<?php echo $data_product['size']; ?>">
                            
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="form-label col-2">Stok</label>
                    <div class="col-sm-10 d-flex gap-3 align-items-center">
                        <div class="input-group bg-body-secondary border border-2 border-primary p-1 d-flex rounded-2 gap-2 align-items-center">
                            <input type="number" name="stock" class="form-control border-0 bg-body-secondary shadow-none" placeholder="Tulis stok produk disini" value="<?php echo $data_product['stock']; ?>">
                            
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="form-label col-2">Display Dashboard</label>
                    <div class="col-sm-10 d-flex gap-3 align-items-center">
                        <div class="input-group bg-body-secondary border border-2 border-primary p-1 d-flex rounded-2 gap-2 align-items-center">
                            <select class="form-control form-select border-0 bg-body-secondary shadow-none" name="display">
                                <option value="Ya"<?php echo ($data_product['display'] == 'Ya') ? ' selected' : '' ?>>Ya</option>
                                <option value="Tidak"<?php echo ($data_product['display'] == 'Tidak') ? ' selected' : '' ?>>Tidak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="form-label col-2">Deskripsi</label>
                    <div class="col-sm-10 d-flex gap-3 align-items-center">
                        <div class="input-group bg-body-secondary border border-2 border-primary p-1 d-flex rounded-2 gap-2 align-items-center">
                            <!-- <input type="text" name="password" class="form-control border-0 bg-body-secondary shadow-none" placeholder="Tulis nama produk disini">
                            <i class="fa-regular fa-pen-to-square fs-4"></i> -->
                            <textarea class="form-control bg-body-secondary border-0 shadow-none" name="description" id="" rows="5"><?php echo $data_product['description']; ?></textarea>
                        </div>
                    </div>
                    <!-- <div class="col-sm-10">
                    </div> -->
                </div>
                <div class="div d-flex justify-content-end">
                    <button type="submit" name="submit" class="btn bg-dongker px-3">Simpan</button>
                </div>
            </form>

        </div>

    </div>

</div>

<?php
    }
} else {
    header("Location: ".$web_baseurl."produk");
}
include '../../lib/admin/footer.php';
} else {
    header("Location: ".$web_baseurl."profile");
}
?>