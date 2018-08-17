<?php
if (!isset($_SESSION))
    session_start();
    include_once('class/Globals.php');
    // Sesion de usuario
    require_once("class/Sesion.php");
    $sesion = new Sesion();
    if (!$sesion->estado){        
        $_SESSION['url']= explode('/',$_SERVER['REQUEST_URI'])[2]; //indexar a 1 cuando el sitio este en la raiz
        header('Location: Login.php');
        exit;
    }
?>
    <!DOCTYPE html>
    <html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Mi Cuenta</title>
    <!-- CSS -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">	
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="assets/css/dragula.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/Style-ScheduledTask.css">
    <link rel="stylesheet" href="assets/css/sweetalert2.css">
    <link rel="stylesheet" href="assets/css/validator.css">
    <!-- JS -->
	<script src="assets/js/jquery.min.js"></script>	
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/dragula.min.js"></script>
	<script  src="assets/js/MiCuenta.js"></script>
    <script src="assets/js/Comment.js" languaje="javascript" type="text/javascript"></script>
    <script src="assets/js/Task.js" languaje="javascript" type="text/javascript"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="assets/js/sweetalert2.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/validator.min.js" ></script>
    
    <script src='assets/js/download.js'></script>
</head>

    <body>

        <section class="section">
            <h1>Bienvenido a su cuenta</h1>
            <br>
            <h4>Desde este sitio puede gestionar sus solicitudes y tareas hacia el centro de datos corporativo.</h4>
        </section>

        <div class="drag-container">
            <ul class="drag-list" id="drag-list">

            </ul>
        </div>
        <section class="section">
            <a href="#">Operaciones DTI © 2018</a>
        </section>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-new-task" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel" style="color: black;">Ingresar Nueva Tarea</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body" style="color=black;">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading modal-panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Descripción de Tarea</a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in modal-panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-1 col-md-1">
                                                <!-- <label id="hascomments" style="display:none"><span class="st_input-field-lbl control-label" href="/PortalCDC/MiCuenta.php?&amp;" >Comentarios!!</span></label> -->
                                            </div>
                                            <div class="col-xs-5 col-md-5">
                                                <label id="titlelbl" for="title"><span class="st_input-field-lbl control-label">Título<span class="required" >*</span></span></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-1 col-md-1"></div>
                                            <div class="col-xs-10 col-md-10 selectContainer">
                                                <div class="form-group">
                                                    <input type="text" id="title" style="text-transform:uppercase" class="st_input-field form-control" name="title" value="" title="Título de la tarea" required autofocus />
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <!-- fechas -->                                        
                                        <div class="row">
                                            <div class="col-xs-1 col-md-1"></div>
                                            <div class="col-xs-5 col-md-5">
                                                <label class="control-label control-label">Seleccione una fecha de inicio: </label>
                                            </div>
                                            <div class="col-xs-5 col-md-5">
                                                <label class="control-label control-label">Seleccione una fecha de final: </label>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-1 col-md-1"></div>
                                            <div class="col-xs-5 col-md-5">
                                                <div class="form-group">
                                                    <input type="datetime-local" class="st_input-field-time form-control" autocomplete="on" name="bdaytime" id="date_started">
                                                </div>
                                            </div>
                                            <div class="col-xs-5 col-md-5">
                                                <div class="form-group">
                                                    <input type="datetime-local" class="st_input-field-time form-control" name="bdaytime" id="date_due">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /fechas -->
                                        
                                        <div class="row">
                                            <div class="col-xs-1 col-md-1"></div>
                                            <div class="col-xs-5 col-md-5">
                                                <label id="subtask_deslbl" for="subtask_deslbl"><span class="subtask_deslbl control-label">Descripción<span class="required">*</span></span> </label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-1 col-md-1"></div>
                                            <div class="col-xs-5 col-md-10 selectContainer">
                                                <div class="form-group">
                                                    <textarea value=" " rows="15" cols="29" class="st_input-field-desc" name="description" id="description" style="color:black;"></textarea>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">SubTareas</a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse modal-panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <INPUT class="btn btn-primary" id="btnAdd" type="button" value="Agregar Subtarea" onclick="addRow('dataTable')" />
                                                <INPUT class="btn btn-warning" id="btnDel" type="button" value="Eliminiar Subtarea" onclick="deleteRow('dataTable')" />
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
                                                <TABLE id="dataTable" width="100%" border="0">
                                                    <TR>
                                                        <TD>
                                                            <INPUT id="chk" type="checkbox" name="chk" />></TD>
                                                        <TD> <span style='color:#ddd;'> 1 </span></TD>
                                                        <TD>
                                                            <INPUT id="subtask" class="sub-task-desc" type="text" /> </TD>
                                                        <TD>
                                                            <INPUT id="estado" type="text" name="estado" value="Pendiente" />
                                                        </TD>
                                                        <TD>
                                                            <INPUT id="idSubTask" type="text" name="idSubTask" value="new" style="display:none" />
                                                        </TD>
                                                    </TR>
                                                </TABLE>
                                                <!-- <input type="button" value="ok" id="ok" class="boton2" onclick="tableToJSON()"> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Archivos y Comentarios
                                            
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse modal-panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <div class="custom-file">
                                                        <form method="post" enctype="multipart/form-data">
                                                            <!-- <div id="dropzone" style='color: white;'>Drop files here</div> -->
                                                            <!-- <input type="file" multiple="true" id="inputFileToLoad" name="files[]" onchange="encodeImageFile()" class="form-control-file"/> -->
                                                            <input type="file" multiple="true" id="inputFileToLoad" class="form-control-file" placeholder="Archivo" accept="image/*;capture=camera" name="userPhoto" single />
                                                            <output id="listFiles"></output>
                                                            <input type="text" id="response" style='display:none;' />
                                                            <br>
                                                            <!-- <input type="file" name="archivo" id="archivo"></input>
                                                        <input type="submit" value="Subir archivo"></input> -->
                                                        </form>
                                                        <div id="file-list"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="row-comments" class="row">
                                            <div class="col-md-11">
                                                <form data-toggle="validator" role="form" id="frmComment">
                                                    <div class="form-group" id="commentBox">
                                                    </div>
                                                    <div class="form-group" id="newCommentBox">
                                                        <div class="col-xs-12 col-md-12">
                                                            <label for="newComment"><span class="st_input-field-lbl control-label">Nuevo Comentario</span></label>
                                                        </div>
                                                        <div class="col-xs-12 col-md-12">
                                                            <textarea id="newComment" class="st_input-field-desc" data-error="Comentario requerido" required> </textarea>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-12 col-md-12">
                                                            <button type="submit" id="btnSaveComment" class="btn btn-primary">Agregar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cerrar-modal" class="btn btn-secondary" data-dismiss="modal" style="color: black;">Cancelar</button>
                        <button type="button" onclick="SaveTask()" id="btnSaveTask" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
