<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/functions.inc.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>E&amp;H Construction</title>
    <script>
        window.onload = function() {
            document.getElementById('at').innerHTML = '@'; 
        };
    </script>
    <?php include($path.'/library/includes/style.pack.php'); ?>
</head>
<body>
    <div class="body-height">
    <?php include($path.'/library/includes/framework/head.inc.php'); ?>
    <article class="p-20 pos-a pos-sw-corner">
        <img src="/images/brent.jpg" alt="Brent Heath" />
        <h2 class="little-line mb-0" style="font-size:2.0em;">Brent Heath</h2>
        <p class="mt-0" style="font-size:1.3em !important;">
            <span ><a href="mailto:info@ehconstructionco.com" class="c-white">info<span id="at">{at}</span>ehconstructionco.com</a></span><br><br>
            <span>phone: <a href="tel:14254864049" class="c-white">+1 425 486 4049</a></span><br>
            <span>mobile: <a href="tel:12062341932" class="c-white">+1 206 234 1932</a></span>
        </p>
    </article>
    </div>
</body>
<?php include($path.'/library/includes/script.pack.php'); ?>
</html>