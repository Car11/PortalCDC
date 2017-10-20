  <?php
/*if (!isset($_SESSION)) {
    session_start();
}*/
include_once('class/Globals.php');
// Sesion de usuario
require_once("class/Sesion.php");
$sesion = new Sesion();
// si no hay sesion lo envia a login
if (!$sesion->estado) {
    //$_SESSION['url']= explode('/', $_SERVER['REQUEST_URI'])[2];
    //header('Location: Login.php');
    //exit;
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Control de Acceso</title>
    <!-- CSS -->     
    <link rel="stylesheet" href="css/Style-Base.css?v=<?php echo Globals::cssversion; ?>" />
    
    <!--<link rel="stylesheet" href="css/datatables.css" type="text/css">        
    <link rel="stylesheet" href="css/sweetalert2.css" type="text/css"/> -->
    <!-- JS  -->
    <!--<script src="js/jquery.js" type="text/jscript"></script>
    <script type="text/javascript" charset="utf8" src="js/datatables.js"></script>
    <script src="js/sweetalert2.js"></script>
    <script src="js/FuncionesServicio.js" languaje="javascript" type="text/javascript"></script> 
    <script src="js/Validaciones.js" languaje="javascript" type="text/javascript"></script>  -->
    
</head>

<body> 
    <header>
        <h1>SOLICITUD DE SERVICIO</h1>        
        <div id="logo"><img src="img/Logoice.png" height="75" > </div>
        <div id="signin">
            <span>Usuario: 
                <?php
                /*if ($sesion->estado) {
                    print $_SESSION['username'];
                } */
                ?>
            </span>
        </div>
    </header>
    <div id="mensajetop_display">
        <div id="mensajetop">
            <span id="textomensaje"></span>
        </div>
    </div>

    <div id="general">
        <aside> 
        </aside>

        <section>
            <div class="dialog-message" title="Visitante">
                <p id="texto-mensaje">
                    Desea Eliminar el Perfil?
                </p>
            </div>
            <div id="superiornavegacion">
                <!--<div id="nuevo">
                    <input type="button" id="btnnuevo" class="nbtn_blue-sp-c" value="Nuevo" onclick="Nuevo()";>      
                </div>                -->
                <div id="atras">
                    <input type="button" id="btnatras" class="nbtn_gray-sp-c" value="Atrás" onclick="location.href='**************.php'";>   
                </div>
            </div>

            <!--<div id="lista">
            </div>-->
            
            <form name="task" id='task' method="POST" >
                <label for="titulo"><span class="input-field-lbl">Cédula / Identificación <span class="required">*</span></span>
                    <input autofocus type="text"  id="titulo"                                 
                        class="input-field" name="titulo" placeholder="0 0000 0000" title="Número de cédula separado con CEROS"  onkeypress="return isNumber(event)" required >                                
                </label>
                <label for="empresa"><span class="campoperfil">Empresa / Dependencia <span class="required">*</span></span>
                    <input type="text"   style="text-transform:uppercase"                                 
                        class="input-field" name="empresa" value="" id="empresa" required >
                </label>
                <label for="nombre"><span class="campoperfil">Nombre Completo <span class="required">*</span></span>
                    <input  required type="text" class="input-field" name="nombre" style="text-transform:uppercase" id="nombre"/>
                </label>
                <label for="permiso"><span class="campoperfil">Tiene permiso de Ingreso Anual?</span>
                    <br>
                    <input type="checkbox" name="permiso" id="permiso" class="input-field" >
                </label>

                <nav class="btnfrm">
                    <ul>
                        <li><button type="button" class="nbtn_blue" onclick="Guardar()" >Guardar</button></li>
                        <li><button type="button" class="nbtn_gray" onclick="Cerrar()" >Cerrar</button></li>
                    </ul>
                </nav>                       

            </form>
        </section>

        <aside> 
        </aside>
    
    </div>    
    
    </body>
</html>




