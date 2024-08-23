<?php
session_start();
require 'config.php';
$title = 'Kebijakan Privasi';
require 'lib/header.php';
require 'lib/navigation-two.php';
?>
<!-- CONTENT -->

<div class="container-fluid py-5 bg-secondary-subtle" style="min-height: 480px;">
    <div class="card w-50 mx-auto">
      <div class="card-header bg-white border-0 d-flex justify-content-between">
        <span>Privacy Policy</span>
        <span>
            <i class="fa-solid fa-chevron-up"></i>
        </span>
      </div>
      <div class="card-body">
        <p class="fw-bold">Kebijakan Privasi adalah ketentuan mengenai jenis informasi pribadi milik Pembeli yang didapatkan, bagaimana penggunaan informasi tersebut dan mengenai cara penyimpanan informasi. </p>
        <p class="fw-bold"><u>Perlindungan Informasi Pribadi</u></p>
        <ol>
            <li>Dalam memberikan layanan terbaik kepada Pembeli, Soulniv akan memerlukan data Pembeli sebagai berikut: nama, alamat, nomor telepon, email, dan bukti transfer pembayaran (“Data”)
            </li>
            <li>Dengan melengkapi Form Pesanan, Pembeli dianggap menyetujui untuk memberikan Data kepada Soulniv untuk keperluan pengiriman Produk dan Soulniv dengan ini berjanji dan menjamin kerahasiaan Data yang diberikan kepada PraedaeStudi
            </li>
        </ul>
      </div>
    </div>
</div>

<?php
require 'lib/footer.php';
?>