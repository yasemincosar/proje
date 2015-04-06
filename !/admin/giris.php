<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Giriş Sayfası</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
<?php
include "main.php";
    if(isset($_POST["username"])&&isset($_POST["password"])){
        if(!empty($_POST["username"])&&!empty($_POST["password"])){
            $mail=trim($_POST["username"]);
            $sifre=md5(trim($_POST["password"]));
            $cevap= main::oturumAc($mail,$sifre);
            if($cevap==false){
                echo "Kullanıcı adı veya şifre hatalı";
            }
        }
    }

?>
<form action="" method="POST">
    <div class="login-form">
        <h3>Oturum Aç</h3>
        <hr>
        <label class="input-label" for="username"><img src="img/ic_person_24px.svg" width="23px" height="23px"></label>
        <input type="text" id="username" name="username" placeholder="Kullanıcı Adı" required>
        <label class="input-label" for="password"><img src="img/ic_lock_open_24px.svg" width="23px" height="23px"></label>
        <input type="password" id="password" name="password" placeholder="Şifre" required>
        <button type="submit">Oturum Aç</button>
    </div>
</form>
</body>
</html>