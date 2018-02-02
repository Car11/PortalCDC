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
    <title>Mi Cuenta</title>
    <link href="css/Style-Base.css?v= <?php echo Globals::cssversion; ?>" rel="stylesheet" />

    <script src="js/jquery.js" type="text/jscript"></script>    

    <link rel="stylesheet" href="css/Style-Base.css?v=<?php echo Globals::cssversion; ?>" />
    <link rel="stylesheet" href="css/Style-Task.css?v=<?php echo Globals::cssversion; ?>" />
    <link rel="stylesheet" href="css/Modal.css?v=<?php echo Globals::cssversion; ?>" />
    <link rel="stylesheet" href="css/datatables.css" type="text/css"/>     

    <script src="js/task.js" languaje="javascript" type="text/javascript"></script> 
    <script src="js/datatables.js" type="text/javascript" charset="utf8"></script>
</head>

<body> 
    <header>
        <h1>Mis Tareas</h1>        
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
    <aside> 
    </aside>
    <section>
        <div id="navigation-opt-btn">
            <div id="new-btn">
                <input type="button" id="btnnew" class="nbtn_blue-sp-c" value="Nuevo" onclick="New()">
            </div>                
            <div id="back-btn">                
                <input type="button" id="btnRefresh" class="nbtn_gray-sp-c" onclick="Load()" value="Recargar" >
                <input type="button" id="btnback" class="nbtn_gray-sp-c" value="Atrás" onclick="location.href='index.html'">
            </div>
            <div id="back-btn">
                
            </div>
        </div>
        <div id="item-list">
        </div>
    </section>
    <aside>
    </aside>

  

    
    </body>
</html>


