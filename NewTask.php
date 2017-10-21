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
    <title>New Task</title>
    <!-- CSS -->     
    <link rel="stylesheet" href="css/Style-Base.css?v=<?php echo Globals::cssversion; ?>" />
    
    <!--<link rel="stylesheet" href="css/datatables.css" type="text/css">        
    <link rel="stylesheet" href="css/sweetalert2.css" type="text/css"/> -->
    <!-- JS  -->
    <script src="js/jquery.js" type="text/jscript"></script>
    <script src="js/Task.js" languaje="javascript" type="text/javascript"></script> 
    <!--<script type="text/javascript" charset="utf8" src="js/datatables.js"></script>
    <script src="js/sweetalert2.js"></script>
    
    <script src="js/Validaciones.js" languaje="javascript" type="text/javascript"></script>  -->
    
</head>

<body> 
    <header>
        <h1>NUEVA SOLICITUD DE SERVICIO</h1>        
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
            <!-- BOTONES DE NAVEGACION (NUEVO - VOLVER ATRAS) -->   
            <div id="superiornavegacion">
                <!--<div id="nuevo">
                    <input type="button" id="btnnuevo" class="nbtn_blue-sp-c" value="Nuevo" onclick="Nuevo()";>      
                </div>                
                <div id="atras">
                    <input type="button" id="btnatras" class="nbtn_gray-sp-c" value="Atrás" onclick="location.href='**************.php'";>   
                </div> -->
            </div>

            <!--<div id="lista">
            </div>-->
            
            <form name="task" id='task' method="POST" >
                <label for="title"><span class="input-field-lbl">Título<span class="required">*</span></span>
                    <input autofocus type="text"  id="title"  style="text-transform:uppercase"
                        class="input-field" name="title" title="Título de la tarea"  required >                                
                </label>
                <label for="description"><span class="input-field-lbl">Descripción<span class="required">*</span></span>
                    <input type="text"                                  
                        class="input-field" name="description" value="" id="description" required >
                </label>
                <nav class="btnfrm">
                    <ul>
                        <li><button type="button" class="nbtn_blue" onclick="Save()" >Guardar</button></li>
                        <li><button type="button" class="nbtn_gray" onclick="Exit()" >Cerrar</button></li>
                    </ul>
                </nav>                       

            </form>
        </section>

        <aside> 
        </aside>
    
    </div>    
    
    </body>
</html>




