<?php

// DB Connection.
$host = "localhost";
$dbname = "bulut";
$user = "root";
$pass = "";
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

try {
    $DB = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "[HATA]: Veritabanı -".$e;
}


/** ----------------------------------------------------------------------
 *
 * Site içi kullanılacak değişmez değişkenlerin tanımlanması.
 *
 ------------------------------------------------------------------------*/

// Site içi linklerde GET ile kullanılacak değişken adı.
// localhost/bulut/index.php?sayfa=iletisim   gibi.
define("SAYFA", "sayfa");

// Site adı.
// <title> arasında vs kullanma amaçlı.
define("SITE_ADI", "Bulut");



?>
