<?php
session_start();
require 'config.php';
$title = 'Kebijakan Pengiriman';
require 'lib/header.php';
require 'lib/navigation-two.php';
?>
<!-- CONTENT -->

<div class="container-fluid py-5 bg-secondary-subtle" style="min-height: 480px;">
    <div class="card w-50 mx-auto">
      <div class="card-header bg-white border-0 d-flex justify-content-between">
        <span>Shipping Policy</span>
        <span>
            <i class="fa-solid fa-chevron-up"></i>
        </span>
      </div>
      <div class="card-body">
        <p class="fw-bold">Kebijakan Pengiriman merupakan ketentuan penting terkait informasi pengiriman ketika Pembeli membuat pesanan, yang berisi detil mengenai metode dan biaya pengiriman, waktu pengiriman dan hal lainnya.</p>
        <p class="fw-bold"><u>Pengiriman</u></p>
        <ol>
            <li>Kecuali Pembeli memilih pembayaran dengan cara COD, Pesanan akan segera diproses dan dikirimkan setelah pembayaran lunas. Soulniv akan memberitahukan Pembeli melalui sms atau whatsapp, informasi mengenai status pengiriman, nomor resi pengiriman, tanggal pengiriman, dan perkiraan waktu Pesanan akan sampai tujuan. Apabila Pembeli memiliki akun di Situs Soulniv, Pembeli dapat memantau status Pesanan di fitur “Pesanan Saya”. Pembeli dapat juga menghubungi fitur chat atau nomor yang tertera di situs web untuk menanyakan status pengiriman Pesanan.
            </li>
            <li>Pesanan akan dikirimkan ke alamat yang tercantum di Form Pesanan. Soulniv tidak bertanggung jawab atas kesalahan penulisan alamat oleh Pembeli. Apabila Pembeli menemukan kesalahan penulisan alamat di Form Pesanan, Pembeli dapat segera menghubungi Toko Online melalui fitur chat atau nomor yang tertera di situs web
            </li>
            <li>Pengiriman dilakukan oleh pihak penyedia jasa pengiriman yang dipilih Pembeli dalam Form Pesanan. </li>
            <li>Biaya jasa pengiriman dapat bervariasi tergantung dari berat Produk dan jarak/wilayah pengiriman. Biaya jasa pengiriman sepenuhnya ditanggung oleh Pembeli.</li>
            <li>Lama waktu pengiriman adalah sesuai dengan yang telah diinformasikan dalam Form Pesanan ketika Pembeli memilih pihak penyedia jasa pengiriman. Soulniv tidak menjamin dan bertanggung jawab atas keterlambatan pengiriman dari pihak penyedia jasa pengiriman. Ganti rugi atas keterlambatan atau kehilangan tunduk sepenuhnya pada ketentuan pihak penyedia jasa pengiriman</li>
            <li>Untuk pengiriman dengan cara COD, apabila setelah 3x (tiga) kali berturut-turut petugas jasa pengiriman tiba di alamat tujuan dan tidak ada siapa pun yang hadir untuk menerima Pesanan dan melunasi pembayaran, maka Pesanan dianggap batal.</li>
        </ul>
      </div>
    </div>
</div>

<?php
require 'lib/footer.php';
?>