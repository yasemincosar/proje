<?php
include "../siniflar.php";

if (isset($_POST["girisTip"]) and !empty($_POST["girisTip"])) {

    if ($_POST["girisTip"] == "superAdmin") {
        $mail = $_POST["fMail"];
        $sifre = $_POST["fSifre"];

        $giris = Bulut::oturumAc($mail, $sifre);

        if ($giris) {
            // TODO: Burada kontrol olacak. rolid fonksiyonu'na göre
            // include yapacak.

            include "adminSuper.tmpl.php";
        }
        else {
            header("Location: ../index.php?sayfa=giris");
        }

    }
    else {
        header("Location: ../index.php?sayfa=giris");
    }

}
?>