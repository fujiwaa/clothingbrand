<?php
session_start();
require '../config.php';
$title = 'informasi Pengiriman';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);

require '../lib/header.php';
require '../lib/navigation-two.php';
?>
<!-- CONTENT -->
<div class="container mt-5 py-5">
    <div class="row justify-content-center gap-2">

        <!-- SIDENAV SETTINGS -->
        <div class="col-md-4">
            <?php require '../lib/nav-settings.php'; ?>
        </div>

        <div class="col-md-7">
            <div class="card h-100 pb-4 rounded-5 border-primary bg-body-tertiary">
                <div class="card-body d-flex flex-column gap-3 px-5">
                    <a href="<?php echo $web_baseurl; ?>settings/create-pengiriman" class="text-decoration-none align-self-end"><i class="fa-solid fa-plus"></i> Buat baru</a>

                    <!-- HAS DATA -->
                    <?php
                    $address = mysqli_query($db, "SELECT * FROM address WHERE user_id = '$id' ORDER BY id DESC");
                    if (mysqli_num_rows($address) > 0) {
                    while($data_address = mysqli_fetch_array($address)) {
                    ?>
                    
                    <div class="card border-0 shadow rounded-4">
                                <div class="card-body px-5">
                                    <h6><?php echo $data_address['full_name']; ?></h6>
                                    <span><?php echo $data_address['phone']; ?> <i class="fa-solid fa-square" style="font-size: 8px;"></i></span>
                                    <span class="text-secondary"><?php echo $data_address['email']; ?></span>
                                    <p><?php echo $data_address['address']; ?></p>
                                    <a href="<?php echo $web_baseurl; ?>settings/edit-pengiriman?id=<?php echo $data_address['id']; ?>" class="text-decoration-none float-end">Ubah</a>
                                </div>
                            </div>
                    
                    <?php } } else { ?>
                    
                    <!-- NO DATA -->
                    <p>Tidak ada informasi pengiriman yang ditemukan</p>
                    <?php } ?>
                    
                </div>
            </div>
        </div>

    </div>
</div>

<?php
require '../lib/footer.php';
} else {
	header("Location: ".$web_baseurl."profile");
}
?>