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

<!doctype html>
<html lang="en">
  <head>
    <title>Hello, world!</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- JS  -->
    <script src="js/jquery.js" type="text/jscript"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/ScheduledTask.js" languaje="javascript" type="text/javascript"></script>
         <!-- CSS de Bootstrap -->   
    <link rel="stylesheet" href="css/Style-ScheduledTask.css?v=<?php echo Globals::cssversion; ?>" />
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css"> 
     
  </head>
    <body>
      
 <!-- Large modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

      <div class="caja"> 
        <div> 
       
        </div>
        CAJAS
      </div>
      
      
      <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="height: 100%;">
        <div class="modal-dialog modal-lg" style="height: 100%;">
          <div class="modal-content" style="height: 100%;">   
            
          

            <div id="box1" class="box"> <!-- caja 01 -->
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!-- <h4 class="modal-title">Modal Header</h4> -->
              </div>
              <div class="row">           
                <div class="col-sm-1 col-md-3">  </div> 
                <div class="col-sm-8 col-md-6 box1-label">   
                  <label> Que tipo de tarea desea solicitar? </label>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-1 col-md-4">  </div>
                <div class="col-sm-4 col-md-2">
                  <a class="btn btn-primary btn-lg center-block" href="#box3" role="button">Simple</a>
                </div>
                <div class="col-sm-4 col-md-2">
                  <a class="btn btn-primary btn-lg center-block" href="#box2" role="button">Recursiva</a>
                </div>
                <div class="col-sm-1 col-md-4">  </div>
              </div> 
              <div class="footer-box">              
                <div class="col-sm-5 col-md-5"> </div>                  
                <div class="col-sm-2 col-md-2">  
                  <button type="button" class="btn btn-warning center-block" data-dismiss="modal">Atras</button>  
                </div>
                <div class="col-sm-5 col-md-5"> </div>
              </div><!-- FIN Footer -->
            </div><!--FIN caja 01 -->
            
            <div  id="box2"class="box"><!-- caja 02 -->
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              <!-- <h4 class="modal-title">Modal Header</h4> -->
              </div>
              <!-- ////////////////////////////////////////////////////////////// -->
              <!-- ////////////////////////////////////////////////////////////// -->
              <!-- ////////////////////////////////////////////////////////////// -->
              <!-- ////////////////////////////////////////////////////////////// -->

              <div class="row">           
                <div class="col-sm-1 col-md-2">  </div> 
                <div class="col-sm-8 col-md-8 box1-label">   
                  <label class="text-center"> Cuando quiere que se ejecute su tarea? </label>
                </div>
              </div>

              <div class="time control-label">
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
                  </div> <!-- Cierra la primera FILA -->

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
                </div> <!--Cierra TIME-->














            
              <!-- ////////////////////////////////////////////////////////////// -->
              <!-- ////////////////////////////////////////////////////////////// -->
              <!-- ////////////////////////////////////////////////////////////// -->
              <!-- ////////////////////////////////////////////////////////////// -->

              <div class="footer-box">              
                <div class="col-sm-1 col-md-1"> 
                  <a class="btn btn-primary btn-lg" href="#box1" role="button">Atras</a> 
                </div>   
                <div class="col-sm-9 col-md-9"></div>                 
                <div class="col-sm-2 col-md-2 text-right">  
                  <a class="btn btn-primary btn-lg" href="#box3" role="button">Siguiente</a>  
                </div>
                <div class="col-sm-5 col-md-5"> </div>
              </div><!-- FIN Footer -->           
            </div><!--FIN caja 02 -->



            <div  id="box3" class="box"><!-- caja 03 -->
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!-- <h4 class="modal-title">Modal Header</h4> -->
              </div> <!-- Fin del Header -->
              
              <br>
              <br>
              <br>
              <br>
              <br>

              <div class="row">
                <div class="col-xs-4 col-md-7">
                  <label id="titlelbl" for="title"><span class="st_input-field-lbl control-label">Título<span class="required">*</span></span></label>   
                </div>
                <div class="col-xs-4 col-md-5">
                  <label class="control-label">Seleccione un Proyecto: </label> 
                </div>                
              </div>

              <div class="row">
                <div class="col-md-7 selectContainer">
                  <input  type="text"  id="title"  style="text-transform:uppercase"
                      class="st_input-field" name="title" value="" title="Título de la tarea" required> 
                </div>
                <div class="col-md-4 selectContainer">
                  <select class="list form-control" name="projectid" id="projectid">
                  </select>
                </div>
              </div>

              <br>
              <div class="row">
                <div class="col-md-7">
                  <label id="subtask_deslbl" for="subtask_deslbl"><span class="subtask_deslbl control-label">Descripción<span class="required">*</span></span>
                  </label>
                </div>
                <div class="col-xs-4 col-md-5">
                  <label class="control-label control-label">Eliga una fecha de inicio: </label> 
                </div> 
              </div>

              <div class="row">
                <div class="col-md-7 selectContainer">
                  <textarea value=" " rows="8" cols="29" class="st_input-field-desc" name="description" id="description" required> 
                  </TEXTAREA>                            
                </div>
                <div class="col-xs-4 col-md-5">
                  <input type="datetime-local" name="bdaytime">
                </div> 

                
              </div>

              

              


              <div class="footer-box">              
                <div class="col-sm-1 col-md-1"> 
                  <a class="btn btn-primary btn-lg" href="#box1" role="button">Atras</a> 
                </div>   
                <div class="col-sm-2 col-md-4"></div>
                <div class="col-sm-9 col-md-2">
                  <a class="btn btn-success btn-lg center-block" href="#box2" role="button">Guardar</a> 
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
              </div>         






              

              <div class="footer-box">              
                <div class="col-sm-1 col-md-1"> 
                  <a class="btn btn-primary btn-lg" href="#box3" role="button">Atras</a> 
                </div>   
                <div class="col-sm-2 col-md-4"></div>
                <div class="col-sm-9 col-md-2">
                  <a class="btn btn-success btn-lg center-block" href="#box2" role="button">Guardar</a> 
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