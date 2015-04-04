<?php
/**
 * index.tmpl.php
 * ~~~~~~~~~~~~~~
 *
 * Anasayfa'nın template dosyası.
 *
 *
 *
 * *.tmpl dosyalarında daha çok değişkenler ile ilgili işlemler olmalı.
 */
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>
        <?php echo SITE_ADI; ?>
    </title>
    <link rel="stylesheet" href="static/css/style.css"/>
</head>
<body>

    <p>Index vs...</p>

    <a href="?sayfa=iletisim">İletişim</a>
    <br/>
    <a href="?sayfa=">Anasayfa.PHP</a>

    HR'ler arası include'lar...

    <hr/>
    <!-- Template'lerin eklenmesi. -->
    <?php
    templateEkle();
    ?>

    <hr/>

    FOOTER vs...
</body>
</html>