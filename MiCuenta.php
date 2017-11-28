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
        <h1>LISTA DE VISITANTES</h1>        
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

    <!-- MODAL formulario -->
    <div class="modal" id="modal-task" >

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Solicitud de Servicio
                    <!--div id="loadinggif"><img src="img/loading.gif" height="40" > </div>         -->
                </h2>
            </div>
            <div id="messagetop-modal">
                <div id="messagetop_display-modal">
                    <span id="messagetext-modal"></span>
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="form">
                    <form name="task" id='task' method="POST" >
                        <label for="title"><span class="input-field-lbl">Título<span class="required">*</span></span>
                            <input autofocus type="text"  id="title"  style="text-transform:uppercase"
                                class="input-field" name="title" title="Título de la tarea"  required >                            
                        </label>
                        <label for="description"><span class="input-field-lbl">Descripción<span class="required">*</span></span>
                            <input type="text" class="input-field" name="description" value="" id="description" required >
                        </label>
                        <label for="owner_id"><span class="input-field-lbl">Asignado</span>
                            <input type="text" class="input-field" name="owner_id" value="" id="owner_id" >
                        </label>
                        <div class="cmbfield">
                            <input type="text" id="project_id" name="project_id" placeholder="SELECCIONE EL PROYECTO" class="field" readonly="readonly"> <div> </div> </input>
                            <ul class="list">
                            </ul>
                        </div>
                        <div id="task-details">
                            <input type="text" name="date_creation" value="" id="date_creation" >  
                            <input type="text" name="date_started" value="" id="date_started" >  
                            <input type="text" name="column_id" value="" id="column_id" >  
                        </div>

                        <nav class="btnfrm">
                            <ul>
                                <li><button type="button" class="nbtn_blue" onclick="Save()" >Guardar</button></li>                    
                                <li><button type="button" class="nbtn_gray" onclick="Exit()" >Cerrar</button></li>
                            </ul>
                        </nav>                       
                    </form>

                </div>
            </div>    


            <div class="modal-footer">
                <br>
            </div>

        </div>
    </div>      
    <!-- FIN MODAL -->     

    
    </body>
</html>


