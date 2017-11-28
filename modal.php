
<html>
<head>
    <meta charset="UTF-8">
    <title>Mi Cuenta</title>
    <link rel="stylesheet" href="css/Style-ScheduledTask.css"/>
    <link href="cssStyle-ScheduledTask.css" rel="stylesheet" />
    
   </head>

<body> 
    <header>
        <h1>LISTA DE VISITANTES</h1>        
        <div id="logo"><img src="img/Logoice.png" height="75" > </div>
        <div id="signin">

        </div>
    </header>

                   
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
            <div id="form">
                <form name="scheduledtask" id='scheduledtask' method="POST" >
                    <label id="titlelbl" for="title"><span class="st_input-field-lbl">Título<span class="required">*</span></span>
                        <input autofocus type="text"  id="title"  style="text-transform:uppercase"
                            class="st_input-field" name="title" value="" title="Título de la tarea"  required >                                
                    </label>

                    <label for="description"><span class="st_input-field-lbl">Descripción<span class="required">*</span></span>
                        <TEXTAREA value=" " rows="8" cols="32" 
                            class="st_textarea-field" name="description" id="description" required> </TEXTAREA>
                    </label>
                    <label for="minute"><span class="st_input-field-lbl-time">Minuto<span class="required">*</span></span>
                        <input type="number" min="0" max="59" step="1"
                            class="st_input-field" name="minute" value="00" id="minute" required >  
                    </label>
                    <label for="hour"><span class="st_input-field-lbl-time">Hora<span class="required">*</span></span>
                        <input type="number" min="0" max="23" step="1"
                                class="st_input-field" name="hour" value="00" id="hour" required >                            
                    </label>

                    <label for="dom"><span class="st_input-field-lbl-time">Día del Mes<span class="required">*</span></span>
                        <input type="number" min="1" max="31" step="1"
                                class="st_input-field" name="dom" value="00" id="dom" required >
                    </label>
                    
                    <label for="chkDom"><span class="st_input-field-lbl-time">Todos:</span>
                        <input type="checkbox" id="chkDom" name="chkDom" onclick="document.scheduledtask.dom.disabled=!document.scheduledtask.dom.disabled"> Si, todos los días del mes<br>
                    </label>
                    
                    <label for="year"><span class="st_input-field-lbl-time">Año<span class="required">*</span></span>
                        <input type="number" min="2017" max="2027" step="1"
                                class="st_input-field" name="year" value="2017" id="year" required >
                    </label>
                    
                    <label for="dow"><span class="st_input-field-lbl-time">Día de la Semana<span class="required">*</span></span>
                        <select class="st_input-field" name="dow" value="" id="dow" required>
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
                    
                    <label for="ChkDow"><span class="st_input-field-lbl-time">Todos:</span>
                        <input type="checkbox" name="chkDow" id="chkDow" onclick="document.scheduledtask.dow.disabled=!document.scheduledtask.dow.disabled"> Si, todos los días de la semana<br>
                    </label>
                    <nav class="btnfrm">
                        <ul>
                            <li><button type="button" class="nbtn_blue" onclick="SaveScheduledTask()" >Guardar</button></li>
                            <li><button type="button" class="nbtn_gray" onclick="Exit()" >Cerrar</button></li>                                
                        </ul>
                    </nav>                          
                </form></div>
        </div>    
            <div class="modal-footer">
                <br>
            </div>
        </div>
    </div>      
    <!-- FIN MODAL -->
     
    <INPUT type="button" value="Add Row" onclick="addRow('dataTable')" />
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
                <button onclick="addSubTaskTable()">Añadir SubTarea</button>
              
    </body>
</html>