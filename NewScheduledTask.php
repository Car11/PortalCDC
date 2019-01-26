  <?php
// if (!isset($_SESSION))
// session_start();
include_once('class/Globals.php');
// // Sesion de usuario
// require_once("class/Sesion.php");
// $sesion = new Sesion();
// if (!$sesion->estado){
//   $_SESSION['url']= explode('/',$_SERVER['REQUEST_URI'])[2];
//   header('Location: Login.php');
//   exit;
// }

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Tareas Programadas</title>
    <!-- JS  -->
    <script src="assets/js/jquery.min.js" type="text/jscript"></script> 
    <script src="assets/bootstrap/js/bootstrap.min.js"></script> 
    <script src="assets/js/datatables.js" type="text/javascript" charset="utf8"></script>
    <script src="assets/js/ScheduledTask.js" languaje="javascript" type="text/javascript"></script>
    <script src="assets/js/sweetalert.min.js"></script> 
    <script src="assets/js/sweetalert.js"></script> 
         <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.css">   -->
    <!-- CSS -->     
    <link rel="stylesheet" href="assets/css/sweetalert.css?v=<?php echo Globals::cssversion; ?>" />
    <link rel="stylesheet" href="assets/css/Style-ScheduledTask.css?v=<?php echo Globals::cssversion; ?>" />
    <link href="css/Style-Base.css?v= <?php echo Globals::cssversion; ?>" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="assets/css/Style-Base.css?v=<?php echo Globals::cssversion; ?>" /> -->
    <link rel="stylesheet" href="assets/css/Modal.css?v=<?php echo Globals::cssversion; ?>" />
    <link rel="stylesheet" href="assets/css/Style-Task.css?v=<?php echo Globals::cssversion; ?>" />
    <link rel="stylesheet" href="assets/css/datatables.css" type="text/css"/>       
    <!-- <link rel="icon" type="image/png" sizes="310x310" href="./assets/img/logos/favIcon/ms-icon-310x310.png"> -->
    

</head>

<body> 


    <header>
        <h1>NUEVA SOLICITUD DE TAREA PROGRAMADA</h1>        
        <div id="logo"><img src="img/logoICE.png" height="75" > </div>
        <div id="signin">
            <span>Usuario: 
                <?php
                // if ($sesion->estado) {
                //     print $_SESSION['username'];                    
                // } 
                ?>
            </span>
        </div>
    </header>
    <div id="mensajetop_display">
        <div id="mensajetop">
            <span id="textomensaje"></span>
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
        <div id="item-list"></div>
    </section>

    
    <aside> 
    </aside>
    
        
    <!-- MODAL formulario -->
    <div class="modal" id="modal-index" >
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
            <div class="st_modal-body">
                <div class="container">
                    <br>
                    <!-- En un móvil las columnas ocupan la mitad del dispositivo y en un 
                        ordenador ocupan la tercera parte de la anchura disponible -->
                    <div class="row">  <!--ROW SELECCIONE UN PROYECTO  -->
                        <!-- <div class="form-group"> -->
                        <label class="col-md-3 control-label">Seleccione un Proyecto: </label>
                        <!-- </div> -->
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <label id="chkSubTasklbl" for="chkSubTasklbl"><span class="st_input-field-lbl2">Añadir Subtarea: &nbsp</span>
                                <input type="checkbox" class="st_input-field2" id="chkSubTask" name="chkSubTask" onclick="Check_SubTask_Status()"> &nbsp Si</label>
                        </div>
                    </div> <!--CIERRA ROW SELECCIONE UN PROYECTO  -->
                    
                    
                    
                    <div class="row">  <!--ROW lista de PROYECTOS  -->
                        <div class="col-md-1"></div>
                        <!-- <div class="form-group"> -->
                        <div class="col-md-2 selectContainer">
                            <select class="list form-control" name="projectid" id="projectid">
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <label id="titlelbl" for="title"><span class="st_input-field-lbl">Título<span class="required">*</span></span></label>   
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <INPUT id="btnAdd" type="button" value="Agregar Subtarea" onclick="addRow('dataTable')" />
                            <INPUT id="btnDel" type="button" value="Eliminiar Subtarea" onclick="deleteRow('dataTable')" />
                        </div>
                    </div> 
                    <div class="row">  <!--ROW titulo -->
                        <div class="col-md-1"></div>
                        <div class="form-group">
                            <div class="col-md-2 selectContainer">
                                <input autofocus type="text"  id="title"  style="text-transform:uppercase"
                                    class="st_input-field" name="title" value="" title="Título de la tarea"  required > 
                            </div>
                        </div>
                    </div> <!--CIERRA ROW titulo  -->                     
                    <br>
                    <div class="row">   
                        <div class="col-md-4">
                            <label id="subtask_deslbl" for="subtask_deslbl"><span class="subtask_deslbl">Descripción<span class="required">*</span></span>
                            </label>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <label>Detalle de SubTareas: </label>
                        </div>
                    </div> <!-- Cierra row descripcion -->


                    <div class="row">  <!--ROW titulo -->
                        <div class="col-md-1"></div>
                        <div class="form-group">
                            <div class="col-md-2 selectContainer">
                                <textarea value=" " rows="8" cols="29" class="st_input-field-desc" name="description" id="description" required> 
                                </TEXTAREA>                            
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div id="tabla" class="col-md-5">
                            <div id="disabler"></div>   
                            <TABLE id="dataTable" width="300px" border="1">
                                <TR>
                                    <TD><INPUT id="chk" type="checkbox" name="chk"/></TD>
                                    <TD> <span style='color:#ddd;'> 1 </span></TD>
                                    <TD> <INPUT id="subtask" class="numero" type="text" width="500px"/> </TD>
                                </TR>
                            </TABLE>
                            <!-- <input type="button" value="ok" id="ok" class="boton2" onclick="tableToJSON()"> -->
                        </div>
                    </div> <!--CIERRA ROW titulo  -->  
                    <br>
                    <div class="row">  <!--ROW  FILE -->
                        <div class="col-md-4">
                            <div class="form-group">




                                <form action="test.php" method="post" enctype="multipart/form-data">
                                    <!-- <div id="dropzone" style='color: white;'>Drop files here</div> -->
                                    <input type="file" multiple="true" id="inputFileToLoad" name="files[]" onchange="encodeImageFile()" class="form-control-file"/>
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
                        <div class="col-md-2"></div>
                        <div class="col-md-5"></div>
                    </div> <!--CIERRA ROW FILE  --> 

                    <div class="row">
                        <div class="col-md-12"> &nbsp</div>
                    </div>
                        <div class="row">
                            <div class="col-md-2"></div>

                            <div class="col-md-1">
                                <label id="hourlbl" for="hour"><span class="st_input-field-lbl-time">Hora<span class="required">*</span></span>
                                    <input type="number" min="0" max="23" step="1"
                                    class="st_input-field-time" name="hour" value="00" id="hour" required >                            
                                </label>
                            </div>
                            
                            <div class="col-md-1">
                                <label id="minutelbl" for="minute"><span class="st_input-field-lbl-time">Minuto<span class="required">*</span></span>
                                    <input type="number" min="0" max="59" step="1"
                                    class="st_input-field-time" name="minute" value="00" id="minute" required >  
                                </label>
                            </div>
                            
                            <div class="col-md-2">
                                <label id="domlbl" for="dom"><span class="st_input-field-lbl-time">Día del Mes<span class="required">*</span></span>
                                    <input type="number" min="1" max="31" step="1"
                                    class="st_input-field-time" name="dom" value="00" id="dom" required >
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label id="yearlbl" for="year"><span class="st_input-field-lbl-time">Año<span class="required">* &nbsp &nbsp</span></span>
                                    <input type="number" min="2017" max="2027" step="1"
                                        class="st_input-field-time" name="year" value="2017" id="year" required >
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label id="dowlbl" for="dow"><span class="st_input-field-lbl-time">Día de la Semana<span class="required">*</span></span>
                                    <select class="st_input-field-time" name="dow" value="" id="dow" required>
                                        <option value="t">Todos</option>
                                        <option value="1">Lunes</option>
                                        <option value="2">Martes</option>
                                        <option value="3">Miercoles</option>
                                        <option value="4">Jueves</option>
                                        <option value="5">Viernes</option>
                                        <option value="6">Sabado</option>
                                        <option value="7">Domingo</option>
                                    </select>                                  
                                </label>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-1"></div>
                        <div class="col-md-1"></div>
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label id="chkDomlbl" for="chkDom"><span class="st_input-field-lbl-time">Todos: &nbsp</span>
                                <input type="checkbox" class="st_input-field-time" id="chkDom" name="chkDom" onclick="dom.disabled=!dom.disabled"> Si<br>
                            </label>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-1"></div>                        
                        <div class="col-md-2">
                            <label id="ChkDowlbl" for="ChkDow"><span class="st_input-field-lbl-time">Todos: &nbsp</span>
                                <input type="checkbox" class="st_input-field-time" name="chkDow" id="chkDow" onclick="dow.disabled=!dow.disabled"> Si<br>
                            </label>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-1"></div>
                        <div class="col-md-1"></div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> &nbsp</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-4"></div>
                        <div class="col-xs-6 col-md-4">
                            <div class="container">
                                <button type="button" class="btn btn-primary" onclick="SaveScheduledTask()" >Guardar</button>   
                                <button type="button" class="btn btn-primary" onclick="Exit()" >Cerrar</button>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> &nbsp</div>
                    </div>
                </div>
                <!-- </div> -->
            </div> 
        </div> 
    </div>    <!-- FIN del Modal -->
                
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

<!-- 

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////// ARRASTRA LOS ARCHIVOS A LA PAGINA//////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
//   function handleFileSelect(evt) {
//     evt.stopPropagation();
//     evt.preventDefault();

//     var files = evt.dataTransfer.files; // FileList object.

//     // files is a FileList of File objects. List some properties.
//     var output = [];
//     for (var i = 0, f; f = files[i]; i++) {
//       output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
//                   f.size, ' bytes, last modified: ',
//                   f.lastModifiedDate.toLocaleDateString(), '</li>');
//     }
//     document.getElementById('listFiles').innerHTML = '<ul>' + output.join('') + '</ul>';
//   }

//   function handleDragOver(evt) {
//     evt.stopPropagation();
//     evt.preventDefault();
//     evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
//   }

//   // Setup the dnd listeners.
//   var dropZone = document.getElementById('dropzone');
//   dropZone.addEventListener('dragover', handleDragOver, false);
//   dropZone.addEventListener('drop', handleFileSelect, false);

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////// ARRASTRA LOS ARCHIVOS A LA PAGINA//////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////// -->


<!-- <script>
    // Convert Base64 to Image
    $(document).ready(function() {
        $("#BaseToImage").click(function() {
            //alert($("#response").val());
            document.getElementById('preview').setAttribute('src', $("#response").val());
            $("#preview").show();
        });
    });
    //Convert Image to Base64
    $(document).ready(function() {
        $("#inputFileToLoad").change(function() {
            var filesSelected = document.getElementById("inputFileToLoad").files;
            if (filesSelected.length > 0) {
                var fileToLoad = filesSelected[0];
                var fileReader = new FileReader();
                fileReader.onload = function(fileLoadedEvent) {
                    var base64value = fileLoadedEvent.target.result;
                    console.log(base64value);
                    $("#response").val(base64value);
                };
                fileReader.readAsDataURL(fileToLoad);
            }
        });
    });
</script> -->





<!--             
            <div id="form1">
                <form name="scheduledtask" id='scheduledtask' method="POST" >
                    <label id="titlelbl" for="title"><span class="st_input-field-lbl">Título<span class="required">*</span></span>
                        <input autofocus type="text"  id="title"  style="text-transform:uppercase"
                            class="st_input-field" name="title" value="" title="Título de la tarea"  required >                                
                    </label>

                    <label id="descriptionlbl" for="description"><span class="st_input-field-lbl">Descripción<span class="required">*</span></span>
                        <TEXTAREA value=" " rows="8" cols="32" 
                            class="st_input-field-desc" name="description" id="description" required> </TEXTAREA>
                    </label>
                    <br>
                    <br>
                    <br>
                    <label id="lbl-prog"><span class="st_input-field-lbl">Programacíon:</span></label>
                    
                    <br>
                    <label id="minutelbl" for="minute"><span class="st_input-field-lbl-time">Minuto<span class="required">*</span></span>
                            <input type="number" min="0" max="59" step="1"
                                class="st_input-field-time" name="minute" value="00" id="minute" required >  
                    </label>
                    
                    <label id="hourlbl" for="hour"><span class="st_input-field-lbl-time">Hora<span class="required">*</span></span>
                        <input type="number" min="0" max="23" step="1"
                                class="st_input-field-time" name="hour" value="00" id="hour" required >                            
                    </label>

                    <label id="domlbl" for="dom"><span class="st_input-field-lbl-time">Día del Mes<span class="required">*</span></span>
                        <input type="number" min="1" max="31" step="1"
                                class="st_input-field-time" name="dom" value="00" id="dom" required >
                    </label>
                    
                    <label id="chkDomlbl" for="chkDom"><span class="st_input-field-lbl-time">Todos:</span>
                        <input type="checkbox" class="st_input-field-time" id="chkDom" name="chkDom" onclick="document.scheduledtask.dom.disabled=!document.scheduledtask.dom.disabled"> Si<br>
                    </label>
                    
                    <label id="yearlbl" for="year"><span class="st_input-field-lbl-time">Año<span class="required">*</span></span>
                        <input type="number" min="2017" max="2027" step="1"
                                class="st_input-field-time" name="year" value="2017" id="year" required >
                    </label>
                    
                    <label id="dowlbl" for="dow"><span class="st_input-field-lbl-time">Día de la Semana<span class="required">*</span></span>
                        <select class="st_input-field-time" name="dow" value="" id="dow" required>
                            <option value="t">Todos</option>
                            <option value="1">Lunes</option>
                            <option value="2">Martes</option>
                            <option value="3">Miercoles</option>
                            <option value="4">Jueves</option>
                            <option value="5">Viernes</option>
                            <option value="6">Sabado</option>
                            <option value="7">Domingo</option>
                        </select>                                  
                    </label>
                    
                    <label id="ChkDowlbl" for="ChkDow"><span class="st_input-field-lbl-time">Todos:</span>
                        <input type="checkbox" class="st_input-field-time" name="chkDow" id="chkDow" onclick="document.scheduledtask.dow.disabled=!document.scheduledtask.dow.disabled"> Si<br>
                    </label>
                    <br>
                    <br>
                    <br>
                    <nav class="btnfrm">
                        <ul>
                            <li><button type="button" class="nbtn_blue" onclick="SaveScheduledTask()" >Guardar</button></li>
                            <li><button type="button" class="nbtn_gray" onclick="SaveAddSubTask()" >Crear SubTarea</button></li>
                            <li><button type="button" class="nbtn_gray" onclick="Exit()" >Cerrar</button></li>
                        </ul>
                    </nav>      
                </form>-->
<!--    <INPUT type="button" value="Add Row" onclick="addRow('dataTable')" />
        <INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable')" />
    
        <TABLE id="dataTable" width="350px" border="1">
                    <TR>
                        <TD><INPUT type="checkbox" name="chk"/></TD>
                        <TD> 1 </TD>
                        <TD> <INPUT type="text" /> </TD>
                    </TR>
                </TABLE>
                
                <table id="subTask">
                    <td>Inserte el nombre de una NUEVA Sub-Tarea:</td>
                    <tr>
                        <td>
                            <input autofocus type="text"  id="title_subtask"  style="text-transform:uppercase"
                                    class="input-field" name="title_subtask" value="" title="Título de la Sub tarea"  required >
                        </td>
                    </tr>
                </table>
                <br>
                <button onclick="addSubTaskTable()">Añadir SubTarea</button> -->




