<?php
session_start();
require '../config.php';
$title = 'informasi Akun';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);
    
    if (isset($_POST['delete'])) {
        $delete = $db->query("DELETE FROM user WHERE id = '$id'");
        if ($delete) {
            session_destroy();
            header("Location: ".$web_baseurl);
            $pesan = "<div class='alert alert-success'>Hapus Akun berhasil.</div>";
        } else {
            $pesan = "<div class='alert alert-success'>Hapus Akun gagal, Sistem sedang error!</div>";
        }
    }

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
                <div class="card-body ps-5">
                    <?php
                    if (isset($_POST['delete'])) {
                        echo $pesan;
                    }
                    ?>
                    
                    <form method="post">
                        <button type="submit" name="delete" class="btn text-white w-50 py-3 rounded-4 mb-4" style="background-color: #40679E;">Hapus Akun</button>
                    </form>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime dolorum ratione similique voluptas, debitis eaque laudantium vero obcaecati illo voluptatem.</p>
                    <p class="text-danger fw-semibold">Tindakan ini tidak dapat dibatalkan</p>
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