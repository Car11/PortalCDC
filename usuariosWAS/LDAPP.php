<?php
// if (!isset($_SESSION))
//   session_start();
// include_once('class/globals.php');
// // Sesion de usuario
// require_once("class/Sesion.php");
// $sesion = new Sesion();
// if (!$sesion->estado){
//     $_SESSION['url']= explode('/',$_SERVER['REQUEST_URI'])[2];
//     header('Location: Login.php');
//     exit;
// }
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Administración de usuarios de Aplicaciones WEB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->     
    <link rel="stylesheet" href="css/Style-Base.css" />
    <link rel="stylesheet" href="css/Bootstrap.min.css" />
    <link rel="stylesheet" href="LDaap/assets/css/bootstrap-select.css">

    <script src="js/jquery.js" type="text/jscript"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js" languaje="javascript" type="text/javascript"></script> 
    <script src="LDaap/assets/js/bootstrap-select.js" languaje="javascript" type="text/javascript"></script>
    <script src="js/Ldapp.js" languaje="javascript" type="text/javascript"></script> 
    
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
                <input type="text" value="cachac7" id="username" class="form-control" >                                
            </div>
            <div class="col-md-5" style="background-color:red;">                
                <label for="password">Contraseña</label>
                <input type="text" value="CaChac707" id="password" class="form-control" >
            </div>
            <div class="col-md-2" style="background-color:green;">
                <input type="button" id="btnGen" class="nbtn_blue-sp-c" value="Login" onclick="Connect()">
            </div>
        </div>

        <div id="formdiv">
        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;margin-top:-16px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Ambiente </strong></p>
            </div>
            <div class="col-md-10 col-md-offset-1"><select name="ambiente" id="ambiente"  onchange="getGroupsByAppName()" class="form-control" style="font-family:Roboto, sans-serif;"><optgroup label="Ambiente"><option value>Desarrollo</option><option value>Producción</option></optgroup></select></div>
        </div>
        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;margin-top:-16px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Rama </strong></p>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <select name="rama" id="rama"  class="form-control" style="font-family:Roboto, sans-serif;">
                    <optgroup label="Rama"></optgroup>
                </select>
            </div>
        </div>
        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;margin-top:-16px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Aplicación </strong></p>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <select name="aplicacion" id="aplicacion"  onchange="getGroupsByAppName()" class="form-control" style="font-family:Roboto, sans-serif;"><optgroup label="Aplicaciones"></optgroup></select>
            </div>
        </div>


        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;margin-top:-16px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Grupo </strong></p>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <select name="grupo"  id="grupo" class="selectpicker show-menu-arrow form-control" multiple data-max-options="10"><optgroup label="Grupos"><</optgroup>       </select>                
            </div>
        </div>


        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Lista de Usuarios </strong></p>
            </div>            
            <div class="col-md-10 col-md-offset-1">
                <textarea class="form-control" id="usuarios" placeholder="Copie y pegue la lista de usuarios." style="font-family:Roboto, sans-serif;" required>cachac7</textarea>
            </div>
        </div>

        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;margin-top:-16px;">
            <div class="col-md-8 col-md-offset-1">
                <p style="margin-left:2%;font-family:Roboto, sans-serif;font-size:24px;"><strong>Membresías </strong></p>
            </div>
            <div class="col-md-10 col-md-offset-1">
            <select name="membresia"  id="membresia" class="selectpicker show-menu-arrow form-control" multiple data-max-options="10"><optgroup label="Membresías"><</optgroup>       </select>                
            </div>
        </div>

        <div class="row" style="margin-right:0px;margin-left:0px;padding-top:24px;">
            <div class="col-md-4 col-md-offset-4 col-xs-12 col-xs-offset-0">                
                <input type="button" id="btnAddUser" class="nbtn_gray-sp-c" onclick="AddUser()" value="Agregar" >
                <input type="button" id="btngetMembershipByUser" class="nbtn_gray-sp-c" onclick="getMembershipByUser()" value="Membresías" >
            </div>
        </div>
    </div>
</div>

    
    </body>
</html>




