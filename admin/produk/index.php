<?php
session_start();
require '../../config.php';
$title = 'Produk';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);
    
    $count_produk = mysqli_num_rows($db->query("SELECT * FROM product"));
    
    if (isset($_POST['delete'])) {
        $product_id = $_POST['id'];
        
        $product_delete = mysqli_query($db, "SELECT * FROM product WHERE id = '$product_id'");
        $data_product_delete = mysqli_fetch_array($product_delete);
        
        $delete = $db->query("DELETE FROM product WHERE id = '$product_id'");
        if ($delete) {
            if (!empty($data_product_delete['image'])) {
                unlink('../../assets/images/product/'.$data_product_delete['image'].'');
            }
            $pesan = "<div class='alert alert-success'>Produk berhasil dihapus.</div>";
        } else {
            $pesan = "<div class='alert alert-success'>Produk gagal dihapus, Sistem sedang error!</div>";
        }
    }
    
    if (isset($_POST['archive'])) {
        $product_id = $_POST['id'];
        $update = $db->query("UPDATE product SET status = 'Diarsipkan' WHERE id = '$product_id'");
        if ($update) {
            $pesan = "<div class='alert alert-success'>Produk berhasil diarsipkan.</div>";
        } else {
            $pesan = "<div class='alert alert-success'>Produk gagal diarsipkan, Sistem sedang error!</div>";
        }
    }
    
    require '../../lib/admin/header.php';
?>
<div class="container-fluid p-0 vh-100 bg-body-secondary d-flex position-relative">

    <?php include '../../lib/admin/sidebar.php'; ?>

    <div class="main w-100 px-5 overflow-auto">

        <div class="top-nav d-flex justify-content-between pt-4 align-items-center">
            <h4>Produk</h4>
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
            if (isset($_POST['delete']) OR isset($_POST['archive'])) {
                echo $pesan;
            }
            ?>

            <!-- TABS -->
            <div class="d-flex">
            <div class="nav-tab me-auto" style="width: 34rem;">
                <?php
                $linkActive = 'border-2 border-primary border-bottom';
                $textActive = 'text-dongker fw-semibold';
                ?>
                <ul style="list-style-type: none;" class="d-flex p-0 justify-content-between">
                    <li class="p-2 <?php echo (!$_GET) ? $linkActive : 'border-bottom' ?>"><a href="<?= $web_baseurl; ?>admin/produk/index" class="text-decoration-none <?php echo (!$_GET) ? $textActive : 'text-secondary' ?>">Semua</a></li>
                    <li class="p-2 <?php echo (isset($_GET['tersedia'])) ? $linkActive : 'border-bottom' ?>"><a href="<?= $web_baseurl; ?>admin/produk/index?tersedia" class="text-decoration-none <?php echo (isset($_GET['tersedia'])) ? $textActive : 'text-secondary'; ?>">Tersedia</a></li>
                    <li class="p-2 <?php echo (isset($_GET['belumupload'])) ? $linkActive : 'border-bottom' ?>"><a href="<?= $web_baseurl; ?>admin/produk/index?belumupload" class="text-decoration-none <?php echo (isset($_GET['belumupload'])) ? $textActive : 'text-secondary'; ?>">Belum di Upload</a></li>
                    <li class="p-2 <?php echo (isset($_GET['diarsipkan'])) ? $linkActive : 'border-bottom' ?>"><a href="<?= $web_baseurl; ?>admin/produk/index?diarsipkan" class="text-decoration-none <?php echo (isset($_GET['diarsipkan'])) ? $textActive : 'text-secondary'; ?>">Diarsipkan</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <a href="tambah_produk" class="btn btn-sm bg-dongker btn-outline-primary"><i class="fa-solid fa-plus"></i> Tambah Produk</a>
            </div>
            </div>
            
            <div class="mt-5 pb-4">
                <!-- CARI -->
                <form method="get">
                    <div class="d-flex gap-4">
                        <div class="input-group rounded-4 p-1 border border-dark">
                            <span id="showPassword" class="input-group-text border-0 bg-body-secondary"><i class="fa-solid fa-magnifying-glass fs-6"></i></span>
                            <input type="text" name="search" placeholder="Cari nama produk, id produk, jenis produk" class="form-control bg-body-secondary border-0 shadow-none border-start-0" aria-label="showPassword">
                        </div>
                        <button type="submit" class="btn bg-dongker w-25 rounded-4 btn-outline-primary">Cari Produk</button>
                    </div>
                </form>

                <!-- TABEL -->
                <div class="messages-list mt-3">
                    <h6 class="mb-2"><?php echo $count_produk; ?> Produk</h6>
                    <div class="card border-0 shadow rounded-4">
                        <div class="card-body p-0">
                            <table class="table table-borderless rounded-4">
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="text-center">Produk</th>
                                        <th class="">Harga</th>
                                        <th class="">Stok</th>
                                        <th class="">Status</th>
                                        <th class="">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM product WHERE 1=1";
                                    if (isset($_GET['tersedia'])) {
                                        $query .= " AND status = 'tersedia'";
                                    } elseif (isset($_GET['belumupload'])) {
                                        $query .= " AND status = 'belum di upload'";
                                    } elseif (isset($_GET['diarsipkan'])) {
                                        $query .= " AND status = 'diarsipkan'";
                                    }

                                    if (isset($_GET['search']) && $_GET['search'] != '') {
                                        $search = $_GET['search'];
                                        $query .= " AND (name LIKE '%$search%' OR id LIKE '%$search%')";
                                    }

                                    $query .= " ORDER BY id DESC";
                                    
                                    $product = mysqli_query($db, $query);
                                    while($data_product = mysqli_fetch_array($product)) {
                                    $images = explode(',', $data_product['image']);
                                    ?>
                                    
                                    <tr>
                                        <td style="max-width: 12rem;">
                                            <div class="d-flex gap-3">
                                                <img src="<?= $web_baseurl; ?>assets/images/product/<?php echo $images[0]; ?>" width="96" height="96" alt="">
                                                <div>
                                                    <span class="d-block"><?php echo $data_product['name']; ?></span>
                                                    <small class="text-secondary">Id Produk : <?php echo $data_product['id']; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp. <?php echo number_format($data_product['price'], 0, ',', '.'); ?></td>
                                        <td><?php echo $data_product['stock']; ?></td>
                                        <td><?php echo $data_product['status']; ?></td>
                                        <td>
                                            <div class="vstack">
                                                <a href="ubah_produk?id=<?php echo $data_product['id']; ?>" class="text-decoration-none text-dongker">Ubah</a>
                                                <a href="#" class="text-decoration-none text-dongker" data-bs-toggle="modal" data-bs-target="#arsipModal<?php echo $data_product['id']; ?>"><?php echo (isset($_GET['diarsipkan'])) ? 'Tampilkan' : 'Arsipkan'; ?></a>
                                                <a href="#" class="text-decoration-none text-dongker" data-bs-toggle="modal" data-bs-target="#hapusModal<?php echo $data_product['id']; ?>">Hapus</a>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <div class="modal fade" id="arsipModal<?php echo $data_product['id']; ?>" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-5">
                                                <div class="modal-body text-center px-5">
                                                    <form method="post">
                                                        <input type="hidden" name="id" value="<?php echo $data_product['id']; ?>">
                                                        <div class="my-5">
                                                            <img src="<?php echo $web_baseurl; ?>assets/images/archive.png" class="img-fluid" width="100">
                                                            <h6 class="text-dongker mt-3">Produk Ini Akan Diarsipkan</h6>
                                                        </div>
                                                        <div class="mt-4">
                                                            <button type="submit" class="btn btn-outline-primary rounded-4 my-2 px-4 me-2" name="archive">Ya, Arsipkan</button>
                                                            <button type="button" class="btn btn-outline-primary rounded-4 my-2 px-4" data-bs-dismiss="modal" aria-label="Close">Batalkan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade" id="hapusModal<?php echo $data_product['id']; ?>" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-5">
                                                <div class="modal-body text-center px-5">
                                                    <form method="post">
                                                        <input type="hidden" name="id" value="<?php echo $data_product['id']; ?>">
                                                        <div class="my-5">
                                                            <img src="<?php echo $web_baseurl; ?>assets/images/delete.png" class="img-fluid" width="100">
                                                            <h6 class="text-dongker mt-3">Produk Ini Akan Dihapus</h6>
                                                        </div>
                                                        <div class="mt-4">
                                                            <button type="submit" class="btn btn-outline-primary rounded-4 my-2 px-4 me-2" name="delete">Ya, Hapus</button>
                                                            <button type="button" class="btn btn-outline-primary rounded-4 my-2 px-4" data-bs-dismiss="modal" aria-label="Close">Batalkan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<?php
include '../../lib/admin/footer.php';
} else {
    header("Location: ".$web_baseurl."profile");
}
?>