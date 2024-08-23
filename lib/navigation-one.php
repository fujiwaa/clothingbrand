<!--<header class="position-absolute w-100" style="z-index: 1;">-->
<nav class="navbar sticky-top navbar-expand-lg bg-light">
    <div class="container pt-3 d-flex" style="height: 100px;">
        <a class="navbar-brand align-self-start" href="<?php echo $web_baseurl; ?>">
            <img src="<?php echo $web_baseurl; ?>assets/images/logo.png" alt="Logo" width="100">
        </a>
        <div class="align-self-end collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link text-dongker fw-bold" href="<?php echo $web_baseurl; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $web_baseurl; ?>shop">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $web_baseurl; ?>about">About Us</a>
                </li>
            </ul>
        </div>
        <div class="align-self-start d-flex justify-content-around align-items-center" style="width: 220px;">
            <a class="nav-link border border-dark rounded py-2 px-2 font-size-11 mr-1" href="">
                Indonesia
            </a>
            <a class="nav-link" href="<?php echo $web_baseurl; ?>cart/cart">
                <i class="fa fa-shopping-cart font-size-15"></i>
            </a>
            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#searchModal" href="<?php echo $web_baseurl; ?>">
                <i class="fa fa-search font-size-15"></i>
            </a>
            <a class="nav-link" href="<?php echo $web_baseurl; ?>profile">
                <i class="fa fa-user font-size-15"></i>
            </a>
        </div>
    </div>
</nav>
<!--</header>-->