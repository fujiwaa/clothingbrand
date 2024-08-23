<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?> - <?php echo configuration('web-name') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/1a19584ede.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo $web_baseurl; ?>assets/css/style.css">
    <style>
      .fs-12{
        font-size: 12px;
      }
    </style>
  </head>
  <body class="position-relative">

    <header class="position-absolute w-100" style="z-index: 1;">
      <nav class="navbar navbar-expand-lg">
        <div class="container pt-3 d-flex" style="height: 100px;">
            <a class="navbar-brand align-self-start" href="#">
                <img src="<?php echo $web_baseurl; ?>assets/logo.png" alt="Logo" width="100">
            </a>
            <div class="align-self-end collapse navbar-collapse justify-content-center" id="navbarNav">
                  <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link text-white" href="<?php echo $web_baseurl; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?php echo $web_baseurl; ?>auth">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?php echo $web_baseurl; ?>about">About Usss</a>
                    </li>
                </ul>
            </div>
            <div class="align-self-start d-flex justify-content-around align-items-center" style="width: 256px;">
                <a class="nav-link text-white border border-white rounded py-2 px-3 font-size-11 mr-2" href="">
                    Indonesia
                </a>
                <a class="nav-link text-white" href="<?php echo $web_baseurl; ?>cart/cart">
                    <i class="fa fa-shopping-cart font-size-15"></i>
                </a>
                <a class="nav-link text-white" href="javascript:;">
                    <i class="fa fa-search font-size-15"></i>
                </a>
                <a class="nav-link text-white" href="<?php echo $web_baseurl; ?>settings">
                    <i class="fa fa-user font-size-15"></i>
                </a>
            </div>
        </div>
      </nav>
    </header>