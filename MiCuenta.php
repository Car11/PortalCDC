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
    <link rel="stylesheet" href="assets/css/Style-ScheduledTask.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <script src="assets/js/Task.js" languaje="javascript" type="text/javascript"></script> 
    <!-- <script src="assets/js/ScheduledTask.js" languaje="javascript" type="text/javascript"></script>  -->

</head>

<body>
    <nav class="navbar navbar-default custom-header">
        <div class="container-fluid">
            <div class="navbar-header"><a class="navbar-brand" href="index.html">
                <span style="margin-left:27px;font-family:'News Cycle', sans-serif;color:rgb(253,250,254);">Portal Centro de Datos Corporativo </span> 
                <img class="img-responsive" src="assets/img/ico-cerca-de-ti-log.png" width="auto" height="auto" style="width:43px;margin:-26px;margin-right:-27px;margin-top:-32px;margin-left:-33px;margin-bottom:-31px;"> 
            </a>
                <!-- <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"></button> -->
            </div>
            <!-- <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right"></ul>
            </div> -->
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <p></p>
            <h1>Bienvenido a su cuenta</h1>
            <p style="color: #DAD8D8;">Desde este sitio puede gestionar sus solicitudes y tareas hacia el centro de datos corporativo.</p>

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
                                <button type="button" id="btn-create-new-task" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target=".bd-example-modal-lg">Crear Nueva</button>
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
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Creado</th>
                            </tr> 
                        </thead>
                        <tbody id='task-tbody'>
                           
                        </tbody>
                    </table>                
                </div>
                
                <div class="panel-footer">
                    <!-- <div class="row">
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
                    </div> -->
                </div>
            </div>

        </div>
    </div><!-- END CONTAINER -->   

    <div class="footer-dark navbar navbar-fixed-bottom" style="padding: 1px;">
        <footer>                
            <p class="copyright">Operaciones DCTI © 2018</p>
        </footer>
    </div><!-- END PAGEFOOTER -->   

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="height: 100%;">
        <div class="modal-dialog modal-lg" style="height: 100%;">
          <div class="modal-content" style="height: 100%;">   
            
          


            <div  id="box3" class="box"><!-- caja 03 -->
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!-- <h4 class="modal-title">Modal Header</h4> -->
              </div> <!-- Fin del Header -->
              
              <div class="row">           
                <div class="col-sm-1 col-md-5">  </div> 
                <div class="col-sm-8 col-md-4 box3-label">   
                  <label class="text-center"> Detalles de Tarea: </label>
                </div>
                <div class="col-sm-1 col-md-3">  </div> 
              </div>

              <div class="row">
                <div class="col-xs-1 col-md-1"></div>
                <div class="col-xs-6 col-md-6">
                  <label id="titlelbl" for="title"><span class="st_input-field-lbl control-label">Título<span class="required">*</span></span></label>   
                </div>
                <div class="col-xs-5 col-md-5">
                  <label class="control-label">Seleccione un Proyecto: </label> 
                </div>                
              </div>

              <div class="row">
                <div class="col-xs-1 col-md-1"></div>
                <div class="col-xs-1 col-md-6 selectContainer">
                  <input  type="text"  id="title"  style="text-transform:uppercase"
                      class="st_input-field" name="title" value="" title="Título de la tarea" required> 
                </div>
                <div class="col-xs-1 col-md-4 selectContainer">
                  <select class="list form-control" name="projectid" id="projectid">
                  </select>
                </div>
              </div>

              <br>
              <div class="row">
                <div class="col-xs-1 col-md-1"></div>
                <div class="col-xs-1 col-md-6">
                  <label id="subtask_deslbl" for="subtask_deslbl"><span class="subtask_deslbl control-label">Descripción<span class="required">*</span></span>
                  </label>
                </div>
                <div class="col-xs-4 col-md-5">
                  <label class="control-label control-label">Seleccione una fecha de inicio: </label> 
                </div> 
              </div>

              <div class="row">
                <div class="col-xs-1 col-md-1"></div>
                <div class="col-xs-1 col-md-6 selectContainer">
                  <textarea value=" " rows="8" cols="29" class="st_input-field-desc" name="description" id="description" required> 
                  </TEXTAREA>                            
                </div>
                <div class="col-xs-4 col-md-5">
                  <input type="datetime-local" autocomplete="on" name="bdaytime" id="date_started">
                  <br>
                  <br>
                  <label class="control-label control-label">Seleccione una fecha de final: </label> 
                
                  <input type="datetime-local" name="bdaytime" id="date_due">
                  
                </div> 
              </div>
              <div class="footer-box">              
                <div class="col-sm-1 col-md-1"> 
                  <!-- <a class="btn btn-primary btn-lg" href="#box1" role="button">Atras</a> -->
                  <button type="button" id="cerrar-modal" class="btn btn-warning center-block" data-dismiss="modal">Cancelar</button> 
                </div>   
                <div class="col-sm-2 col-md-4"></div>
                <div class="col-sm-9 col-md-2">
                  <a class="btn btn-success btn-lg center-block" onclick="SaveTask()" role="button">Guardar</a> 
                </div>                 
                <div class="col-sm-2 col-md-3"></div>
                <div class="col-sm-2 col-md-2 text-right">  
                  <a class="btn btn-primary btn-lg" href="#box4" role="button">Siguiente</a>  
                </div>
                <div class="col-sm-5 col-md-5"> </div>
              </div><!-- FIN Footer -->     
            </div><!--FIN caja 03 -->

            <div id="box4" class="box"><!-- caja 04 -->
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!-- <h4 class="modal-title">Modal Header</h4> -->
              </div>



              <div class="row">
                <div class="col-md-12 text-center control-label">                         
                  <h2>A continuacion puede agregar subtareas y/o archivos adjuntos.</h2>
                </div>
              </div>
              <br>
              <br>
              <br>

              <div class="row">
                <div class="col-md-5">
                  <INPUT id="btnAdd" type="button" value="Agregar Subtarea" onclick="addRow('dataTable')" />
                  <INPUT id="btnDel" type="button" value="Eliminiar Subtarea" onclick="deleteRow('dataTable')" />
                </div>
              </div>

              <br>
              <div class="row">
                <div class="col-md-5 control-label">
                  <label>Detalle de SubTareas: </label>
                </div>
              </div>

              <div class="row">
                <div id="tabla" class="col-md-10">   
                  <TABLE id="dataTable" width="100%" border="1">
                    <TR>
                      <TD><INPUT id="chk" type="checkbox" name="chk"/></TD>
                      <TD> <span style='color:#ddd;'> 1 </span></TD>
                      <TD> <INPUT id="subtask" class="sub-task-desc" type="text"/> </TD>
                    </TR>
                  </TABLE>
                  <!-- <input type="button" value="ok" id="ok" class="boton2" onclick="tableToJSON()"> -->
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-11">
                  <div class="form-group">
                    <form action="test.php" method="post" enctype="multipart/form-data">
                        <!-- <div id="dropzone" style='color: white;'>Drop files here</div> -->
                        <!-- <input type="file" multiple="true" id="inputFileToLoad" name="files[]" onchange="encodeImageFile()" class="form-control-file"/> -->
                        <input type="file" multiple="true" id="inputFileToLoad" class="form-control-file" placeholder="Archivo" accept="image/*;capture=camera" name="userPhoto" single />
                        <output id="listFiles"></output>
                        <input type="text" id="response" style='display:none;' />
                        <br>
                        <!-- <input type="file" name="archivo" id="archivo"></input>
                        <input type="submit" value="Subir archivo"></input> -->
                    </form>
                    <!-- <label for="exampleInputFile">Adjuntar un archivo</label>
                    <input type="file" class="form-control-file" name="archivo" id="userfile" aria-describedby="fileHelp"> -->
                    <!-- <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small> -->                         
                  </div>
                </div>         
              </div>         






              

              <div class="footer-box">              
                <div class="col-sm-1 col-md-1"> 
                  <a class="btn btn-primary btn-lg" href="#box3" role="button">Atras</a> 
                </div>   
                <div class="col-sm-2 col-md-4"></div>
                <div class="col-sm-9 col-md-2">
                  <a class="btn btn-success btn-lg center-block" onclick="SaveTask()" role="button">Guardar</a> 
                </div>                 
                <div class="col-sm-2 col-md-3"></div>
                <div class="col-sm-2 col-md-2 text-right">  
                  <!-- <a class="btn btn-primary btn-lg" href="#box4" role="button">Siguiente</a>   -->
                </div>
                <div class="col-sm-5 col-md-5"> </div>            
              </div><!-- FIN Footer -->     
            </div><!--FIN caja 04 -->
          </div><!--FIN modal-content -->
        </div><!--FIN modal-dialog modal-lg -->
      </div><!--modal fade bd-example-modal-lg -->
   


    <!-- MODAL formulario EDITAR -->
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

            
            
        </div>
    </div>      
<!-- FIN MODAL -->   
</body>
<script>
////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////// CREA LISTA DE ARCHIVOS AGREGADOS //////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // files is a FileList of File objects. List some properties.
    var output = [];
    for (var i = 0, f; f = files[i]; i++) {
      output.push('<li><strong>', (f.name), '</li>');
    }
    document.getElementById('listFiles').innerHTML = '<ul>' + output.join('') + '</ul>';
  }

   document.getElementById('inputFileToLoad').addEventListener('change', handleFileSelect, false);
  
////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////// CREA LISTA DE ARCHIVOS AGREGADOS //////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
</script>

</html>