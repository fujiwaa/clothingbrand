<?php
session_start();
require '../config.php';
$title = 'Ubah Pengiriman';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);
    
    if (isset($_GET['id'])) {
        $address_id = $_GET['id'];
        $cek_address = $db->query("SELECT * FROM address WHERE id = '$address_id'");
        $data_address = mysqli_fetch_assoc($cek_address);
        if (mysqli_num_rows($cek_address) == 0) {
            header("Location: ".$web_baseurl."settings/info-pengiriman");
        } else {
            
            if (isset($_POST['save'])) {
                $namalengkap = $_POST['namalengkap'];
                $nomorhp = $_POST['nomorhp'];
                $negara = $_POST['negara'];
                $kotakec = $_POST['kotakec'];
                $alamat = $_POST['alamat'];
                $email = $_POST['email'];
                
                if (empty($namalengkap) || empty($nomorhp) || empty($negara) || empty($kotakec) || empty($alamat) || empty($email)) {
                    $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input.</div>";
                } else {
                    $update = $db->query("UPDATE address SET full_name = '$namalengkap', phone = '$nomorhp', country = '$negara', city = '$kotakec', address = '$alamat', email = '$email', updated_at = '$datetime' WHERE id = '$address_id'");
                    if ($update) {
                        $pesan = "<div class='alert alert-success'>Alamat Pengiriman berhasil diubah.</div>";
                    } else {
                        $pesan = "<div class='alert alert-success'>Alamat Pengiriman gagal diubah, Sistem sedang error!</div>";
                    }
                }
            }

require '../lib/header.php';
require '../lib/navigation-two.php';
?>
<!-- CONTENT -->
<div class="container mt-5 py-5">
    <div class="row justify-content-center gap-2">
        <div class="col-md-4">
            <div class="card rounded-5 border-primary py-5">
                <div class="card-body vstack justify-content-center gap-4">
                    <a href="<?php echo $web_baseurl; ?>settings/info-profil" class="text-decoration-none text-dark ps-5 rounded-3"><i class="fa fa-user font-size-15"></i> Info profil saya</a>
                    <a href="<?php echo $web_baseurl; ?>settings/info-pengiriman" class="text-decoration-none text-primary ps-5 rounded-3"><i class="fa-solid fa-truck"></i> Informasi pengiriman</a>
                    <a href="<?php echo $web_baseurl; ?>settings/info-akun" class="text-decoration-none text-dark ps-5 rounded-3"><i class="fa-solid fa-user-shield"></i> Informasi akun</a>
                    <a href="#" class="text-decoration-none text-dark ps-5 rounded-3"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card h-100 pb-4 rounded-5 border-0 bg-body-tertiary">
                <div class="card-body d-flex flex-column gap-3 px-5">
                    <a href="<?php echo $web_baseurl; ?>settings/info-pengiriman" class="text-decoration-none align-self-end"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                    <?php
                    if (isset($_POST['save'])) {
                        echo $pesan;
                    }
                    ?>
                    
                    <form method="post">
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="text" name="namalengkap" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Nama lengkap penerima" value="<?php echo $data_address['full_name']; ?>">
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="tel" name="nomorhp" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Nomor HP penerima" value="<?php echo $data_address['phone']; ?>">
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="text" name="negara" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Negara" value="<?php echo $data_address['country']; ?>">
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="text" name="kotakec" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Kota dan kecamatan" value="<?php echo $data_address['city']; ?>">
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <textarea name="alamat" id="alamat" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Detail alamat"><?php echo $data_address['address']; ?></textarea>
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="email" name="email" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Alamat email" value="<?php echo $data_address['email']; ?>">
                        </div>
                        <div class="button-group hstack gap-3 justify-content-center">
                            <a href="<?php echo $web_baseurl; ?>settings/info-pengiriman" style="width: 16rem;" class="btn btn-outline-primary rounded-4">Batal</a>
                            <button style="width: 16rem;" type="submit" name="save" class="btn btn-outline-primary rounded-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }
} else {
    header("Location: ".$web_baseurl."settings/info-pengiriman");
}
require '../lib/footer.php';
} else {
	header("Location: ".$web_baseurl."profile");
}
?>