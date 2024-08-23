<?php
session_start();
require '../config.php';
$title = 'informasi Profil';

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
            <div class="card h-100 rounded-5 border-primary py-5">
                <div class="card-body text-center">
                    <img src="<?php echo $web_baseurl; ?>assets/images/profile/user.png" class="rounded mx-auto d-block" alt="...">
                    <p class="mt-3 fw-semibold"><?php echo $data_user['full_name']; ?></p>
                    <span class="fw-semibold">
                        <i class="fa-regular fa-envelope"></i> <?php echo $data_user['email']; ?>
                    </span>
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