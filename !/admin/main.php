<?php
session_start();
class main {
    public $DB;
    function __construct()
    {
        $host = "localhost";
        $dbname = "bulut";
        $user = "root";
// Benim phpmyadmin'in şifresi root, bu kısmı değiştirirsiniz.
        $pass = "root";
        $dsn = "mysql:host=$host;dbname=$dbname";
        try {
            $this->DB = new PDO($dsn, $user, $pass);
            $this->DB->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            echo "[HATA]: Veritabanı -".$e;
        }
    }
    /**
     * Kullanıcı ve Şirket arasında normalizasyon işlemi.
     *
     * @not: parametreler vs $_COOKIE'den alınacak kayıt işlemi
     * sırasında.
     *
     * @param $id_kullanici (int) Kullanıcı id'si.
     * @param $id_sirket (int) Şirket id'si.
     * @return bool
     */
    public static
    function normalizasyonSirket($id_kullanici, $id_sirket)
    {
// static bir bağlantı kuruyoruz sınıf ile böylece
// static fonksiyonlar construct veritabanına ulaşabiliyor.
        $obj = new static();
        $db = $obj->DB;
// Sorgunun hazırlanması.
        $sorgu = $db->prepare("INSERT INTO kullanicilar_sirket (id, id_kullanici, id_sirket) VALUES (NULL, ?, ?)");
        $islem = $sorgu->execute(array($id_kullanici, $id_sirket));
        if ($islem) {
            return true;
        }
        else {
            return false;
        }
    }
    /**
     * Kullanıcı ve Roller arasında normalizasyon işlemi.
     *
     * @not: parametreler vs $_COOKIE'den alınacak kayıt işlemi
     * sırasında.
     *
     * @param $id_kullanici (int) Cookie'den alınan kullanıcı id'si.
     * @param $id_rol (int) Cookie'den alınan rol id'si
     * @return bool
     */
    public static
    function normalizasyonRoller($id_kullanici, $id_rol)
    {
// static bir bağlantı kuruyoruz sınıf ile böylece
// static fonksiyonlar construct veritabanına ulaşabiliyor.
        $obj = new static();
        $db = $obj->DB;
// Sorgunun hazırlanması.
        $sorgu = $db->prepare("INSERT INTO kullanicilar_roller(id, id_kullanici, id_rol) VALUES (NULL, ?, ?)");
// !!!: Bir sebepten bindParam çalışmıyor.
        $islem = $sorgu->execute(array($id_kullanici, $id_rol));
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
     * @param $id_kullanici Kullanıcı id'si
     * @param $DB Veritabanı bağlantısı.
     * @param $aciklama bool Rol id'si sayi yerine isim olarak mı gelsin?
     * @return array|string
     */
    public static
    function kullaniciRolu($id_kullanici, $aciklama=false)
    {
// static bir bağlantı kuruyoruz sınıf ile böylece
// static fonksiyonlar construct veritabanına ulaşabiliyor.
        $obj = new static();
        $db = $obj->DB;
// Kullanıcı rolunun veritabanından çekilmesi.
        $sorgu = $db->prepare("SELECT id_rol FROM kullanicilar_roller WHERE id_kullanici = :id_kullanici");
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
                    $roller[] = $aciklama ? Bulut::rolIsim($son["id_rol"]): $son["id_rol"];
                }
                return $roller;
            }
            else {
                $rol = $aciklama ? Bulut::rolIsim($sonuc[0]["id_rol"]): $sonuc[0]["id_rol"];
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
     * @param $id_rol Rol id'si
     * @return bool|string
     */
    public static
    function rolIsim($id_rol)
    {
// static bir bağlantı kuruyoruz sınıf ile böylece
// static fonksiyonlar construct veritabanına ulaşabiliyor.
        $obj = new static();
        $db = $obj->DB;
// sorgu işlemi.
        $sorgu = $db->prepare("SELECT rol FROM roller WHERE id= :id_rol");
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
    public static
    function kullanicilar()
    {
        $obj = new static();
        $db = $obj->DB;
        $s = $db->query("SELECT * FROM kullanicilar");
        $r = $s->fetchAll(PDO::FETCH_ASSOC);
        var_dump($r);
    }

    public static function oturumAc($mail,$sifre){
        $obj=new static();
        $db=$obj->DB;
        //  $sonuc=$db->query("SELECT * FROM kullanicilar WHERE mail='".$mail."',sifre='".$sifre."' ");
        //$row=$sonuc->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($sonuc);



        $q = $db->prepare("SELECT * FROM kullanicilar WHERE mail = :mailadress and sifre = :ksifre LIMIT 1");
        $q->bindValue(':mailadress', $mail);
        $q->bindValue(':ksifre',  $sifre);
        $q->execute();
        $check = $q->fetch(PDO::FETCH_ASSOC);

        if (!empty($check)){
            $row_id = $check['id'];
            $mail=$check["mail"];
            $adi=$check["adi"]." ".$check["soyadi"];
            $_SESSION['kulId']=$row_id;
            $_SESSION['kulAdi']=$adi;
            $_SESSION['kulMail']=$mail;
            //echo $_SESSION["kulAdi"];
            echo "<script> window.location.href='default.php';</script>";

        }else{
            return false;
        }

    }
}

?>