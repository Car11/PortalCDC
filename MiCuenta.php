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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/Team-Grid.css">
    <link rel="stylesheet" href="assets/css/Team.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <script src="assets/js/Task.js" languaje="javascript" type="text/javascript"></script> 

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

            <div class="col-md-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <h3 class="panel-title">Mis Tareas [
                                    <?php
                                        if ($sesion->estado) {
                                            print $_SESSION['username'];
                                        } 
                                    ?> ]
                                </h3>
                            </div>
                            <div class="col col-xs-6 text-right">
                                <button type="button" class="btn btn-sm btn-primary btn-create">Crear Nueva</button>
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
                        <tbody id='task-tbody'>
                           
                        </tbody>
                    </table>                
                </div>
                
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-xs-4">Page x of X
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

        </div>
    </div><!-- END CONTAINER -->   

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
    </div><!-- END PAGEFOOTER -->   

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

                        <div class="form-group">
                            <label for="date_due"><span class="input-field-lbl">Fecha (KB date_due)</span>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control"  name="date_due" value="" id="date_due"  />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </label>      
                        </div>                      
                        
                        <div class="cmbfield">
                            <input type="text" id="project_id" name="project_id" placeholder="Seleccione el Proyecto" class="field" readonly="readonly"> <div> </div> </input>
                            <ul class="list">
                            </ul>
                        </div>
                        
                        <button type='button' class="accordion">Adjuntos</button>
                        <div id='attachment' class="panel">
                            <div id="image-list">
                            </div>                        
                            <div id="file-list">
                                <!--<div class="dropdown">
                                    <a href="#" class="dropdown-menu dropdown-menu-link-text" title="00004Rana Cerca.jpeg">00004Rana Cerca.jpeg <i class="fa fa-caret-down"></i></a>
                                    <ul>
                                        <li>
                                            <a href="/kanboard/?controller=FileViewerController&amp;action=download&amp;task_id=2251&amp;project_id=11&amp;file_id=34" class="" title='' ><i class="fa fa-fw fa-download" aria-hidden="true"></i>Descargar</a>                                </li>
                                        <li>
                                            <a href="/kanboard/?controller=TaskFileController&amp;action=confirm&amp;task_id=2251&amp;project_id=11&amp;file_id=34" class="js-modal-confirm" title='' ><i class="fa fa-trash-o fa-fw js-modal-confirm" aria-hidden="true"></i>Suprimir</a>                                    </li>
                                    </ul>
                                </div>
                                <ul id="menu">
                                    <li>
                                        <input id="check01" type="checkbox" name="menu"/>
                                        <label for="check01">Tasto menu 01</label>
                                        <ul class="submenu">
                                        <li><a href="#">Sotto menu 1</a></li>
                                        <li><a href="#">Sotto menu 2</a></li>
                                        </ul>
                                    </li>
                                </ul> -->
                            </div>
                        </div>

                        <button type='button' class="accordion">Comentarios</button>
                        
                        <div id='comments' class="panel">
                            <div id="comment-list">
                            </div>     
                        </div>

                        <div id="task-details">
                            <!--<input type="text" name="date_creation" value="" id="date_creation" >  
                            <input type="text" name="date_started" value="" id="date_started" >  
                            <input type="text" name="column_id" value="" id="column_id" >  -->
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