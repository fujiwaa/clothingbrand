<?php
if (isset($_POST['deleteRecentSearch'])) {
    $_SESSION['recent_searches'] = [];
}
?>

<!-- Modal SEARCH -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered p-2">
    <div class="modal-content position-relative">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="searchModalLabel">Cari Produk</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body position-relative">
        <form action="" method="get">
          <div class="input-group position-relative mb-3">
            <input type="text" name="cari" class="form-control shadow-none border-primary-subtle border-end-0" placeholder="Cari produk" aria-label="cari" aria-describedby="cari">
            <span class="input-group-text border-start-0 border-primary-subtle bg-white" id="basic-addon1"><i class="fa fa-search fs-12 opacity-25"></i></span>
          </div>
        </form>

        <div id="searchBox" class="vstack gap-2 mt-3" style="max-height: 480px;">
          <div class="recentSearch" <?php if (empty($_SESSION['recent_searches'])) echo 'style="display: none;"'; ?>>
            <div class="searchInfo hstack justify-content-between">
              <small>Recent search</small>
              <small><form method="POST"><button type="submit" name="deleteRecentSearch" class="text-danger">Delete recents search</button></form></small>
            </div>
            <div class="hstack gap-2" id="recentSearch"></div>
          </div>
          <div class="vstack gap-2 overflow-y-auto">
            <?php
            $cek_product = $db->query("SELECT * FROM product WHERE status = 'Tersedia'");
            while ($data_product = mysqli_fetch_array($cek_product)) {
                $images = explode(',', $data_product['image']);
            ?>
            
            <a href="<?php echo $web_baseurl; ?>produk/produk-preview?id=<?php echo $data_product['id']; ?>" class="card text-decoration-none">
              <div class="card-body hstack gap-3 p-2">
                <img src="<?php echo $web_baseurl; ?>assets/images/product/<?php echo $images[0]; ?>" width="56" height="56" alt="">
                <div class="vstack justify-content-center">
                  <span class="fw-semibold text-dongker text-uppercase"><?php echo $data_product['name']; ?></span>
                  <small>Rp. <?php echo number_format($data_product['price'], 0, ',', '.'); ?></small>
                </div>
              </div>
            </a>
            <?php } ?>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dongker px-4 py-5">

  <div class="container-fluid">
    <div class="row g-3">

      <div class="col-lg-4">
        <div class="information">
          <span>Soulniv brand from Central Java since 2023, Here it is The first hoodie is limited and will surprise you! Thank you for support!</span>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="payment-delivery d-flex gap-3 flex-column">
          <div class="payment">
            <h6>Metode Pembayaran</h6>
            <div class="list-images d-flex gap-2 flex-wrap">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/qris.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/ovo.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/alfamart.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/mandiri.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/bri.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/bni.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/permata.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/permata syariah.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/danamon.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/bsi.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/bjb.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/visa.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/jcb.png" style="width: 48px; height: 48px;">
              <img src="<?php echo $web_baseurl; ?>assets/pembayaran/mastercard.png" style="width: 48px; height: 48px;">
            </div>
          </div>
          <div class="delivery">
            <h6>Metode Pengiriman</h6>
            <img src="<?php echo $web_baseurl; ?>assets/pengiriman/jne.png" style="width: 48px; height: 48px;" class="object-fit-cover" alt="gambar kurir">
            <img src="<?php echo $web_baseurl; ?>assets/pengiriman/gosend.png" style="width: 48px; height: 48px;" class="object-fit-cover" alt="gambar kurir">
            <img src="<?php echo $web_baseurl; ?>assets/pengiriman/jnt.png" style="width: 48px; height: 48px;" class="object-fit-cover" alt="gambar kurir">
            <img src="<?php echo $web_baseurl; ?>assets/pengiriman/sicepat.png" style="width: 48px; height: 48px;" class="object-fit-cover" alt="gambar kurir">
          </div>
        </div>
      </div>

      <div class="col-lg-2">
        <div class="otherlinks">
          <ul style="list-style-type: none;" class="p-0 h-auto d-flex flex-column gap-3">
            <li><a class="text-light" href="<?php echo $web_baseurl; ?>persyaratan-layanan">Persyaratan Layanan</a></li>
            <li><a class="text-light" href="<?php echo $web_baseurl; ?>kebijakan-privasi">Kebijakan Privasi</a></li>
            <li><a class="text-light" href="<?php echo $web_baseurl; ?>kebijakan-pengiriman">Kebijakan Pengiriman</a></li>
            <li><a class="text-light" href="<?php echo $web_baseurl; ?>kebijakan-pengembalian">Kebijakan Pengembalian</a></li>
            <li><a class="text-light" href="<?php echo $web_baseurl; ?>kebijakan-kekayaan-intelektual">Kebijakan Kekayaan Intelektual</a></li>
          </ul>
        </div>
      </div>

    </div>

  </div>

</footer>

<script src="<?php echo $web_baseurl; ?>assets/js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('#searchModal input[name="cari"]');
        const searchBox = document.querySelector('#searchBox');
        const minSearchLength = 3;
        
        hideAllProducts();
        
        searchInput.addEventListener('input', function () {
            const searchTerm = this.value.trim().toLowerCase();
            
            if (searchTerm.length < minSearchLength) {
                hideAllProducts();
                return;
            }
            filterProducts(searchTerm);
        });
        
        function filterProducts(searchTerm) {
            const products = searchBox.querySelectorAll('.card');
            let anyResults = false;
            
            products.forEach(product => {
                const productName = product.querySelector('.fw-semibold').textContent.trim().toLowerCase();
                if (productName.includes(searchTerm)) {
                    product.style.display = 'block';
                    anyResults = true;
                } else {
                    product.style.display = 'none';
                }
            });
            showNoResultsMessage(!anyResults);
            loadRecentSearch();
        }
        
        function hideAllProducts() {
            const products = searchBox.querySelectorAll('.card');
            products.forEach(product => {
                product.style.display = 'none';
            });
            showNoResultsMessage(false);
        }
        
        function showNoResultsMessage(show) {
            const noResultsMessage = searchBox.querySelector('.no-results-message');
            if (noResultsMessage) {
                noResultsMessage.style.display = show ? 'block' : 'none';
            }
        }
        
        let typingTimer;
        const doneTypingInterval = 10000;
        
        searchInput.addEventListener('input', function () {
            clearTimeout(typingTimer);
            const searchTerm = this.value.trim().toLowerCase();
            
            if (searchTerm.length < minSearchLength) {
                hideAllProducts();
                return;
            }
            
            typingTimer = setTimeout(function() {
                saveRecentSearch(searchTerm);
            }, doneTypingInterval);
            
            filterProducts(searchTerm);
        });
    });
    
    function saveRecentSearch(searchTerm) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'lib/ajax/save-recent-search', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('searchTerm=' + encodeURIComponent(searchTerm));
    }
    
    $('#searchModal').on('show.bs.modal', function (e) {
        loadRecentSearch();
    });
    
    function loadRecentSearch() {
        $.ajax({
            url: '<?php echo $web_baseurl; ?>lib/ajax/load-recent-search',
            type: 'GET',
            success: function (response) {
                $('#recentSearch').html(response);
                if (response.trim() === '') {
                    $('.recentSearch').hide();
                } else {
                    $('.recentSearch').show();
                }
            },
            error: function () {
                $('#recentSearch').html('<small class="text-danger">Failed to load recent searches.</small>');
            }
        });
    }
    
  const inc = document.getElementById('increaseBtn');
  const dec = document.getElementById('decreaseBtn');
  let valProduct = document.getElementById('numberProduct');

  inc.addEventListener('click', (e) => {
    e.preventDefault();
    let currVal = parseInt(valProduct.value);
    if (!isNaN(currVal)) {
      valProduct.value = currVal + 1;
    } else {
      valProduct.value = 1; // If currentValue is NaN, start with 1
    }
  })
  dec.addEventListener('click', (e) => {
    e.preventDefault();
    let currVal = parseInt(valProduct.value);
    if (!isNaN(currVal) && currVal > 0) {
      valProduct.value = currVal - 1;
    } else {
      valProduct.value = 0; // Ensure quantity doesn't go below zero
    }
  })

  function increaseQuantity(inputId) {
    var inputElement = document.getElementById(inputId);
    var currentValue = parseInt(inputElement.value);

    if (!isNaN(currentValue)) {
      inputElement.value = currentValue + 1;
    } else {
      inputElement.value = 1; // If currentValue is NaN, start with 1
    }
  }

  function decreaseQuantity(inputId) {
    var inputElement = document.getElementById(inputId);
    var currentValue = parseInt(inputElement.value);

    if (!isNaN(currentValue) && currentValue > 0) {
      inputElement.value = currentValue - 1;
    } else {
      inputElement.value = 0; // Ensure quantity doesn't go below zero
    }
  }
  // COPY
  function copyToClipboard() {
    const buttonCopy = document.getElementById('copyBtn');
    const valuePaymentToCopy = document.getElementById('numberPaymentValue');
    navigator.clipboard.writeText(valuePaymentToCopy.textContent);
  }

  // RATING
  const stars = document.querySelectorAll(".stars i");
  stars.forEach((star, index1) => {
    star.addEventListener("click", () => {
      stars.forEach((star, index2) => {
        index1 >= index2 ? star.classList.add("active") : star.classList.remove("active");
      });
    });
  });

  function previewImage() {
    const fotoRatingProduk = document.getElementById('fotoRatingProduk');
    const imagePreview = document.getElementById('imagePreview');

    // Ensure a file is selected
    if (fotoRatingProduk.files && fotoRatingProduk.files[0]) {
      const reader = new FileReader();

      reader.onload = function(e) {
        // Set the source of the image to the result of the FileReader
        imagePreview.src = e.target.result;
      }

      // Read the image file as a data URL
      reader.readAsDataURL(fotoRatingProduk.files[0]);
    }
  }
  document.getElementById('fotoRatingProduk').addEventListener('change', previewImage);



  //   btnIncrease.addEventListener('click', (e) => {
  //       e.preventDefault();
  //       numberProduct.value + 1;
  //   });
</script>

</html>