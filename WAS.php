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
    <title>Inventario WAS</title>
    <!-- CSS -->     
    <link rel="stylesheet" href="css/Style-Base.css?v=<?php echo Globals::cssversion; ?>" />
    <link rel="stylesheet" href="css/Bootstrap.min.css" />
    
  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/bootstrap.min.js" languaje="javascript" type="text/javascript"></script> 

    <!--<link rel="stylesheet" href="css/datatables.css" type="text/css">        
    <link rel="stylesheet" href="css/sweetalert2.css" type="text/css"/> -->
    <!-- JS  -->
    <script src="js/jquery.js" type="text/jscript"></script>
    <script src="js/Was.js" languaje="javascript" type="text/javascript"></script> 
    <!--<script type="text/javascript" charset="utf8" src="js/datatables.js"></script>
    <script src="js/sweetalert2.js"></script>
    
    <script src="js/Validaciones.js" languaje="javascript" type="text/javascript"></script>  -->
    
</head>

<body> 
    <header>
        <h1>Aplicaciones WAS</h1>        
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
                <input type="button" id="btnGen" class="nbtn_blue-sp-c" value="Generar" onclick="Gen()">
            </div>
            <div class="col-lg-8" >
                <input type="button" id="btnRefresh" class="nbtn_gray-sp-c" onclick="Load()" value="Recargar" >
                <input type="button" id="btnback" class="nbtn_gray-sp-c" value="Atrás" onclick="location.href='index.html'">
            </div>
        </div> 
        
        <div class="row">
            <div class="col-lg-12" style="background-color:lavenderblush;">
                <div class="form-group">
                    <label for="app"><span class="">Nombre de la aplicación<span class="required">*</span></span>
                        <input autofocus type="text"  id="app" class="form-control"  style="text-transform:uppercase"  name="app" title="Aplicación"  required >                                                    
                    </label>
                    <input autofocus type="text"  id="node" class="form-control"  style="text-transform:uppercase" name="node" title="Número del nodo" value="01" required >  
                    <label for="prd"><span class="">PRODUCCIÓN</span>
                        <input type="checkbox" name="prd" id="prd" class="form-control" >
                    </label>
                </div>
                
            </div>
        </div> 

        <div id="navigation-opt-btn">
            <div id="new-btn">
                
            </div>                
            <div id="back-btn">                
                
            </div>
            <div id="back-btn">
                
            </div>
        </div>
        <div id="form">
            
            

            <label for="clustername"><span class="">CLUSTER<span class="required">*</span></span>
                <input autofocus type="text"  id="clustername"  
                    class="" name="clustername" title="cluster name"  required >                            
            </label>
            <label for="membername"><span class="">membername<span class="required">*</span></span>
                <input autofocus type="text"  id="membername"  
                    class="" name="membername" title="member name"  required >                            
            </label>
            <br><br>

            <label for="alias"><span class="">JAAS-ALIAS<span class="required">*</span></span>
                <input autofocus type="text"  id="alias"  
                    class="" name="alias" title="JAAS alias"  required >                            
            </label>
            <label for="description"><span class="">description<span class="required">*</span></span>
                <input autofocus type="text"  id="description"  
                    class="" name="description" title="JAAS description"  required >                            
            </label>

            <br><br>
            <label for="datasource"><span class="">datasource<span class="required">*</span></span>
                <input autofocus type="text"  id="datasource"  
                    class="" name="datasource" title="datasource"  required >                            
            </label>
            <label for="jndi"><span class="">JNDI<span class="required">*</span></span>
                <input autofocus type="text"  id="jndi"  
                    class="" name="jndi" title="jndi"  required >                            
            </label>

            <br><br>
            <label for="ftp"><span class="">ftp user<span class="required">*</span></span>
                <input autofocus type="text"  id="ftp"  
                    class="" name="ftp" title="ftp"  required >                            
            </label>

        </div>
        <!-- <div id="item-list">
         </div>-->
    </div>

    
    </body>
</html>




