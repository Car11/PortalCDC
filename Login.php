<?php
    include_once('class/Globals.php');
    $ID="";
    if (isset($_GET['ID'])) {
        $ID=$_GET['ID'];
    }
    if(isset($_SESSION['estado']))
        unset($_SESSION['estado']);
    if(isset($_SESSION['idformulario']))
        unset($_SESSION['idformulario']);
    if(isset($_SESSION['cedula']))
        unset($_SESSION['cedula']);
    if(isset($_SESSION['link']))
        unset($_SESSION['link']);
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <title>Control de Acceso</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <link rel="stylesheet" href="assets/css/dh-navbar-inverse.css">
    <link rel="stylesheet" href="assets/css/Features-Clean.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/css/Header-Dark.css">
    <link rel="stylesheet" href="assets/css/KD_Header.css">
    <link rel="stylesheet" href="assets/css/KD_Header1.css">
    <link rel="stylesheet" href="assets/css/KD_Header2.css">
    <link rel="stylesheet" href="assets/css/OcOrato---Login-form.css">
    <link rel="stylesheet" href="assets/css/OcOrato---Login-form1.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="js/FormValidate.js" languaje="javascript" type="text/javascript"></script>
    <script src="js/jquery.js" type="text/jscript"></script>
    <script>
        $('#username').attr("autocomplete", "off");
        $('#password').attr("autocomplete", "off");
        setTimeout('$("#username").val("");', 100);
        setTimeout('$("#password").val("");', 100);
    </script>

</head>

<body>
    <form id="Usuario" name="Usuario" action="request/postUsuario.php" method="POST" style="font-family:Quicksand, sans-serif;background-color:rgba(44,40,52,0.73);width:320px;padding:40px;">
        <div><img class="img-rounded img-responsive" src="assets/img/LogoICEAmarilloBlanco.png" id="image" style="width:auto;height:auto;"></div>
        <div class="form-group"><input class="form-control" type="text" id="username" name="username" placeholder="Usuario"></div>
        <div class="form-group"><input class="form-control" type="password" id="password" name="password" placeholder="Contraseña"></div>
        <button class="btn btn-default" type="submit" value="Ingresar" id="login" style="width:100%;height:100%;margin-bottom:10px;background-color: #214a80;color: #fff;border-color: #122b40;">Ingresar</button></form>
    <script
        src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>