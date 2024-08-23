<?php
session_start();
require 'config.php';
$title = 'About';
require 'lib/header.php';
require 'lib/navigation-two.php';
?>
<!-- CONTENT -->
<div class="container-fluid text-white d-flex flex-column gap-5 p-0 text-center pt-5" style="height: 560px; background-image: url('<?php echo $web_baseurl; ?>assets/bg-1.png'); background-repeat: no-repeat; background-size: cover;">
    <h1 class="mt-5">About Us</h1>
    <div class="description mx-auto p-2" style="max-width: 840px;">
        <p>Soulniv was born as a form of our dedication to presenting fashion trends that not only inspire, but also become part of the lifestyle for young people in Central Java since 2023. From comfortable hoodies to classy t-shirts and workshirts, Soulniv is committed to offering high quality products which reflects the creative spirit and dynamic lifestyle of today's generation. As owners of Soulniv, we are part of a young community that always brings innovation and courage to every design we create. Join us on a fashion journey full of passion and inspiration!</p>
    </div>
</div>

<?php
require 'lib/footer.php';
?>