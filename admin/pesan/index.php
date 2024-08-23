<?php
session_start();
require '../../config.php';
$title = 'Pesan';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);

    require '../../lib/admin/header.php';
?>
<div class="container-fluid p-0 vh-100 bg-body-secondary d-flex position-relative">

    <?php include '../../lib/admin/sidebar.php'; ?>

    <div class="main w-100 px-5 overflow-auto">

        <div class="top-nav d-flex justify-content-between pt-4 align-items-center">
            <h4>Pesan</h4>
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
            $linkActive = 'border-2 border-primary border-bottom';
            $textActive = 'text-dongker';
            ?>
            <!-- TABS -->
            <div class="nav-tab" style="width: 24rem;">
                <ul style="list-style-type: none;" class="d-flex p-0 justify-content-between">
                    <li class="p-2 <?php echo (!$_GET) ? $linkActive : 'border-bottom' ?>"><a href="<?= $web_baseurl; ?>admin/pesan/index" class="text-decoration-none text-dongker <?php echo (!$_GET) ? '' : 'text-secondary' ?>">Semua</a></li>
                    <li class="p-2 <?php echo (isset($_GET['belum-dibaca'])) ? $linkActive : 'border-bottom' ?>"><a href="<?= $web_baseurl; ?>admin/pesan/index?belum-dibaca" class="text-decoration-none <?php echo (isset($_GET['belum-dibaca'])) ? $textActive : 'text-secondary' ?>">Belum Dibaca</a></li>
                    <li class="p-2 <?php echo (isset($_GET['sudah-dibaca'])) ? $linkActive : 'border-bottom' ?>"><a href="<?= $web_baseurl; ?>admin/pesan/index?sudah-dibaca" class="text-decoration-none <?php echo (isset($_GET['sudah-dibaca'])) ? $textActive : 'text-secondary' ?>">Sudah Dibaca</a></li>
                </ul>
            </div>

            <div class="mt-5 pb-4">
                <!-- CARI -->
                <form action="" method="get">
                    <div class="d-flex gap-4">
                        <div class="input-group rounded-4 p-1 border border-dark">
                            <span id="showPassword" class="input-group-text border-0 bg-body-secondary"><i class="fa-solid fa-magnifying-glass fs-6"></i></span>
                            <input type="text" name="sender_name" placeholder="Cari nama pengirim" class="form-control bg-body-secondary border-0 shadow-none border-start-0" aria-label="showPassword">
                        </div>
                        <button class="btn bg-dongker w-25 rounded-4 btn-outline-primary">Cari</button>
                    </div>
                </form>

                <!-- LIST PESANAN -->
                <div class="messages-list mt-3 d-flex flex-column gap-3">
                    <?php
                    $query = "SELECT chat.*, user.full_name AS sender_name, user.profile AS sender_profile FROM chat LEFT JOIN user ON chat.user_id = user.id";

                    if (isset($_GET['belum-dibaca'])) {
                        $query .= " WHERE status = 'Belum Dibaca'";
                    } elseif (isset($_GET['sudah-dibaca'])) {
                        $query .= " WHERE status = 'Sudah Dibaca'";
                    }

                    if (isset($_GET['sender_name'])) {
                        $sender_name = $_GET['sender_name'];
                        if (strpos($query, 'WHERE') !== false) {
                            $query .= " AND user.full_name LIKE '%$sender_name%'";
                        } else {
                            $query .= " WHERE user.full_name LIKE '%$sender_name%'";
                        }
                    }

                    $query .= " ORDER BY chat.id DESC";

                    $chat = mysqli_query($db, $query);
                    while ($data_chat = mysqli_fetch_array($chat)) {
                        $chat_reply = mysqli_query($db, "SELECT * FROM chat_reply WHERE chat_id = '".$data_chat['id']."' ORDER BY id ASC LIMIT 1");
                        $data_chat_reply = mysqli_fetch_array($chat_reply);

                        // Format waktu chat
                        $chat_time = date('H:i', strtotime($data_chat['created_at']));

                        // Menentukan status pesan sudah dibaca atau belum
                        $is_read = $data_chat_reply['status'] == 'Sudah Dibaca' ? 'SUDAH DIBACA' : '';
                        $is_read_class = $data_chat_reply['status'] == 'Sudah Dibaca' ? 'text-success' : 'text-danger';
                        
                        $unread_count_query = mysqli_query($db, "SELECT COUNT(*) AS total_unread FROM chat_reply WHERE chat_id = '".$data_chat['id']."' AND is_read_admin = 0");
                        $unread_count_result = mysqli_fetch_array($unread_count_query);
                        $total_unread_count = $unread_count_result['total_unread'];
                    ?>
                    
                    <div class="card border-0 shadow rounded-4">
                        <div class="card-body d-flex justify-content-between gap-3">
                            <img src="<?= $web_baseurl; ?>assets/images/profile/<?php echo $data_chat['sender_profile']; ?>" width="48" height="48" alt="">
                            <div class="flex-grow-1">
                                <span class="fw-semibold"><?php echo $data_chat['sender_name']; ?></span>
                                <span class="<?php echo $is_read_class; ?> fw-semibold"><?php echo $is_read; ?></span>
                                <p><?php echo $data_chat_reply['message']; ?></p>
                            </div>
                            <div class="time d-flex flex-column align-items-center gap-1">
                                <small class="fs-12"><?php echo $chat_time; ?></small>
                                <?php if ($data_chat['status'] == 'Belum Dibaca') { ?>
                                    <span class="badge text-bg-secondary rounded-circle" style="width: 24px; height: 24px"><?php echo $total_unread_count; ?></span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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