<?php
/**
 * index.php
 * ~~~~~~~~~
 *
 * Anasayfa için PHP dosyası.
 *
 *
 */

include "config.php";
include "siniflar.php";
include "fonksiyonlar.php";



// Template dosyaları sonda include ediliyor ki ana php içinde yaratılan
// değişkenler bu template dosyalarına gidebilsin.
include "index.tmpl.php";
?>