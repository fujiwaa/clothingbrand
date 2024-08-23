<?php
session_start();
require '../../config.php';
$title = 'Pengaturan';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if ($password) {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $hash_password = $data_user['password'];
        }
        
        if (empty($email) || empty($password)) {
            $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input.</div>";
        } else {
            $update = $db->query("UPDATE user SET email = '$email', password = '$hash_password' WHERE id = '$id'");
            if ($update) {
                $pesan = "<div class='alert alert-success'>Pengaturan berhasil disimpan.</div>";
            } else {
                $pesan = "<div class='alert alert-success'>Pengaturan gagal disimpan, Sistem sedang error!</div>";
            }
        }
    }

    require '../../lib/admin/header.php';
?>
<div class="container-fluid p-0 bg-body-secondary d-flex vh-100 position-relative">

    <?php include '../../lib/admin/sidebar.php'; ?>

    <div class="main w-100 px-5">

        <div class="top-nav d-flex justify-content-between pt-4 align-items-center">
            <h4>Pengaturan</h3>
                <div class="menu-group d-flex gap-3">
                    <a href="#" class="text-dark"><i class="fa-regular fa-calendar p-2"></i></a>
                    <a href="#" class="text-dark"><i class="fa-solid fa-bell p-2"></i></a>
                <div>
                    <img src="<?= $web_baseurl ?>assets/images/profile/<?php echo $data_user['profile']; ?>" width="32">
                </div>
                <?php include '../../lib/admin/dropdown.php'; ?>
                
            </div>
        </div>

        <form method="post">
            <div class="content mt-5">
                <div class="card rounded-4 h-100 shadow px-4 pt-3 pb-5">
                    <div class="card-body">
                        <?php
                        if (isset($_POST['submit'])) {
                            echo $pesan;
                        }
                        ?>
                        <div class="mb-3">
                            <label for=""><i class="fa-regular fa-envelope"></i> Email</label>
                            <div class="mt-2 d-flex gap-3 align-items-center">
                                <div class="input-group shadow p-2 rounded-4 ">
                                    <input type="text" name="email" placeholder="Email" class="form-control border-0 shadow-none border-start-0" aria-label="showPassword">
                                </div>
                                <span>
                                    <i class="fa-regular fa-pen-to-square fs-4"></i>
                                </span>
                            </div>
                        </div>
                        <div>
                            <label for=""><i class="fa-solid fa-lock"></i> Password</label>
                            <div class="mt-2 d-flex gap-3 align-items-center">
                                <div class="input-group shadow p-2 rounded-4 ">
                                    <input type="password" name="password" placeholder="Kata sandi" class="form-control border-0 shadow-none border-start-0" aria-label="showPassword">
                                    <span id="showPassword" class="input-group-text border-0 bg-white"><i class="fa-regular fa-eye-slash fs-12"></i></span>
                                    <!-- show password icon change <i class="fa-regular fa-eye"></i> -->
                                </div>
                                <span>
                                    <i class="fa-regular fa-pen-to-square fs-4"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <button type="submit" name="submit" class="btn bg-dongker btn-outline-primary rounded-3 py-2 w-25">Simpan Perubahan</button>
                </div>
            </div>
        </form>

    </div>

</div>

<?php
include '../../lib/admin/footer.php';
} else {
    header("Location: ".$web_baseurl."profile");
}
?>