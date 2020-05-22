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
  <script src="assets/js/jquery-3.3.1.js"></script>
	<!-- <script src="assets/js/jquery.min.js"></script>	 -->
	<script src="assets/js/dragula.min.js"></script>
	<script  src="assets/js/MiCuenta.min.js"></script>
    <script src="assets/js/Comment.min.js" languaje="javascript" type="text/javascript"></script>
    <script src="assets/js/Task.js" languaje="javascript" type="text/javascript"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="assets/js/sweetalert2.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/validator.min.js" ></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    
    <script src='assets/js/download.js'></script>
    <link rel="icon" type="image/png" sizes="310x310" href="./assets/img/logos/favIcon/ms-icon-310x310.png">
</head>

    <body>
        <section class="section" style="text-align: left;">
          <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
              <h3 class="col-lg-2" style="color: black; text-align: right">Proyecto:</h3>
              <select class="form-control col-lg-10"  style="width: auto" id="sel_ProyectobyUser" onchange="sel_ProyectobyUser_change(this)">
              </select>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <!-- <h3 style="color: black; text-align: right">Dashboard de Tareas. <u id='logout'>Cerrar Sesión</u></h3>                 -->
              <div class="text-align: right;">
                <button type="button" class="btn btn-primary btn-lg" style="color: black; float: right !important; background-color: #EDF2F3 !important;background-image: none; right: 25px;bottom: 21px;z-index: 999;position: fixed;"id='logout' type="button" >Salir</button>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div id='search' class="item form-group" style="text-align: center">
                  <input id="buscar" class="form-control col-md-6 col-xs-12" name="buscar" type="text" placeholder="Buscar Tareas" autofocus>
              </div>
            </div>
          </div>
          <div class="row">
          </div>
        </section>

        <div class="drag-container">
            <div class="row">
                <ul class="drag-list" id="drag-list">

                </ul>
                </div>
            </div>
        </div>
        <section>
            
        </section>

        <section class="section">            
            <a style="color: black;right: 0; bottom: 0px; position: fixed; left: 0; background-color: #dadada;" href="#">Operaciones DTI © 2020</a>            
        </section>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" data-backdrop="static"  id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-new-task" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h5 class="modal-title" id="ModalLabel" style="color: black;">Ingresar Nueva Tarea</h5> -->
                        <h4 class="panel-title">
                            <!-- <a data-toggle="modal" data-target=".bd-lista-modal-lg">Cargar Plantillas</a> -->
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body" style="color=black;">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading modal-panel-heading">
                                    <h4 class="panel-title">
                                        <a class="seccion-titulo" data-toggle="collapse" data-parent="#accordion" href="#collapse1">Descripción de Tarea</a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in modal-panel">
                                    <div class="panel-body">
                                        <!-- <div class="row">
                                            <div class="col-xs-1 col-md-1">
                                            </div>
                                            <div class="col-xs-5 col-md-5">
                                                <label id="projectlbl" for="title"><span class="st_input-field-lbl control-label">Proyecto<span class="required" >*</span></span></label>
                                            </div>
                                        </div> -->
                                        
                                        <!-- <div class="row">
                                            <div class="col-xs-1 col-md-1"></div>
                                            <div class="col-xs-10 col-md-10 selectContainer">
                                                <div class="form-group">
                                                    <select id="proyectosKB" name="proyectosKB" 
                                                        style="color:black; text-transform:uppercase;" class="st_input-field form-control">
                                                    </select>         
                                                </div>
                                            </div>
                                        </div> -->

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
                                            <div class="col-xs-10 col-md-10">
                                                <label class="control-label control-label">Seleccione una fecha de inicio: </label>
                                            </div>
                                            <!-- <div class="col-xs-5 col-md-5">
                                                <label class="control-label control-label">Seleccione una fecha de final: </label>
                                            </div> -->
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-1 col-md-1"></div>
                                            <div class="col-xs-10 col-md-10">
                                                <div class="form-group">
                                                    <input type="datetime-local" class="st_input-field-time form-control" autocomplete="on" name="bdaytime" id="date_started">
                                                </div>
                                            </div>
                                            <!-- <div class="col-xs-5 col-md-5">
                                                <div class="form-group">
                                                    <input type="datetime-local" class="st_input-field-time form-control" name="bdaytime" id="date_due">
                                                </div>
                                            </div> -->
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
                                    <h4 class="panel-title ">
                                        <a class="seccion-titulo" data-toggle="collapse" data-parent="#accordion" href="#collapse2">SubTareas</a>
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
                                                            <INPUT id="chk" type="checkbox" name="chk" />
                                                        </TD>
                                                        <TD> 
                                                            <span style='color:#ddd;'> 1 </span>
                                                        </TD>
                                                        <TD>
                                                            <INPUT id="subtask" class="sub-task-desc" type="text" /> 
                                                        </TD>
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
                                        <a class="seccion-titulo" data-toggle="collapse" data-parent="#accordion" href="#collapse3">Archivos y Comentarios
                                            
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
                        <!-- <button type="button" onclick="SaveTemplate()" id="btnSaveTemplate" class="btn btn-primary">Guardar como Plantilla</button> -->
                        <button type="button" onclick="SaveTask()" id="btnSaveTask" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Lista -->
        <div class="modal fade bd-lista-modal-lg" data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="listModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-list-task" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel" style="color: black;">Lista de Plantillas</h5>
                        <!-- Carga planillas del usuario -->
                        <!--  -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body" style="color=black;">

                  </div>
                    <div class="modal-footer">
                        <button type="button" id="cerrar-modal" class="btn btn-secondary" data-dismiss="modal" style="color: black;">Cancelar</button>
                        <button type="button" onclick="loadTask()" id="btnLoadTask" class="btn btn-primary">Cargar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
    
  <!-- jQuery -->
  <!-- <script src="assets/js/jquery-3.3.1.js"></script> -->
  <!-- bootstrap-daterangepicker -->
  <script src="vendors/daterangepicker/daterangepicker.min.js"></script>
<style>
  .cajaTarea{
    border-bottom-color: #e9e9e9;
    border-bottom-style: solid;
    border-right-color: #e9e9e9;
    border-right-style: solid;
    border-top-color: #e9e9e9;
    border-top-style: solid;
  }
</style>
<script>
    $(document).ready(function () {

        var fechaInicio = null;
        var fechaFinal = null;
        // DATERANGEPICKER Solicitud FORMULARIO
        $(function () {

            fechaInicio = moment().subtract(1, 'months').locale("es");
            fechaFinal = moment().locale("es");

            $('#dp_rangoFechaFormulario').daterangepicker({
                timePicker: true,
                opens: "center",
                locale: {
                    format: 'D MMMM YY - hh:mm A',
                    separator: " - ",
                    applyLabel: "Aplicar",
                    cancelLabel: "Cancelar",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Manual",
                    daysOfWeek: [
                    "DO",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                    ],
                    monthNames: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Setiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                    ],
                    firstDay: 1
                },
                startDate: fechaInicio,
                endDate: fechaFinal
                }, cbFechas
            );

            function cbFechas(fechaIngreso, fechaSalida) {
            // $('#dp_rangoFechaFormulario span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#dp_rangoFechaFormulario span').html(fechaIngreso.format('D MMMM YY - hh:mm A') + '  ->  ' + fechaSalida.format('D MMMM YY - hh:mm A'));
            }

            cbFechas(fechaInicio, fechaFinal);

        });

        $('#dp_rangoFechaFormulario').on('apply.daterangepicker', function (ev, picker) {
            fechaInicio = picker.startDate.format();
            fechaFinal = picker.endDate.format();
        });













    $.ajax({
        type: "POST",
        url: "class/Project.php",
        data: {
            action: "GetByUserID"
        }
    })
    .done(function (e) {
        $('#proyectosKB').html("")
        if (e){
            
            var data_proyectos = JSON.parse(e);
            $(data_proyectos).each(function (i, item) {
                $('#proyectosKB').append(`<option value="${item.id}">${item.name}</option>`);
            })
        }
    })
    .fail(function (e) {
        // formulario.showError(e);
    });
    
  });
</script>