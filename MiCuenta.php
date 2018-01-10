<?php
if (!isset($_SESSION))
    session_start();
    include_once('class/Globals.php');
    // Sesion de usuario
    require_once("class/Sesion.php");
    $sesion = new Sesion();
    if (!$sesion->estado){
        $_SESSION['url']= explode('/',$_SERVER['REQUEST_URI'])[2];
        header('Location: Login.php');
        exit;
    }
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="assets/css/KD_Header2.css">
    <link rel="stylesheet" href="assets/css/Article-List.css">
    <link rel="stylesheet" href="assets/css/dh-navbar-inverse.css">
    <link rel="stylesheet" href="assets/css/Features-Boxed-Remixed.css">
    <link rel="stylesheet" href="assets/css/Features-Boxed-Remixed1.css">
    <link rel="stylesheet" href="assets/css/Features-Boxed-Remixed2.css">
    <link rel="stylesheet" href="assets/css/Features-Boxed-Remixed3.css">
    <link rel="stylesheet" href="assets/css/Features-Clean.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/css/Carousel-Hero.css">
    <link rel="stylesheet" href="assets/css/Header-Dark.css">
    <link rel="stylesheet" href="assets/css/KD_Header1.css">
    <link rel="stylesheet" href="assets/css/KD_Header.css">
    <link rel="stylesheet" href="assets/css/MUSA_panel-table.css">
    <link rel="stylesheet" href="assets/css/MUSA_panel-table1.css">
    <link rel="stylesheet" href="assets/css/Parallax-Scroll-Effect1.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/Team-Grid.css">
    <link rel="stylesheet" href="assets/css/Team.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-default custom-header">
        <div class="container-fluid">
            <div class="navbar-header"><a class="navbar-brand" href="#"><span style="margin-left:27px;font-family:'News Cycle', sans-serif;color:rgb(253,250,254);">Portal Centro de Datos Corporativo </span> <img class="img-responsive" src="assets/img/ico-cerca-de-ti-log.png" width="auto" height="auto" style="width:43px;margin:-26px;margin-right:-27px;margin-top:-32px;margin-left:-33px;margin-bottom:-31px;"> </a>
                <button
                    class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"></button>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right"></ul>
            </div>
        </div>
    </nav>

<div class="container">
    <div class="row">
    <p></p>
    <h1>Bienvenido a su cuenta</h1>
    <p>Desde este sitio puede gestionar sus solicitudes y tareas hacia el centro de datos corporativo.</p>
    <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default panel-table">
              <div class="panel-heading">
                <div class="row">
                  <div class="col col-xs-6">
                    <h3 class="panel-title">Panel Heading</h3>
                  </div>
                  <div class="col col-xs-6 text-right">
                    <button type="button" class="btn btn-sm btn-primary btn-create">Create New</button>
                  </div>
                </div>
              </div>
              <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                  <thead>
                    <tr>
                        <th><em class="fa fa-cog"></em></th>
                        <th class="hidden-xs">ID</th>
                        <th>Titulo</th>
                        <th>Asignado</th>
                        <th>Estado</th>
                        <th>Proyecto</th>
                    </tr> 
                  </thead>
                  <tbody>
                          <tr>
                            <td align="center">
                              <a class="btn btn-default"><em class="fa fa-pencil"></em></a>
                              <a class="btn btn-danger"><em class="fa fa-trash"></em></a>
                            </td>
                            <td class="hidden-xs">1</td>
                            <td>John Doe</td>
                            <td>johndoe@example.com</td>
                              <td>En Proceso</td>
                              <td>Operación</td>
                          </tr>
                        </tbody>
                </table>
            
              </div>
              <div class="panel-footer">
                <div class="row">
                  <div class="col col-xs-4">Page 1 of 5
                  </div>
                  <div class="col col-xs-8">
                    <ul class="pagination hidden-xs pull-right">
                      <li><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">4</a></li>
                      <li><a href="#">5</a></li>
                    </ul>
                    <ul class="pagination visible-xs pull-right">
                        <li><a href="#">«</a></li>
                        <li><a href="#">»</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

</div></div></div>
    <div class="footer-dark navbar navbar-fixed-bottom">
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-push-4 item text">
    <h3 class="contac-center-h3">Contactenos </h3><i class="icon-earphones-alt icon" style="font-size:40px;color:#f0f9ff;float:left;margin-left:1px;margin-right:1px;opacity:0.6;"></i>
    <p style="font-size:xx-large; text-align: center;">2002-4040</p>
</div>
    <div class="col-md-4 col-md-pull-4 col-sm-4 item">
    <h3>Servicios</h3>
    <ul>
        <li><a href="#">Operación y Monitoreo</a></li>
        <li><a href="#">Control y Producción</a></li>
        <li><a href="#">Gestión de Cambios</a></li>
    </ul>
</div>
    <div class="col-md-4  col-sm-4 item">
    <h3>Sugerencias </h3>
    <ul>
        <li><a href="#">Cuéntanos tu experiencia</a></li>
        <li></li>
        <li></li>
    </ul>
</div>
                </div>
                <p class="copyright">Operaciones DCTI © 2018</p>
            </div>
        </footer>
    </div>

</body>

</html>