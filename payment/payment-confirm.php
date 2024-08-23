<?php
session_start();
require '../config.php';
$title = 'Konfirmasi Pembayaran';
require '../lib/header.php';
require '../lib/navigation-two.php';

?>
<!-- CONTENT -->

<div class="container">

    <div class="card shadow mx-auto px-5 my-4 rounded-5" style="width: 64rem;">
        <div class="card-body pt-5 text-center text-primary">
            <img src="<?php echo $web_baseurl; ?>assets/images/paymentsuccess.png" alt="" srcset="">
            <p class="fs-4 fw-bold mt-3">Terimakasih</p>
            <p>Silahkan cek email untuk melihat invoice pembelian</p>
            <hr>
            <div class="vstack gap-3 w-50 mx-auto">
                <a href="https://gmail.com" class="btn btn-outline-primary" target="_blank">Cek email</a>
                <a href="<?php echo $web_baseurl; ?>profile" class="btn btn-outline-primary">Lihat riwayat pesanan</a>
            </div>
            <img src="<?php echo $web_baseurl; ?>assets/images/thankyou.png" class="float-end" alt="" srcset="">
        </div>
    </div>

</div>

<?php
require '../lib/footer.php';
?>