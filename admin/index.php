<?php
session_start();
include "../siniflar.php";

if (isset($_POST["girisTip"]) and !empty($_POST["girisTip"])) {
    // TODO: Diğer issetler de eklenecek.

    $mail = $_POST["fMail"];
    $sifre = $_POST["fSifre"];
    $giris = Bulut::oturumAc($mail, $sifre);

    if ($giris) {
        if ($_SESSION["kulRol"] == "0") {
            include "adminSuper.tmpl.php";
        }
        elseif ($_SESSION["kulRol"] = "1") {
            include "adminSirket.tmpl.php";
        }
    }
    else {
        header("Location: ../index.php?sayfa=giris");
    }

}

else {
    header("Location: ../index.php?sayfa=giris");
}
?>