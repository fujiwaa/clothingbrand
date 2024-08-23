<?php
session_start();
require '../config.php';
$title = 'Buat Pengiriman';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);
    
    if (isset($_POST['create'])) {
        $namalengkap = $_POST['namalengkap'];
        $nomorhp = $_POST['nomorhp'];
        $negara = $_POST['negara'];
        $kotakec = $_POST['kotakec'];
        $alamat = $_POST['alamat'];
        $kodepos = $_POST['kodepos'];
        $email = $_POST['email'];
        
        if (empty($namalengkap) || empty($nomorhp) || empty($negara) || empty($kotakec) || empty($alamat) || empty($email)) {
            $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input.</div>";
        } else {
        
            // Data yang akan dikirim melalui POST request
            $data = array(
                'name' => 'Pelanggan ['.$namalengkap.']',
                'contact_name' => $namalengkap,
                'contact_phone' => $nomorhp,
                'address' => ''.$alamat.' '.$kotakec.' '.$negara.'',
                'note' => '',
                'postal_code' => $kodepos,
                'latitude' => '',
                'longitude' => ''
            );
            
            // Encode data menjadi JSON
            $jsonData = json_encode($data);
            
            // API key untuk otorisasi
            $api_key = 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiU09VTE5JViIsInVzZXJJZCI6IjY2OWFkMjM1YzYzMTgwMDAxMmEwM2I4ZCIsImlhdCI6MTcyMjAyNzY5Nn0.rdVVVGyxz8RjX9PLqHFztZRHLiJtaKD_UwsYLWKwX-U';
            
            // Set header untuk request
            $headers = array(
                'Authorization: ' . $api_key,
                'Content-Type: application/json',
            );
            
            // Inisialisasi cURL
            $ch = curl_init();
            
            // Set URL endpoint yang akan diakses
            curl_setopt($ch, CURLOPT_URL, 'https://api.biteship.com/v1/locations');
            
            // Set metode HTTP POST
            curl_setopt($ch, CURLOPT_POST, 1);
            
            // Set data yang akan dikirim melalui body request
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            
            // Set header yang akan dikirim
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            // Agar hasil respons tidak langsung ditampilkan ke layar
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Eksekusi cURL dan simpan hasil respons
            $response = curl_exec($ch);
            
            // Cek apakah ada error dalam proses cURL
            if(curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            
            // Tutup cURL
            curl_close($ch);
            
            $result = json_decode($response, true);
            
            if ($result['success'] == true) {
                $location_id = $result['id'];
                
                $insert = $db->query("INSERT INTO address (user_id, location_id, full_name, phone, country, city, address, postal_code, email, created_at, updated_at) VALUES ('$id', '$location_id', '$namalengkap', '$nomorhp', '$negara', '$kotakec', '$alamat', '$kodepos', '$email', '$datetime', '$datetime')");
                if ($insert) {
                    $pesan = "<div class='alert alert-success'>Alamat Pengiriman berhasil ditambahkan.</div>";
                } else {
                    $pesan = "<div class='alert alert-success'>Alamat Pengiriman gagal ditambahkan, Sistem sedang error!</div>";
                }
            } else {
                $pesan = "<div class='alert alert-success'>Alamat Pengiriman gagal ditambahkan, API Sistem sedang error!</div>";
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
                    if (isset($_POST['create'])) {
                        echo $pesan;
                    }
                    ?>
                    
                    <form method="post">
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="text" name="namalengkap" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Nama lengkap penerima" value="<?php echo $namalengkap; ?>">
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="tel" name="nomorhp" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Nomor HP penerima" value="<?php echo $nomorhp; ?>">
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="text" name="negara" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Negara" value="<?php echo $negara; ?>">
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="text" name="kotakec" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Kota dan kecamatan" value="<?php echo $kotakec; ?>">
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <textarea name="alamat" id="alamat" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Detail alamat"><?php echo $alamat; ?></textarea>
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="text" name="kodepos" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Kode POS" value="<?php echo $kodepos; ?>">
                        </div>
                        <div class="input-group p-2 rounded-4 border border-primary mb-3">
                            <input type="email" name="email" class="form-control bg-body-tertiary border-0 shadow-none border-start-0" placeholder="Alamat email" value="<?php echo $email; ?>">
                        </div>
                        <div class="button-group hstack gap-3 justify-content-center">
                            <a href="<?php echo $web_baseurl; ?>settings/info-pengiriman" style="width: 16rem;" class="btn btn-outline-primary rounded-4">Batal</a>
                            <button style="width: 16rem;" type="submit" name="create" class="btn btn-outline-primary rounded-4">Simpan</button>
                        </div>
                    </form>
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