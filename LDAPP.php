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
    <meta charset="UTF-8">
    <title>Administración de usuarios de Aplicaciones WEB</title>
    <!-- CSS -->     
    <link rel="stylesheet" href="css/Style-Base.css?v=<?php echo Globals::cssversion; ?>" />
    <link rel="stylesheet" href="css/Bootstrap.min.css" />
      
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/bootstrap.min.js" languaje="javascript" type="text/javascript"></script> 

    <!--<link rel="stylesheet" href="css/datatables.css" type="text/css">        
    <link rel="stylesheet" href="css/sweetalert2.css" type="text/css"/> -->
    
    <!-- JS  -->
    <script src="js/jquery.js" type="text/jscript"></script>
    <script src="js/Ldapp.js" languaje="javascript" type="text/javascript"></script> 
    <!--<script type="text/javascript" charset="utf8" src="js/datatables.js"></script>
    <script src="js/sweetalert2.js"></script>
    
    <script src="js/Validaciones.js" languaje="javascript" type="text/javascript"></script>  -->
    
</head>

<body> 
    <header>
        <h1>Administración de usuarios de Aplicaciones WEB</h1>        
        <div id="logo"><img src="img/Logoice.png" height="75" > </div>
        <div id="signin">
            <span>Usuario: 
                <?php
                    if ($sesion->estado) {
                        print $_SESSION['username'];
                    } 
                ?>
            </span>
        </div>
    </header>
    
    <div id="messagetop_display">
        <div id="messagetop">
            <span id="messagetext"></span>
        </div>
    </div>  

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <input type="button" id="btnGen" class="nbtn_blue-sp-c" value="xx" onclick="">
            </div>
            <div class="col-lg-8" >
                <input type="button" id="btnRefresh" class="nbtn_gray-sp-c" onclick="" value="xx" >
                <input type="button" id="btnback" class="nbtn_gray-sp-c" value="Atrás" onclick="location.href='index.html'">
            </div>
        </div> 
        
        <!-- login row -->
        <div class="row">
            <div class="col-md-5" style="background-color:red;">
                <label for="username">Usuario</label>
                <input type="text" id="username" class="form-control" >                                
            </div>
            <div class="col-md-5" style="background-color:red;">                
                <label for="password">Contraseña</label>
                <input type="text" id="password" class="form-control" >
            </div>
            <div class="col-md-2" style="background-color:green;">
            <input type="button" id="btnGen" class="nbtn_blue-sp-c" value="Login" onclick="Connect()">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" style="background-color:lavenderblush;">
                <div class="form-group">
                    <label for="app"><span class="">Nombre de la aplicación<span class="required">*</span></span>
                        <input autofocus type="text"  id="app" class="form-control"  style="text-transform:uppercase"  name="app" title="Aplicación"  required >                                                    
                    </label>
                    <input type="text"  id="node" class="form-control"  style="text-transform:uppercase" name="node" title="Número del nodo" value="01" required >  
                    <label for="prd"><span class="">PRODUCCIÓN</span>
                        <input type="checkbox" name="prd" id="prd"  >
                    </label>
                </div>
                
                
            </div>
        </div> 

        <!-- <div id="item-list">
        </div>-->
    </div>

    
    </body>
</html>




