<?php
if (!isset($_SESSION))
  session_start();
include_once('class/Globals.php');
// Sesion de usuario
include_once("class/Sesion.php");
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
    <title>Mi Cuenta</title>
    <link href="css/Style-Base.css?v= <?php echo Globals::cssversion; ?>" rel="stylesheet" />
    <!--<link href="css/dropdownmenu.css" rel="stylesheet"/> -->
    <script src="js/jquery.js" type="text/jscript"></script>    
</head>
<body>
    <header>
        <h1>MI CUENTA</h1>        
        <div id="logo"><img src="img/Logoice.png" height="75" > </div>        
    </header>
    <div class="log">        
        <nav class="dropdownmenu">
          <ul>
            <li><a href="NewTask.php">Nueva Solicitud de servicio</a></li>
            <li><a href="xxx.php">Mis Solicitudes</a></li>
            <li><a href="xxx.php">Mis Proyectos</a></li>
          </ul>                
        </nav>
    </div>
    
</body>
</html>
