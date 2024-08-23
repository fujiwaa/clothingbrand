<div class="card rounded-5 border-primary py-5">
    <div class="card-body vstack justify-content-center gap-4">
        <a href="<?php echo $web_baseurl; ?>settings/info-profil" class="text-decoration-none <?php echo (strpos($_SERVER['REQUEST_URI'], 'settings/info-profil') == true && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === "/settings/info-profil") ? 'text-primary' : 'text-dark' ?> ps-5 rounded-3"><i class="fa fa-user font-size-15"></i> Info profil saya</a>
        <a href="<?php echo $web_baseurl; ?>settings/info-pengiriman" class="text-decoration-none <?php echo (strpos($_SERVER['REQUEST_URI'], 'settings/info-pengiriman') == true && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === "/settings/info-pengiriman") ? 'text-primary' : 'text-dark' ?> ps-5 rounded-3"><i class="fa-solid fa-truck"></i> Informasi pengiriman</a>
        <a href="<?php echo $web_baseurl; ?>settings/info-akun" class="text-decoration-none <?php echo (strpos($_SERVER['REQUEST_URI'], 'settings/info-akun') == true && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === "/settings/info-akun") ? 'text-primary' : 'text-dark' ?> ps-5 rounded-3"><i class="fa-solid fa-user-shield"></i> Informasi akun</a>
        <a href="<?php echo $web_baseurl; ?>logout" class="text-decoration-none text-dark ps-5 rounded-3"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
    </div>
</div>