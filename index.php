<?php
session_start();
require 'config.php';
$title = 'Home';
require 'lib/header.php';
require 'lib/navigation-one.php';
?>
<!-- CAROUSELS -->
<div class="container-fluid p-0" class="margin-top: -100px;">


  <div id="carousel-section" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="<?php echo $web_baseurl; ?>assets/bg-1.png" class="d-block w-100" alt="carousels image">
      </div>
      <div class="carousel-item">
        <img src="<?php echo $web_baseurl; ?>assets/bg-1.png" class="d-block w-100" alt="carousels image">
      </div>
      <div class="carousel-item">
        <img src="<?php echo $web_baseurl; ?>assets/bg-1.png" class="d-block w-100" alt="carousels image">
      </div>
    </div>
  </div>
</div>

<!-- CONTENT -->
<div class="container-fluid p-0">

  <!-- READY STOK -->
  <section id="stok" class="d-flex flex-column gap-3 align-items-center justify-content-center py-5">
    <h2 class="text-center text-uppercase">READY STOK</h2>

    <div class="content" style="max-width: 840px;">
      <div class="row justify-content-center g-4">
        <?php
        $product = mysqli_query($db, "SELECT * FROM product WHERE status = 'Tersedia' AND display = 'Ya' ORDER BY id DESC");
        while($data_product = mysqli_fetch_array($product)) {
        $images = explode(',', $data_product['image']);
        ?>
        
        <div class="col-md-6">
          <a href="<?php echo $web_baseurl; ?>produk/produk-preview?id=<?php echo $data_product['id']; ?>" class="text-decoration-none">
            <div class="card h-100 border-0">
              <img src="<?php echo $web_baseurl; ?>assets/images/product/<?php echo $images[0]; ?>" class="" alt="...">
              <div class="card-body">
                <span class="badge rounded-0 text-bg-dark mb-2"><small><?php echo ($data_product['stock'] > 0) ? 'Ada Stok' : 'Habis' ?></small></span>
                <span class="d-block"><?php echo $data_product['name']; ?></span>
                <span>Rp. <?php echo number_format($data_product['price'],0,',','.'); ?></span>
                <span class="fs-12 mt-1 d-block"><i class="fa-solid fa-star"> <?php echo $data_product['rating']; ?></i></span>
              </div>
            </div>
          </a>
        </div>
        <?php } ?>
        
      </div>
    </div>

  </section>

  <!-- KATEGORI -->
  <section id="kategori" class="bg-body-tertiary d-flex flex-column gap-3 align-items-center justify-content-center py-5">
    <h2 class="text-center text-uppercase">Kategori</h2>

    <div class="content" style="max-width: 840px;">
      <div class="row g-2">
        <div class="col-md-6">
          <a href="<?php echo $web_baseurl; ?>produk/produk-kategori?category=LIMITED EDITION" class="text-decoration-none">
            <div class="card text-center text-white rounded-0 h-100 position-relative">
              <span class="fs-1 w-100 position-absolute top-50 start-50 translate-middle">LIMITED EDITION</span>
              <img src="<?php echo $web_baseurl; ?>assets/images/category/limited-edition.png" class="" alt="...">
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="<?php echo $web_baseurl; ?>produk/produk-kategori?category=TSHIRT" class="text-decoration-none">
            <div class="card text-center text-white rounded-0 h-100 position-relative">
              <span class="fs-1 w-100 position-absolute top-50 start-50 translate-middle">TSHIRT</span>
              <img src="<?php echo $web_baseurl; ?>assets/images/category/tshirt.png" class="" alt="...">
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="<?php echo $web_baseurl; ?>produk/produk-kategori?category=HOODIE" class="text-decoration-none">
            <div class="card text-center text-white rounded-0 h-100 position-relative">
              <span class="fs-1 w-100 position-absolute top-50 start-50 translate-middle">HOODIE</span>
              <img src="<?php echo $web_baseurl; ?>assets/images/category/hoodie.png" class="" alt="...">
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="<?php echo $web_baseurl; ?>produk/produk-kategori?category=WORKSHIRT" class="text-decoration-none">
            <div class="card text-center text-white rounded-0 h-100 position-relative">
              <span class="fs-1 w-100 position-absolute top-50 start-50 translate-middle">WORKSHIRT</span>
              <img src="<?php echo $web_baseurl; ?>assets/images/category/workshirt.png" class="" alt="...">
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="<?php echo $web_baseurl; ?>produk/produk-kategori?category=LONGSLEEVE" class="text-decoration-none">
            <div class="card text-center text-white rounded-0 h-100 position-relative">
              <span class="fs-1 w-100 position-absolute top-50 start-50 translate-middle">LONGSLEEVE</span>
              <img src="<?php echo $web_baseurl; ?>assets/images/category/longsleeve.png" class="" alt="...">
            </div>
          </a>
        </div>

      </div>
    </div>

  </section>

</div>

<?php
require 'lib/footer.php';
?>