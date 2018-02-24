<!DOCTYPE html>
<html>
<head>

	<!-- ///////////////////////////////////////////////////////
	/////////////////////////////////////////////////////// -->


	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="assets/css/dragula.css">
    <link rel="stylesheet" href="assets/css/Style-ScheduledTask.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- <link rel="stylesheet" href="assets/fonts/font-awesome.min.css"> -->
	<!-- <link rel="stylesheet" href="assets/fonts/ionicons.min.css"> -->
    <!-- <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700"> -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie"> -->
    <!-- <link rel="stylesheet" href="assets/css/KD_Header2.css"> -->
    <!-- <link rel="stylesheet" href="assets/css/Article-List.css"> -->
    <!-- <link rel="stylesheet" href="assets/css/dh-navbar-inverse.css"> -->
    <!-- <link rel="stylesheet" href="assets/css/Features-Boxed-Remixed.css">
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
    <link rel="stylesheet" href="assets/css/sweetalert2.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/sweetalert2.min.js"></script> -->



<!-- /*	///////////////////////////////////////////////////////
	///////////////////////////////////////////////////////*/ -->
	<script src="assets/js/jquery.min.js"></script>	
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/Task.js" languaje="javascript" type="text/javascript"></script>
	<script src="assets/js/dragula.min.js"></script>
	<script  src="assets/js/MiCuenta.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
 

</head>
<body>

    <div class="container">
        <div class="col col-xs-6 text-right">
            <button type="button" id="btn-create-new-task" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target=".bd-example-modal-lg">Crear Nueva</button>
        </div>
    </div>






    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-new-task" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color: black;">Ingresar Nueva Tarea</h5>
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
                                    <!-- <div class="col-sm-1 col-md-5">  </div> 
                                    <div class="col-sm-8 col-md-4 box3-label">   
                                        <label class="text-center"> Detalles de Tarea: </label>
                                    </div>
                                    <div class="col-sm-1 col-md-3">  </div> 
                                    </div> -->

                                    <div class="row">
                                    <div class="col-xs-1 col-md-1"></div>
                                    <div class="col-xs-6 col-md-6">
                                        <label id="titlelbl" for="title"><span class="st_input-field-lbl control-label">Título<span class="required" >*</span></span></label>   
                                    </div>
                                    <div class="col-xs-5 col-md-5">
                                        <label class="control-label">Seleccione un Proyecto: </label> 
                                    </div>                
                                    </div>

                                    <div class="row">
                                    <div class="col-xs-1 col-md-1"></div>
                                    <div class="col-xs-1 col-md-6 selectContainer">
                                        <input  type="text"  id="title"  style="text-transform:uppercase"
                                            class="st_input-field" name="title" value="" title="Título de la tarea" required autofocus> 
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
                                        <textarea value=" " rows="8" cols="29" class="st_input-field-desc" name="description" id="description" style="color:black;">
                                        </textarea>                            
                                    </div>
                                    <div class="col-xs-4 col-md-5">
                                        <input type="datetime-local" autocomplete="on" name="bdaytime" id="date_started">
                                        <br>
                                        <br>
                                        <label class="control-label control-label">Seleccione una fecha de final: </label>                 
                                        <br>
                                        <input type="datetime-local" name="bdaytime" id="date_due">
                                        
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







                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Archivos y Comentarios</a>
                            </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse modal-panel">
                            <div class="panel-body">
                                




                                <div class="row">
                                    <div class="col-md-11">
                                    <div class="form-group">
                                        <div class="custom-file">
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






                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="color: black;">Cancelar</button>
            <button type="button" class="btn btn-primary">Enviar</button>
        </div>
        </div>
    </div>
    </div>




</body>
</html>