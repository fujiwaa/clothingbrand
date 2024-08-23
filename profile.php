<?php
session_start();
require 'config.php';
require 'lib/PHPMailer/class.phpmailer.php';
$title = 'Profil';

    if ($_SESSION['user']) {
        $id = $_SESSION['user']['id'];
        $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
        $data_user = mysqli_fetch_array($cek_user);
        
        $cek_order = mysqli_num_rows($db->query("SELECT * FROM order_list WHERE user_id = '$id'"));
        
        $chat = mysqli_query($db, "SELECT * FROM chat WHERE user_id = '$id'");
        $data_chat = mysqli_fetch_array($chat);
        
        if (isset($_POST['send'])) {
            $pesantext = $_POST['pesantext'];
            
            if (empty($pesantext)) {
                $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input.</div>";
            } else {
                $insert = $db->query("INSERT INTO chat_reply (chat_id, sender, message, is_read_admin, is_read_user, created_at) VALUES ('".$data_chat['id']."', 'user', '$pesantext', '0', '0', '$datetime')");
                if ($insert) {
                    $pesan = "<div class='alert alert-success'>Chat berhasil dikirim.</div>";
                } else {
                    $pesan = "<div class='alert alert-success'>Chat gagal dikirim, Sistem sedang error!</div>";
                }
            }
        }
    } else {
        
        if (isset($_POST['register'])) {
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $cek_email = $db->query("SELECT * FROM user WHERE email = '$email'");
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            
            if (empty($full_name) || empty($email) || empty($password)) {
                $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input.</div>";
            } else if (mysqli_num_rows($cek_email) > 0) {
                $pesan = "<div class='alert alert-danger'>Email sudah terdaftar.</div>";
            } else {
                $insert = $db->query("INSERT INTO user (full_name, profile, email, password, level, created_at, updated_at) VALUES ('$full_name', 'user.png', '$email', '$hash_password', 'Member', '$datetime', '$datetime')");
                if ($insert) {
                    $pesan = "<div class='alert alert-success'>Pendaftaran Akun berhasil.</div>";
                } else {
                    $pesan = "<div class='alert alert-success'>Pendaftaran Akun gagal, Sistem sedang error!</div>";
                }
            }
        }
        
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $cek_user = $db->query("SELECT * FROM user WHERE email = '$email'");
            $data_user = mysqli_fetch_array($cek_user);
            
            $verify_password = password_verify($password, $data_user['password']);
            
            if (empty($email) || empty($password)) {
                $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input.</div>";
            } else if (mysqli_num_rows($cek_user) == 0) {
                $pesan = "<div class='alert alert-danger'>Email tidak ditemukan.</div>";
            } else if ($verify_password == false) {
                $pesan = "<div class='alert alert-danger'>Password anda salah.</div>";
            } else {
                $_SESSION['user'] = $data_user;
                if ($data_user['level'] == 'Admin') {
                    header("Location: ".$web_baseurl."admin");
                } else {
                    header("Location: ".$web_baseurl."shop");
                }
            }
        }
        
        if (isset($_POST['forgot'])) {
            $email = $_POST['email'];
            
            $cek_user = $db->query("SELECT * FROM user WHERE email = '$email'");
            
            $password = uniqid();
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            
            if (empty($email)) {
                $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input.</div>";
            } else if (mysqli_num_rows($cek_user) == 0) {
                $pesan = "<div class='alert alert-danger'>Email tidak ditemukan.</div>";
            } else {
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'mail.arull.app';
                $mail->SMTPDebug  = 0;
                $mail->SMTPAuth = true;
                $mail->Username = 'support@arull.app';
                $mail->Password = '-RP(,-S!h{U2';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = '465';
                $mail->setFrom('support@arull.app', configuration('web-name'));
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Lupa Kata Sandi';
                $mail->Body = 'Kata Sandi Baru Anda : '.$password.'';
                if ($mail->Send()) {
                    $update = $db->query("UPDATE user SET password = '$hash_password' WHERE email = '$email'");
                    if ($update) {
                        $pesan = "<div class='alert alert-success'>Lupa Kata Sandi berhasil, Silahkan cek email Anda.</div>";
                    } else {
                        $pesan = "<div class='alert alert-danger'>Lupa Kata Sandi gagal, Sistem sedang error!.</div>";
                    }
                } else {
                    $pesan = "<div class='alert alert-danger'>Lupa Kata Sandi gagal, Sistem sedang error!.</div>";
                }
            }
        }
        
    }

require 'lib/header.php';
require 'lib/navigation-two.php';
?>
<!-- CONTENT -->
<div class="container mt-5 py-5">

    <?php
    if (isset($_POST['register']) OR isset($_POST['login']) OR isset($_POST['forgot'])) {
        echo $pesan;
    }
    if (!$_SESSION['user']) {
    ?>

    <!-- START BEFORE LOGIN -->
    <h4 class="text-center">Dapatkan layanan VIP dengan login 1-klik</h4>
    <ul class="mt-4 text-center" style="list-style-type: none;">
        <li><i class="fa-solid fa-star fs-12"></i> Kamu bisa chat dengan Soulniv</li>
        <li><i class="fa-solid fa-star fs-12"></i> Jadilah yang pertama mendapat diskon khusus</li>
        <li><i class="fa-solid fa-star fs-12"></i> Jangan pernah kehilangan order kamu</li>
    </ul>

    <div class="links-group mt-5 w-50 mx-auto d-flex gap-3">
        <a href="#" class="btn outline-dongker rounded-4 flex-grow-1" data-bs-toggle="modal" data-bs-target="#registerModal">Daftar</a>
        <a href="#" class="btn outline-dongker rounded-4 flex-grow-1" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a>
    </div>

    <div class="content content-profile mt-2 py-5 w-50 mx-auto">

        <ul class="nav nav-tabs border-0 mb-3" id="myTab" role="tablist">
            <li class="nav-item w-50" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Order Saya</button>
            </li>
            <li class="nav-item w-50" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Chat</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane px-4 fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="mt-5 order-heading d-flex justify-content-between align-items-center mb-4">
                    <h5>Order Saya (0)</h5>
                    <select name="statusOrder" id="statusOrder" class="form-control form-select w-25">
                        <option value="">Semua status</option>
                        <option value="">Belum dibayar</option>
                        <option value="">Lunas</option>
                        <option value="">Dikemas</option>
                        <option value="">Terkirim</option>
                        <option value="">Selesai</option>
                        <option value="">Dibatalkan</option>
                        <option value="">Dikembalikan</option>
                    </select>
                </div>
                <input type="text" name="" id="" class="form-control shadow-none" placeholder="Kamu bisa mengecek order kamu dan update-nya di daftar ini" readonly>
            </div>

            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <input type="text" name="" id="" class="form-control shadow-none" placeholder="Kamu bisa mengecek pesan kamu dan update-nya di daftar ini" readonly>
            </div>
        </div>

    </div>

    <!-- MODAL REGISTER -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5">
                <div class="modal-body px-5 text-center">
                    <div class="heading my-5">
                        <h4 class="text-uppercase text-primary">Daftar</h4>
                        <p class="fs-12">Buat akun untuk menjadi anggota kami untuk mendapatkan poin, mendapatkan voucher gratis, dan mendengarkan berita kami lebih awal.</p>
                    </div>

                    <form method="post" id="form-register">

                        <div class="input-group p-2 rounded-4 border border-dark-subtle mb-3">
                            <span class="input-group-text border-0 bg-white" id="basic-addon1"><i class="fa-solid fa-user-pen fs-12"></i></span>
                            <input type="text" name="full_name" class="form-control border-0 shadow-none border-start-0" placeholder="Nama Lengkap" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $full_name; ?>">
                        </div>

                        <div class="input-group p-2 rounded-4 border border-dark-subtle mb-3">
                            <span class="input-group-text border-0 bg-white" id="basic-addon1"><i class="fa-regular fa-envelope fs-12"></i></span>
                            <input type="email" name="email" class="form-control border-0 shadow-none border-start-0" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" value="<?php echo $email; ?>">
                        </div>

                        <div class="input-group p-2 rounded-4 border border-dark-subtle mb-3">
                            <span class="input-group-text border-0 bg-white"><i class="fa-solid fa-lock fs-12"></i></span>
                            <input type="password" name="password" id="passwordInputReg" placeholder="Kata sandi" class="form-control border-0 shadow-none border-start-0" aria-label="showPassword" value="<?php echo $password; ?>">
                            <span id="showPasswordReg" onclick="togglePasswordVisibilityReg()" class="input-group-text border-0 bg-white"><i id="eyeIconReg" class="fa-regular fa-eye-slash fs-12"></i></span>
                            <!-- show password icon change <i class="fa-regular fa-eye"></i> -->
                        </div>

                        <button class="btn outline-dongker rounded-4 w-75 my-2" name="register">Buat Akun</button>
                        <p class="fs-12">Sudah punya akun? <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL LOGIN -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5">
                <div class="modal-body px-5 text-center">
                    <div class="heading my-5">
                        <h4 class="text-uppercase text-primary">masuk</h4>
                        <p class="fs-12">Masukkan akun untuk mendapatkan poin, mendapatkan voucher gratis, dan mendengarkan berita kami lebih awal.</p>
                    </div>

                    <form method="post" id="form-login">

                        <div class="input-group p-2 rounded-4 border border-dark-subtle mb-3">
                            <span class="input-group-text border-0 bg-white" id="basic-addon1"><i class="fa-regular fa-envelope fs-12"></i></span>
                            <input type="text" name="email" class="form-control border-0 shadow-none border-start-0" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" value="<?php echo $email; ?>">
                        </div>

                        <div class="input-group p-2 rounded-4 border border-dark-subtle mb-2">
                            <span class="input-group-text border-0 bg-white"><i class="fa-solid fa-lock fs-12"></i></span>
                            <input type="password" name="password" id="passwordInputLog" placeholder="Kata sandi" class="form-control border-0 shadow-none border-start-0" aria-label="showPassword" value="<?php echo $password; ?>">
                            <span id="showPasswordLog" onclick="togglePasswordVisibilityLog()" class="input-group-text border-0 bg-white"><i id="eyeIconLog" class="fa-regular fa-eye-slash fs-12"></i></span>
                        </div>
                        <span class="fs-12 text-right float-end"><a href="#" class="text-decoration-none text-secondary" data-bs-toggle="modal" data-bs-target="#forgotModal">Lupa kata sandi?</a></span><br>

                        <button class="btn outline-dongker rounded-4 w-75 my-2" name="login">Masuk</button>
                        <p class="fs-12">Belum punya akun? <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#registerModal">Buat akun</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL FOOGOT PASS -->
    <div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="forgotModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5">
                <div class="modal-body p-5 text-center">

                    <div class="heading mb-4 pt-4 d-flex align-items-center text-primary">
                        <i class="fa-solid fa-arrow-left fs-4" data-bs-dismiss="modal"></i>
                        <h4 class="text-uppercase flex-grow-1">Lupa kata sandi</h4>
                    </div>
                    
                    <?php
                    if ($pesan == "<div class='alert alert-success'>Lupa Kata Sandi berhasil, Silahkan cek email Anda.</div>") {
                    ?>
                    <!-- SUCCESS RESET PASSS MESSAGE, HIDDEN BEFORE RESET -->
                    <div class="reset-success">
                        <img src="<?php echo $web_baseurl; ?>assets/images/forgotpass.png" alt="" srcset="">
                        <p class="mt-3 fs-12">Kami telah mengirimkan tautan ke <?php echo $email ?>. Silakan cek email dan ikuti instruksi untuk mengatur ulang kata sandimu</p>
                        <a class="btn outline-dongker rounded-4 w-75 my-2 mt-4" href="#" data-bs-dismiss="modal">Tutup</a>
                    </div>
                    <?php } else { ?>
                    
                    <form method="post" id="form-login">
                        <div class="input-group p-2 rounded-4 border border-dark-subtle mb-3">
                            <span class="input-group-text border-0 bg-white" id="basic-addon1"><i class="fa-regular fa-envelope fs-12"></i></span>
                            <input type="email" name="email" class="form-control border-0 shadow-none border-start-0" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
                        </div>
                        <button type="submit" name="forgot" class="btn outline-dongker rounded-4 w-75 my-2 mt-4">Konfirmasi</button>
                    </form>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- END BEFORE LOGIN -->
    <?php } else { ?>
    
    <!-- AFTER LOGIN -->
    <div class="profile text-center w-75 mx-auto">
        <img src="<?php echo $web_baseurl; ?>assets/images/profile/<?php echo $data_user['profile'] ?>" class="rounded mx-auto d-block" alt="profile-pict">
        <p class="mt-3 fw-semibold"><?php echo $data_user['full_name'] ?></p>
        <a href="#" class="btn outline-dongker rounded-4 w-100 mt-4">Voucher (0)</a>
    </div>

    <!-- TAB ORDER & CHAT -->
    <div class="content content-profile mt-2 py-5 w-75 mx-auto">

        <?php
        if (isset($_POST['send'])) {
            echo $pesan;
        }
        ?>

        <!-- ORDER TABS -->
        <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
            <li class="nav-item w-50" role="presentation">
                <button class="nav-link w-100 active tabs-active" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-saya-pane" type="button" role="tab" aria-controls="order-saya-pane" aria-selected="true">Order Saya</button>
            </li>
            <li class="nav-item rounded-0 w-50" role="presentation">
                <button class="nav-link w-100" id="chat-tab" data-bs-toggle="tab" data-bs-target="#chat-pane" type="button" role="tab" aria-controls="chat-pane" aria-selected="false">Chat</button>
            </li>
        </ul>

        <div class="tab-content" style="min-height: 500px;" id="myTabContent">

            <!-- TAB ORDER SAYA -->
            <div class="tab-pane px-4 fade show active" id="order-saya-pane" role="tabpanel" tabindex="0">
            
                <div class="mt-5 order-heading d-flex justify-content-between align-items-center mb-4">
                    <h5>Order Saya (<?php echo $cek_order; ?>)</h5>
                    <select name="statusOrder" id="statusOrder" class="form-control form-select w-25">
                        <option value="">Semua status</option>
                        <option value="Belum dibayar">Belum dibayar</option>
                        <option value="Lunas">Lunas</option>
                        <option value="Dikemas">Dikemas</option>
                        <option value="Dikirim">Terkirim</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                        <option value="Dikembalikan">Dikembalikan</option>
                    </select>
                </div>
                <!-- ALL PRODUCTS -->
                <div class="list-products d-flex flex-column gap-4" id="order-list">
            
                    <?php
                    $order = mysqli_query($db, "SELECT * FROM order_list WHERE user_id = '$id' ORDER BY id DESC");
                    
                    $orders = [];
                    while ($data_order = mysqli_fetch_array($order)) {
                        $orders[$data_order['order_id']][] = $data_order;
                    }
                    
                    foreach ($orders as $order_id => $items) {
                        $data_order = $items[0];
                        
                        $cek_address = $db->query("SELECT * FROM address WHERE user_id = '".$data_order['user_id']."' ORDER BY id DESC LIMIT 1");
                        $data_address = mysqli_fetch_array($cek_address);
                    ?>
                    <!-- ITEMS -->
                    <div class="card pb-3 rounded-4 border-0 shadow order-item" data-status="<?php echo $data_order['status']; ?>">
                        <div class="card-body d-flex justify-content-between gap-4">
            
                            <img src="<?php echo $web_baseurl; ?>assets/images/product/<?php echo $data_order['product_image']; ?>" width="96" alt="" srcset="">
            
                            <div class="product flex-grow-1 d-flex flex-column justify-content-around">
            
                                <div class="details-product d-flex justify-content-between">
                                    <div class="product">
                                        <span class="fw-semibold"><?php echo $data_order['product_name']; ?></span>
                                        <p>Size : <?php echo $data_order['size']; ?></p>
                                    </div>
                                    <div class="date-price">
                                        <small><?php echo format_date($data_order['created_at']); ?></small>
                                        <p class="text-primary">Rp. <?php echo number_format($data_order['price'], 0, ',', '.'); ?></p>
                                    </div>
                                </div>
                                <?php
                                if ($data_order['status'] == 'Selesai') {
                                ?>
                                
                                <div class="links-group">
                                    <a href="<?php echo $web_baseurl; ?>produk/produk-preview?id=<?php echo $data_order['product_id']; ?>" class="btn btn-outline-secondary px-4 mb-2"><i class="fa-solid fa-repeat font-size-15"></i> Beli lagi</a>
                                    <a href="<?php echo $web_baseurl; ?>produk/produk-rating?id=<?php echo $data_order['id']; ?>" class="btn btn-outline-secondary px-4 mb-2">Rating produk</a>
                                    <a href="javascript:;" onclick="tracking('<?php echo $web_baseurl; ?>cart/tracking?id=<?php echo $data_order['id']; ?>')" class="btn btn-outline-secondary px-4 mb-2">Lacak pesanan</a>
                                </div>
                                <?php } else if ($data_order['status'] !== 'Belum Dibayar' AND $data_order['status'] !== 'Lunas' AND $data_order['status'] !== 'Dibatalkan') { ?>
                                
                                <a href="javascript:;" onclick="tracking('<?php echo $web_baseurl; ?>cart/tracking?id=<?php echo $data_order['id']; ?>')" class="btn btn-outline-secondary w-25">Lacak pesanan</a>
                                <?php } ?>
                                
                            </div>
            
                        </div>
                    </div>
                    <?php } if (empty($orders)) { ?>
                    
                    <p>Pesanan tidak ditemukan</p>
                    <?php } ?>
                    
                </div>
            
            </div>

            <!-- TAB CHAT -->
            <div class="tab-pane px-4 fade" id="chat-pane" role="tabpanel" tabindex="0">

                <div class="messages pt-4">

                    <div class="chat d-flex flex-column gap-3">

                        <?php
                        $chat = mysqli_query($db, "SELECT * FROM chat WHERE user_id = '$id'");
                        $data_chat = mysqli_fetch_array($chat);
                        $chat_reply = mysqli_query($db, "SELECT * FROM chat_reply WHERE chat_id = '".$data_chat['id']."' ORDER BY id ASC");
                        while($data_chat_reply = mysqli_fetch_array($chat_reply)) {
                        ?>
                        
                        <!-- PESAN USER -->
                        <div class="card rounded-5 shadow border-0 <?php echo ($data_chat_reply['sender'] == 'user') ? 'user-chat align-self-end user-chat' : 'admin-chat' ?>" style="<?php echo ($data_chat_reply['sender'] == 'user') ? 'width: max-content;' : 'max-width: 24rem;' ?>">
                            <div class="card-body">
                                <p><?php echo nl2br($data_chat_reply['message']); ?></p>
                                <small class="fs-12"><?php echo format_datetime($data_chat_reply['created_at']); ?> <i class="fa-solid fa-check"></i></small>
                            </div>
                        </div>
                        <?php } ?>

                    </div>

                    <form method="post" class="mt-5">
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <textarea name="pesantext" id="pesantext" placeholder="Ketik pesanmu disini" class="form-control border-0 shadow-none border-start-0"></textarea>
                            <button type="submit" name="send" class="btn"><i class="fa-regular fa-paper-plane fs-4 text-primary"></i></button>
                        </div>
                    </form>
                </div>

            </div>


        </div>

        <!-- Modal LACAK PESANAN -->
        <div class="modal modal-lg fade" id="modal-tracking" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="modal-tracking-content"></div>
            </div>
        </div>

    </div>
    
    <!-- END LOGIN -->
    <?php } ?>


</div>

<script>
    <?php
    if ($pesan == "<div class='alert alert-success'>Lupa Kata Sandi berhasil, Silahkan cek email Anda.</div>") {
    ?>
    
    document.addEventListener('DOMContentLoaded', function() {
        var forgotModal = new bootstrap.Modal(document.getElementById('forgotModal'));
        forgotModal.show();
    });
    <?php } ?>
    
    function togglePasswordVisibilityLog() {
      var passwordInput = document.getElementById("passwordInputLog");
      var eyeIcon = document.getElementById("eyeIconLog");
        toggle(eyeIcon, passwordInput);
    }
    function togglePasswordVisibilityReg() {
      var passwordInput = document.getElementById("passwordInputReg");
      var eyeIcon = document.getElementById("eyeIconReg");
        toggle(eyeIcon, passwordInput);
    }
    function toggle(eyeIcon, passwordInput){
        if (eyeIcon.classList.contains("fa-regular")) {
        eyeIcon.classList.remove("fa-regular", "fa-eye-slash");
        eyeIcon.classList.add("fa-solid", "fa-eye");
        passwordInput.type = "text";
      } else {
        eyeIcon.classList.remove("fa-solid", "fa-eye");
        eyeIcon.classList.add("fa-regular", "fa-eye-slash");
        passwordInput.type = "password";
      }
    }
    
    document.getElementById('statusOrder').addEventListener('change', function() {
        var selectedStatus = this.value;
        var orders = document.querySelectorAll('.order-item');

        orders.forEach(function(order) {
            if (selectedStatus === '' || order.getAttribute('data-status') === selectedStatus) {
                order.style.display = 'block';
            } else {
                order.style.display = 'none';
            }
        });
    });
</script>

<script type="text/javascript">
    function tracking(url) {
        $.ajax({
            type: "GET",
            url: url,
            beforeSend: function() {
                $('#modal-tracking-content').html('Sedang memuat...');
            },
            success: function(result) {
                $('#modal-tracking-content').html(result);
            },
            error: function() {
                $('#modal-tracking-content').html('Terdapat kesalahan, Silakan refresh halaman ini.');
            }
        });
        $('#modal-tracking').modal("show");
    }
</script>

<?php
require 'lib/footer.php';
?>