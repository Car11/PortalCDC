<?php
    /*include_once('class/Globals.php');
    $ID="";
    if (isset($_GET['ID'])) {
        $ID=$_GET['ID'];
    }
    if(isset($_SESSION['estado']))
        unset($_SESSION['estado']); */
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <title>Portal de Centros de Datos Corporativos</title>
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
    
    <script src="assets/js/jquery.min.js" type="text/jscript"></script>
    <script src="assets/js/FormValidate.js" languaje="javascript" type="text/javascript"></script>
    <script src="assets/js/Sesion.js" languaje="javascript" type="text/javascript"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

</head>

<body>

    <header>
        <!--<h1>Servicios</h1>        
        <div id="logo"><img src="assets/img/Logoice.png" height="75" > </div>-->
    </header>       
    <h2>Ingrese su usuario y contraseña</h2>
    <form id="frmusuario" name="frmusuario" style="font-family:Quicksand, sans-serif;background-color:rgba(44,40,52,0.73);width:320px;padding:40px;">
        <div>
            <img class="img-rounded img-responsive" src="assets/img/LogoICEAmarilloBlanco.png" id="image" style="width:auto;height:auto;">
        </div>
        <div class="form-group">
            <input class="form-control" type="text" id="username" name="username" placeholder="Usuario">
        </div>
        <div class="form-group">
            <input class="form-control" type="password" id="password" name="password" placeholder="Contraseña">
        </div>
        <button class="btn btn-default" type="button" onclick="Login()" value="Ingresar" id="login" style="width:100%;height:100%;margin-bottom:10px;background-color: #214a80;color: #fff;border-color: #122b40;">Ingresar</button>
    </form>

<script> 
    /*var ID = '<?php //print $ID ?>';
    if(ID=='invalid'){            
        $("#invalid").css("visibility", "visible");
    }*/
</script>

</body>

</html>