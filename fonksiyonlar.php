<?php
/**
 * fonksiyonlar.php
 * ~~~~~~~~~~~~~~~~
 */
@include "config.php";

/**
 * $_GET ile adres çubuğundan alınan linke uygun include
 * gerçekleştirir.
 *
 * @not: index.tmpl.php ile kullanım için.
 */
function templateEkle()
{

    if (!isset($_GET[SAYFA]) or empty($_GET[SAYFA])) {
        // ?sayfa boş ise veya hiç gelmemiş ise anasayfayı ekle.
        include "inc/anasayfa.php";
    }
    else {
        if ($_GET[SAYFA] == "iletisim") {
            include "inc/iletisim.php";
        }
        elseif ($_GET[SAYFA] == "giris") {
            include "inc/login.php";
        }

    }
}



?>
