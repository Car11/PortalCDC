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
    <script src="assets/js/Sesion.js" languaje="javascript" type="text/javascript"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <link rel="icon" type="image/png" sizes="310x310" href="./assets/img/logos/favIcon/ms-icon-310x310.png">

</head>

<body>

    <header>
    </header>   

    <div class="signin-form">
        <div class="container"> 
            <div id="error"></div>
            <form id="login-form" name="login-form" style="font-family:Quicksand, sans-serif;background-color:rgba(44,40,52,0.73);width:320px;padding:40px;">
                <div>
                    <a href="index.html">
                        <img class="img-rounded img-responsive" src="assets/img/LogoICEAmarilloBlanco.png" id="image" style="width:auto;height:auto;">
                    </a>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" id="username" name="username" placeholder="usuario@dominio.ice" required>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" id="password" name="password" placeholder="Contraseña" required>
                </div>
                <button class="btn btn-default" type="submit" onclick="Login()" value="Ingresar" id="login" style="width:100%;height:100%;margin-bottom:10px;background-color: #214a80;color: #fff;border-color: #122b40;">Ingresar</button>
            </form>
        </div>
    </div>

</body>

</html>