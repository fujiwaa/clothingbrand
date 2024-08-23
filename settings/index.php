<?php
session_start();
require '../config.php';
$title = 'Pengaturan Saya';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);

require '../lib/header.php';
require '../lib/navigation-two.php';
?>
<!-- CONTENT -->
<div class="container-fluid mt-5" style="height: 32rem;">
    <h3 class="text-center mb-3">Pengaturan Saya</h3>
    <div class="settings-menu py-3 w-75 mx-auto vstack gap-3">
        <a href="<?php echo $web_baseurl; ?>settings/info-profil" class="text-decoration-none text-dark bg-secondary-subtle ps-5 py-3 rounded-3"><i class="fa fa-user font-size-15"></i> Info profil saya</a>
        <a href="<?php echo $web_baseurl; ?>settings/info-pengiriman" class="text-decoration-none text-dark bg-secondary-subtle ps-5 py-3 rounded-3"><i class="fa-solid fa-truck"></i> Informasi pengiriman</a>
        <a href="<?php echo $web_baseurl; ?>settings/info-akun" class="text-decoration-none text-dark bg-secondary-subtle ps-5 py-3 rounded-3"><i class="fa-solid fa-user-shield"></i> Informasi akun</a>
        <a href="<?php echo $web_baseurl; ?>logout" class="text-decoration-none text-dark bg-secondary-subtle ps-5 py-3 rounded-3"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
    </div>
</div>

<?php
require '../lib/footer.php';
} else {
	header("Location: ".$web_baseurl."profile");
}
?>