<!--<header class="w-100" style="z-index: 1;">-->
<nav class="navbar sticky-top navbar-expand-lg bg-light">
    <div class="container pt-3 d-flex" style="height: 100px;">
        <a class="navbar-brand align-self-start" href="<?php echo $web_baseurl; ?>">
            <img src="<?php echo $web_baseurl; ?>assets/images/logo.png" alt="Logo" width="100px">
        </a>
        <div class="align-self-end collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link<?php echo (strpos($_SERVER['REQUEST_URI'], '') == true && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === "/") ? ' text-dongker fw-bold' : '' ?>" href="<?php echo $web_baseurl; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php echo (strpos($_SERVER['REQUEST_URI'], 'shop') == true && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === "/shop") ? ' text-dongker fw-bold' : '' ?>" href="<?php echo $web_baseurl; ?>shop">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php echo (strpos($_SERVER['REQUEST_URI'], 'about') == true && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === "/about") ? ' text-dongker fw-bold' : '' ?>" href="<?php echo $web_baseurl; ?>about">About Us</a>
                </li>
            </ul>
        </div>
        <div class="align-self-start d-flex justify-content-around align-items-center" style="width: 220px;">
            <a class="nav-link border border-dark rounded py-2 px-2 font-size-11 mr-1" href="">
                Indonesia
            </a>
            <a class="nav-link text-dark" href="<?php echo $web_baseurl; ?>cart/cart">
                <i class="fa fa-shopping-cart font-size-15"></i>
            </a>
            <a class="nav-link text-dark" data-bs-toggle="modal" data-bs-target="#searchModal" href="<?php echo $web_baseurl; ?>">
                <i class="fa fa-search font-size-15"></i>
            </a>
            <?php if (strpos($_SERVER['REQUEST_URI'], 'profile') == true && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === "/profile") { ?>

                <!-- ICON BERUBAH WAKTU HALAMAN /profile -->
                <a class="nav-link text-dark" href="<?php echo $web_baseurl; ?>settings">
                    <i class="fa-solid fa-gear"></i>
                </a>
            <?php } else { ?>

                <a class="nav-link text-dark" href="<?php echo $web_baseurl; ?>profile">
                    <i class="fa fa-user font-size-15"></i>
                </a>
            <?php } ?>

        </div>
    </div>
</nav>
<!--</header>-->