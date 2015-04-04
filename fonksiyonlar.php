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

    }
}


/**
 * Kullanıcı ve Roller arasında normalizasyon işlemi.
 *
 * @not: parametreler vs $_COOKIE'den alınacak kayıt işlemi
 * sırasında.
 *
 * @param $id_kullanici (int) Cookie'den alınan kullanıcı id'si.
 * @param $id_rol       (int) Cookie'den alınan rol id'si
 * @param $DB           (obj) PDO, veritabanı bağlantısı.
 * @return bool
 */
function normalizasyonRoller($id_kullanici, $id_rol, $DB)
{

    // Sorgunun hazırlanması.
    $sorgu = $DB->prepare("INSERT INTO kullanicilar_roller VALUES (NULL, ':id_kullanici', ':id_rol')");
    $sorgu->bindParam(":id_kullanici", $id_kullanici);
    $sorgu->bindParam(":id_rol", $id_rol);
    $islem = $sorgu->execute();

    if ($islem) {
        return true;
    }
    else {
        return false;
    }
}


/**
 * Kullanıcı ve Şirket arasında normalizasyon işlemi.
 *
 * @not: parametreler vs $_COOKIE'den alınacak kayıt işlemi
 * sırasında.
 *
 * @param $id_kullanici     (int) Kullanıcı id'si.
 * @param $id_sirket        (int) Şirket id'si.
 * @param $DB               (obj) Veritabanı bağlantısı.
 * @return bool
 */
function normalizasyonSirket($id_kullanici, $id_sirket, $DB)
{

    // Sorgunun hazırlanması.
    $sorgu = $DB->prepare("INSERT INTO kullanicilar_sirket VALUES (NULL, ':id_kullanici', ':id_rol')");
    $sorgu->bindParam(":id_kullanici", $id_kullanici);
    $sorgu->bindParam(":id_rol", $id_sirket);
    $islem = $sorgu->execute();

    if ($islem) {
        return true;
    }
    else {
        return false;
    }
}


?>