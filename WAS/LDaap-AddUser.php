<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LDaap-Menu</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="../assets/css/KD_Header2.css">
    <link rel="stylesheet" href="../assets/css/Contact-Form-Clean.css">
    <link rel="stylesheet" href="../assets/css/dh-navbar-inverse.css">
    <link rel="stylesheet" href="../assets/css/Features-Clean.css">
    <link rel="stylesheet" href="../assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="../assets/css/Header-Dark.css">
    <link rel="stylesheet" href="../assets/css/KD_Header.css">
    <link rel="stylesheet" href="../assets/css/PHP-Contact-Form-dark.css">
    <link rel="stylesheet" href="../assets/css/PHP-Contact-Form-dark1.css">
    <link rel="stylesheet" href="../assets/css/Responsive-Form.css">
    <link rel="stylesheet" href="../assets/css/Responsive-Form1.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/KD_Header1.css">
</head>

<body>
    <nav class="navbar navbar-default custom-header">
        <div class="container-fluid">
            <div class="navbar-header"><a class="navbar-brand" href="#"><span style="margin-left:27px;font-family:'News Cycle', sans-serif;color:rgb(253,250,254);">Portal Centro de Datos Corporativo </span> <img class="img-responsive" src="../assets/img/ico-cerca-de-ti-log.png" width="auto" height="auto" style="width:43px;margin:-26px;margin-right:-27px;margin-top:-32px;margin-left:-33px;margin-bottom:-31px;"> </a>
                <button
                    class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right"></ul>
            </div>
        </div>
    </nav>
    <div class="features-clean">
        <div class="container">
            <div class="intro">
                <h2 class="text-center">Agregar Nuevo Usuario</h2>
            </div>
            <div class="row features" style="margin:75px;">
                <div class="col-md-12"><span>Usuario </span><input type="text" /><span>Contraseña </span><input type="text" /><button class="btn btn-default" type="button">Log In </button></div>
            </div>
        </div>
        <div class="container">
            <div>
                <form>
                    <div class="form-group">
    <div id="formdiv">
        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;margin-top:-16px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Ambiente </strong></p>
            </div>
            <div class="col-md-10 col-md-offset-1"><select name="ambiente" id="ambiente" class="form-control" style="font-family:Roboto, sans-serif;"><optgroup label="Ambiente"><option value>Desarrollo</option><option value>Producción</option></optgroup></select></div>
        </div>
        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;margin-top:-16px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Rama </strong></p>
            </div>
            <div class="col-md-10 col-md-offset-1"><select name="rama" id="rama"  class="form-control" style="font-family:Roboto, sans-serif;"><optgroup label="Gender"><option value>Empleados</option><option value>Clientes</option><option value>Proveedores</option></optgroup></select></div>
        </div>
        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;margin-top:-16px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Aplicación </strong></p>
            </div>
            <div class="col-md-10 col-md-offset-1"><select name="aplicacion" id="aplicacion" class="form-control" style="font-family:Roboto, sans-serif;"><optgroup label="Aplicaciones"></optgroup></select></div>
        </div>
        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;margin-top:-16px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Grupo </strong></p>
            </div>
            <div class="col-md-10 col-md-offset-1"><select class="form-control" name="grupo" id="grupo" style="font-family:Roboto, sans-serif;"><optgroup label="Grupos"><</optgroup></select></div>
        </div>
        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Lista de Usuarios </strong></p>
            </div>
            <div class="col-md-10 col-md-offset-1"><input class="form-control" type="text" name="userlist" id="userlist"  placeholder="Copie y pegue la lista de usuarios" style="margin-left:0px;font-family:Roboto, sans-serif;" /></div>
        </div>
        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;">
            <div class="col-md-4 col-md-offset-4 col-xs-12 col-xs-offset-0"><button class="btn btn-default btn-lg" type="reset" style="font-family:Roboto, sans-serif;">Clear </button><button class="btn btn-default btn-lg" type="submit" style="margin-left:16px;">Submit </button></div>
        </div>
    </div>
</div>
                </form>
            </div>
        </div>
    </div>
    <div class="footer-dark">
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-push-6 item text">
                        <h3>Company Name</h3>
                        <p>Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus. Aliquam in arcu eget velit pulvinar dictum vel in justo.</p>
                    </div>
                    <div class="col-md-3 col-md-pull-6 col-sm-4 item">
                        <h3>Services</h3>
                        <ul>
                            <li><a href="#">Web design</a></li>
                            <li><a href="#">Development</a></li>
                            <li><a href="#">Hosting</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-md-pull-6 col-sm-4 item">
                        <h3>About</h3>
                        <ul>
                            <li><a href="#">Company</a></li>
                            <li><a href="#">Team</a></li>
                            <li><a href="#">Careers</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 col-sm-4 item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a></div>
                </div>
                <p class="copyright">Company Name © 2016</p>
            </div>
        </footer>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/PHP-Contact-Form-dark.js"></script>
    <script src="../assets/js/PHP-Contact-Form-dark1.js"></script>
</body>

</html>