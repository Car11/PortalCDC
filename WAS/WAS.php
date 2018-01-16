<?php
if (!isset($_SESSION))
  session_start();
include_once('../class/Globals.php');
// Sesion de usuario
require_once("../class/Sesion.php");
$sesion = new Sesion();
if (!$sesion->estado){
    $_SESSION['url']= explode('/',$_SERVER['REQUEST_URI'])[2];
    header('Location: .. /Login.php');
    exit;
}
?>

<html>
<head>
    <title>Inventario WAS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
    
    <link rel="stylesheet" href="../assets/css/Checkbox-Button.css">
    <link rel="stylesheet" href="../assets/css/Checkbox-Button1.css">
    <link rel="stylesheet" href="../assets/css/PHP-Contact-Form-dark.css">
    <link rel="stylesheet" href="../assets/css/PHP-Contact-Form-dark1.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/Style-Base.css" />

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/Was.js" languaje="javascript" type="text/javascript"></script> 
    
</head>

<body> 
    <header>
        <h1>Aplicaciones WAS</h1>        
        <div id="logo"><img src="../assets/img/Logoice.png" height="75" > </div>
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

    <div id="contact">
        <div class="container">
        <div id="messagetop_display">
        <div id="messagetop">
            <span id="messagetext"></span>
        </div>
    </div>  
        <div class="row">
            <div class="col-lg-4">
                <input type="button" id="btnGen" class="nbtn_blue-sp-c" value="Generar" onclick="Gen()">
            </div>
            <div class="col-lg-8" >
                <input type="button" id="btnRefresh" class="nbtn_gray-sp-c" onclick="Load()" value="Recargar" >
                <input type="button" id="btnback" class="nbtn_gray-sp-c" value="Atrás" onclick="location.href='index.html'">
            </div>
            <br><br><br><br><br><br>
        </div> 
            <!--<div class="intro">
                <h2>aplicaciones was</h2>
                <p>Herramienta de diseño de aplicaciones web</p>
            </div>-->
        <form method="post" id="was-form">
            <div class="messages"></div>
            <div class="controls">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"><label for="app" class="control-label">Nombre de la aplicación* </label><input type="text" name="app" required placeholder="APP" style="text-transform:uppercase" autofocus class="form-control" id="app" data-error="Requerido" />
                            <div  class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label for="node" class="control-label">NODO* </label><input type="number" name="node" required placeholder="Número del nodo donde se instala" value="01" inputmode="numeric" class="form-control" id="node" data-error="Requerido Numérico."
                        />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group"><label for="prd" class="control-label">PRODUCCIÓN    </label>
                    <div class="btn-group" data-toggle="buttons">
                        <input type="checkbox" id ="prd" />
                        <!--<label class="btn btn-success active">                            
                            <span class="glyphicon glyphicon-ok"></span>
                        </label>-->
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group"><label class="control-label" for="basedatos">Base de datos</label>
                    <select class="selectpicker" id="basedatos">
                        <option>Oracle</option>
                        <option>Sybase</option>
                        <option>SqlServer</option>
                        <option>MySql</option>
                    </select>
                </div>
            </div>           
            
            <div class="col-md-12" style="background-color:#4e4e4e;">
                <div class="form-group"><label for="fullappname" class="control-label">Full App Name </label><input type="text" name="fullappname" readonly class="form-control" id="fullappname"  />
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group"><label for="clustername" class="control-label">Cluster </label>
                    <input type="text" name="cluster" class="form-control" id="clustername" readonly />                     
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group"><label for="membername" class="control-label">MemberName </label><input type="text" name="cluster" readonly class="form-control" id="membername"  />
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group"><label for="alias" class="control-label">JAAS-Alias </label><input type="text" readonly name="alias" class="form-control" id="alias"  />
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group"><label for="description" class="control-label">Descripción </label><input type="text" name="description" readonly class="form-control" id="description"  />
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group"><label for="datasource" class="control-label">Datasource </label><input type="text" readonly name="datasource" class="form-control" id="datasource"  />
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group"><label for="jndi" class="control-label">JNDI </label><input type="text" name="jndi" readonly class="form-control" id="jndi"  />
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group"><label for="ftp" class="control-label">FTP user</label><input type="text" name="ftp" readonly class="form-control" id="ftp"  />
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <!--VARIABLES DE AMBIENTE-->
            <div class="row">
                <div class="col-lg-4">
                    <input type="button" id="idVar" class="nbtn_blue-sp-c" value="Var" onclick="Var()">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group"><label for="var01" class="control-label">VAR01</label><input type="text" name="var01" readonly class="form-control" id="var01"  />
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group"><label for="var02" class="control-label">VAR02</label><input type="text" name="var02" readonly class="form-control" id="var02"  />
                    
                </div>
            </div>
        </div>
        <div class="row">
            <!--<div class="col-md-12"><button class="btn btn-success btn-send" type="submit" value="Enviar">Enviar </button></div>-->
        </div>
        </form>
    </div>
    </div>




    <!--
    
    

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
                    <input type="text"  id="node" class="form-control"  style="text-transform:uppercase" name="node" title="Número del nodo" value="01" required >  
                    <label for="prd"><span class="">PRODUCCIÓN</span>
                        <input type="checkbox" name="prd" id="prd"  >
                    </label>
                </div>
                
                <div class="form-group">
                    <label for="clustername"> <span class="">CLUSTER<span class="required">*</span></span>
                    <input  type="text"  id="clustername"  
                        class="form-control" name="clustername" title="cluster name"  required >                            
                    </label>
                    <label for="membername"><span class="">membername<span class="required">*</span></span>
                        <input  type="text"  id="membername"  class="form-control" name="membername" title="member name"  required >                            
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

    </div>-->

    
    </body>
</html>




