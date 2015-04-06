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


/**
 *
 * Verilen kullanıcı id'si ile kullanıcı rolünün getirilmesi.
 * Eğer kullaniciRol(1, $DB, true) şeklinde kullanılırsa
 * rol'ün id'si yerine açık ismini getirir.
 *
 *
 * ÖNEMLİ:
 * ~~~~~~~
 * Bu fonksiyonun return ile kontroller de if(true) vs
 * yerine if($rol>=0) gibi bir kullanım gerekli. SüperAdmin rolü
 * "0" dönüyor. if($rol)'de bu durum FALSE a sebep olacaktır.
 *
 * @param $id_kullanici     Kullanıcı id'si
 * @param $DB               Veritabanı bağlantısı.
 * @param $aciklama bool    Rol id'si sayi yerine isim olarak mı gelsin?
 * @return array|string
 */
function kullaniciRolu($id_kullanici, $DB, $aciklama=false)
{
    // Kullanıcı rolunun veritabanından çekilmesi.
    $sorgu = $DB->prepare("SELECT id_rol FROM kullanicilar_roller WHERE id_kullanici = :id_kullanici");
    $sorgu->bindParam(":id_kullanici", $id_kullanici);
    $sorgu->execute();

    $sonuc = $sorgu->fetchAll(PDO::FETCH_ASSOC);

    if ($sonuc) {
        // İleride bir kullanıcıya birden fazla rol verme ihtimali
        // doğmasına karşın.

        if (count($sonuc) > 1) {
            // Eğer birden fazla rol döner ise array dön.
            $roller = array();
            foreach($sonuc as $son) {
                $roller[] = $aciklama ? rolIsim($son["id_rol"], $DB): $son["id_rol"];
            }

            return $roller;
        }
        else {
            $rol = $aciklama ? rolIsim($sonuc[0]["id_rol"], $DB): $sonuc[0]["id_rol"];
            return $rol;
        }

    }
    else {
        // !ÖNEMLİ: false değil -1 dönüyor.
        return "-1";
    }

}


/**
 * Verilen rol id'si ile rol'ün tam ismini getirir.
 *
 * NOT: kullaniciRol() ile kullanmak içen özellikle.
 * @param $id_rol       Rol id'si
 * @param $DB           Veritabanı bağlantısı.
 * @return bool|string
 */
function rolIsim($id_rol, $DB)
{
    $sorgu = $DB->prepare("SELECT rol FROM roller WHERE id= :id_rol");
    $sorgu->bindParam(":id_rol", $id_rol);
    $sorgu->execute();

    $sonuc = $sorgu->fetch(PDO::FETCH_ASSOC);

    if($sonuc) {
        return $sonuc["rol"];
    }
    else {
        return false;
    }
}



echo "<pre>";
var_dump(kullaniciRolu(1, $DB, true));
echo "</pre>";

?>
