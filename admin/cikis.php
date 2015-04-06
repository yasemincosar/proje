<?php
// Session açılımı.
session_start();

// Cookie'lerin silinmesi.
// TODO: Cookie eklenecek.
//setcookie("kulRol", "", time()-3600);

session_destroy();

header("Location: index.php");

//echo "<script>window.location.href = 'index.php';</script>";
?>