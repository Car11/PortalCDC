var id = "NULL";
var mifile = "0";
var arrayOfThisfile = [];
var arrayOffiles = [];
var arraySubTask = [];

let comentario = new Comment();

$(document).ready( function () {
    //accordeon
    //var acc = document.getElementsByClassName("accordion");
    /*var i;    
    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function(){
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        }
    }*/
    //vuelve al menu
    this.Exit = function(){
        $(".modal").css({ display: "none" });
    };


    //Load();
    LoadColumns(); 
    LoadProjects();
    encode_Files();

    //Permite la importacion de archivos
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

    $("#cerrar-modal").click(function(){
        // arraySubTask = [];
        // var input = '<TR><TD><INPUT id="chk" type="checkbox" name="chk"/></TD> <TD> <span style="color:#ddd;"> 1 </span></TD> <TD> <INPUT id="subtask" class="sub-task-desc" type="text"/> </TD> <TD> <INPUT type="text" name="estado" value="Pendiente"/></TD> <TD> <INPUT id="idSubTask" type="text" name="idSubTask" value="new"/></TD> </TR>';
        // $('#dataTable').empty();
        // $('#dataTable').append(input); 
        CleanCtls();
    });

});

function BtnCreateNew(){
    $(function () {
        var d_actual = new Date(Date()+"GMT-0000");
        var d_actual_iso = d_actual.toISOString().slice(0, 16);
        document.getElementById("date_started").value = d_actual_iso;
    });
    CleanCtls();
};

function LoadColumns(){
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: "LoadColumns"
        }
    })
    .done(function( e ) {            
        //alert(e);
        ShowColumn(e); 
    })    
    //.fail();
};

function ShowColumn(e){
    // Limpia el div que contiene la tabla.
    $('#drag-list').html(""); 
    // carga lista con datos.
    var data= JSON.parse(e);

    var class_position="";
    var btn_add="";
    // Recorre arreglo.
    $.each(data, function(i, item) {   
        switch(item.position) {
            case '1':
                class_position ="drag-column-on-hold";
                btn_add = '<button type="button" style="background-color: transparent; border: 0;" id="btn-create-new-task" onclick="BtnCreateNew()" data-toggle="modal" data-target=".bd-example-modal-lg"> <span class="fa fa-plus-circle" aria-hidden="true" </span></button>';
                    
    //btn_add = '<button type="button"> <span class="fa fa-plus-circle" aria-hidden="true"></span> </button>';
                break;
            case '2':
                class_position = "drag-column-in-progress";
                btn_add="";
                break;
            case '3':
                class_position = "drag-column-needs-review";
                btn_add="";
                break;
            case '4':
                class_position = "drag-column-approved";
                btn_add="";
                break;
            default:
                class_position = "drag-column-on-hold";
                btn_add="";
        }

        var row=
            // '<li class="drag-column drag-column-on-hold" id=column' + item.position + '>' +
                '<li class="drag-column ' + class_position + '">' +
                '<span class="drag-column-header">' +
                    '<h2 style="color: white; font-family: Lato; font-size: 1.3rem; margin: 0; text-transform: uppercase; font-weight: 150; line-height: 1.5; -webkit-font-smoothing: antialiased;">' + item.title + '</h2>' +
                    // '<button type="button" id="btn-create-new-task" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target=".bd-example-modal-lg">Crear Nueva</button>' +
                    btn_add +
                    // '<svg class="drag-header-more" data-target="options' + item.position + '" fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/</svg>' +
                '</span>' +                    
                '<div class="drag-options" id="options7"></div>' + 
                '<ul class="drag-inner-list" id="' + item.position + '">' +
                '</ul>' +
            '</li>';
        $('#drag-list').append(row);            
        // evento click del boton modificar-eliminar
        //$('#Update'+item.id).click(UpdateEventHandler);
        //$('#Delete'+item.id).click(UpdateEventHandler);
    })
    LoadTasks();
};

function LoadTasks(){
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: "LoadTask"
        }
    })
    .done(function( e ) {            
        //alert(e);
        ShowTasks(e); 
    })    
    // .fail(showError);
};

function ShowTasks(e){ 
    // carga lista con datos.
    var data= JSON.parse(e);

    // Recorre arreglo.
    $.each(data, function(i, item) {  
        var d_creation = moment(item.date_creation*1000).format();
        var d_creation_iso = d_creation.slice(0, 16).replace('T', ' ');
        var posicion = '#'+item.position;       
        var row=
            // '<li class="drag-item" onclick="open_task()">' +
            '<li onclick="open_task(' + item.id + ')" onmouseover="taskMouseOver(this)" onmouseout="taskMouseOut(this)">'+
                '<p>' +
                    'No: ' + item.id + '<br>' +
                    'Fecha: ' + d_creation_iso + '<br>' +  
                    'Asunto: ' + item.title + '<br>' +			
                '</p>' +
            '</li>'
        $(posicion).append(row);            
        // evento click del boton modificar-eliminar
        //$('#Update'+item.id).click(UpdateEventHandler);
        //$('#Delete'+item.id).click(UpdateEventHandler);
    })
};

function open_task(id_task) {
    id= id_task;
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: 'Load',                
            id:  id_task
        }            
    })
    .done(function( e ) {        
        ShowTaskData(e);
    })    
    .fail(showError);
    
    $('.modal').modal('show')
}

function taskMouseOver(x) {
    x.style.backgroundColor = "#33363d";
    x.style.fontWeight = "600"
    x.style.cursor = "pointer";
}

function taskMouseOut(x) {
    x.style.backgroundColor = "#1e2026";
    x.style.fontWeight = "400"
}

function encode_Files() {
    $("#inputFileToLoad").change(function() {
        arrayOffiles = [];
        var files = document.getElementById('inputFileToLoad').files;
        if (files.length > 0) {
            for (var i = 0; i < document.getElementById("inputFileToLoad").files.length; i+=1) {
                    getBase64(files[i]);
                }
        }
    }
)};

function getBase64(file) {
    arrayOfThisfile = [];
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (f) {
        arrayOfThisfile = [];
        $("dataExt", {
            src: f.target.result,
            title: file.name
        })
        arrayOfThisfile.push(file.name);
        arrayOfThisfile.push(f.target.result);
        arrayOffiles.push(arrayOfThisfile);
     };
     reader.onerror = function (error) {
       console.log('Error: ', error);
     };
};

function decode_file(e){
    //var data= JSON.parse(e);
    //var strdata= JSON.stringify(data);
    var filedec= e.split('"');
    var newstr= filedec[1]; //.replace('\', "");
    newstr= newstr.replace(/\\/g, '');
    var decodedData = window.atob(newstr); 
};

// Muestra información en ventana
function showInfo(){     
    alert('show info');
    /*$(".modal").css({ display: "none" });  
    $("#textomensaje").text("Información almacenada correctamente!!");
    $("#mensajetop").css("background-color", "#016DC4");
    $("#mensajetop").css("color", "#FFFFFF");    
    $("#mensajetop").css("visibility", "visible");
    $("#mensajetop").slideDown("slow");
    $("#mensajetop").slideDown("slow").delay(3000).slideUp("slow");*/
};

// Muestra errores en ventana
function showError(){        
    alert('show error');
    /*$(".modal").css({ display: "none" });  
    $("#textomensaje").text("Error al procesar la información");
    $("#mensajetop").css("background-color", "firebrick");
    $("#mensajetop").css("color", "white");    
    $("#mensajetop").css("visibility", "visible");
    $("#mensajetop").slideDown("slow");
    $("#mensajetop").slideDown("slow").delay(3000).slideUp("slow");*/
};

function Load(){
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: "LoadTasksByUser"
        }
    })
    .done(function( e ) {
        ShowData(e); 
    })    
    .fail(showError);
};

function ShowData(e){
    // Limpia el div que contiene la tabla.
    $('#task-tbody').html(""); 
    // carga lista con datos.
    var data= JSON.parse(e);

    // var taskdate= new Date(Number(data[0].date_due*1000));
    // $("#date_due").val(taskdate);


    // Recorre arreglo.
    $.each(data, function(i, item) {   

        var d_creation = new Date((item.date_creation)*1000);
        var d_creation_iso = d_creation.toISOString().slice(0, 16).replace('T', ' ');
        var row=
            '<tr>'+
                '<td align="center">'+
                    '<a id=Update'+item.id+' class="btn btn-default"><em class="fa fa-pencil"></em></a>'+
                    '<a id=Delete'+item.id+' class="btn btn-danger"><em class="fa fa-trash"></em></a>'+
                '</td>'+
                '<td class="hidden-xs">'+ item.id +'</td>'+
                '<td style="min-width: 17em; max-width: 17em;">'+ item.title +'</td>'+
                '<td style="min-width: 22em; max-width: 22em;">'+ item.description + '</td>'+
                //'<td>'+ item.owner_id + '</td>'+
                '<td style="min-width: 6em; max-width: 7em;">'+ item.position +'</td>'+
                //'<td>'+ 'PROYECTO X' +'</td>'+
                //'<td>'+ (item.date_creation+2000000) +'</td>'+
                 '<td style="min-width: 9em; max-width: 9em;">'+ d_creation_iso +'</td>'+
                //'<td>'+ item.date_creation +'</td>'+
                //'<td>'+ item.date_modification +'</td>'+
            '</tr>';
        $('#task-tbody').append(row);            
        // evento click del boton modificar-eliminar
        //$('#Update'+item.id).click(UpdateEventHandler);
        //$('#Delete'+item.id).click(UpdateEventHandler);
    })
};

function UpdateEventHandler(){  
    $(".modal").css({ display: "block" });  
    id = $(this).parents("tr").find("td").eq(1).text();  //Columna 1 = ID tarea.
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: 'Load',                
            id:  id
        }            
    })
    .done(function( e ) {        
        ShowTaskData(e);
    })    
    .fail(showError);
};

function CleanCtls(){
    $("#title").val('');
    $("#description").val('');
    $("#project_id").val('');
    $("#column_id").val('');
    $("#owner_id").val('');
    //
    arrayOffiles = [];
    //
    arraySubTask = [];
    var input = '<TR><TD><INPUT id="chk" type="checkbox" name="chk"/></TD> <TD> <span style="color:#ddd;"> 1 </span></TD> <TD> <INPUT id="subtask" class="sub-task-desc" type="text"/> </TD> <TD> <INPUT type="text" id="estado" name="estado" value="Pendiente"/> </TD> <TD> <INPUT id="idSubTask" type="text" name="idSubTask" value="new"/></TD> </TR>';
    $('#dataTable').empty();
    $('#dataTable').append(input); 
};

function ShowTaskData(e){
    // Limpia el controles
    CleanCtls();
    // carga lista con datos.
    var data= JSON.parse(e);
    $("#title").val(data[0].title);
    $("#description").val(data[0].description);


    if ((data[0].date_started).length > 2){

        var d_started = moment((data[0].date_started)*1000).format();
        var d_started_iso = d_started.slice(0, 16);
    }

    if ((data[0].date_due).length > 2){
        var d_due = moment((data[0].date_due)*1000).format();
        // var d_due_iso = d_started.slice(0, 16).replace('T', ' ');
        var d_due_iso = d_due.slice(0, 16);
    }

    $("#project_id").val(data[0].project_id);
    $("#date_started").val(d_started_iso);
    $("#date_due").val(d_due_iso);
    /*
    $("#column_id").val(data[4].title);
    $("#owner_id").val(data[5]); //assigned
    $("#date_started").val(data[6].title);*/
    // Call API in order to get attachments and comments.
    LoadAttachments();
    LoadSubTasksByTask();
    LoadComments();
};

function LoadComments(){
    comentario= new Comment(000, 001, 002, 'Cachac6','Carlos chacon calvo', 'Pruebas clase Comentarios', 'reference', '00/00/01 ', '01/02/0003');
    //
    var commentBox= `
        <div class="comment " id="comment${comentario.id}" > 
            <div class="avatar avatar-48 avatar-left"> 
                <div class="avatar-letter" style="background-color: rgb(154, 108, 224)" title="${comentario.name}">${comentario.username}</div> 
            </div>
            <div class="comment-title"> <strong class="comment-username"> ${comentario.name} </strong> </div>
            <div class="comment-content"> <div class="markdown"> <p> ${comentario.comment} </p> </div>
        </div>
    `; 
    //
    $('#commentBox').append(commentBox);
};

//Esta funcion carga en el dropdown los projectos a los
//cuales el usuario tiene acceso a solicitar tareas  
function loadProjectsByUser(e){
    // DATA
    var data= JSON.parse(e);
    $.each(data, function(i, item) {
        var row="<option value="+item.id+">" + item.name + 
            // "<div id="+item.id+"></div>" +         
        "</option>";
        $('.list').append(row);
    });  
    //formato combobox
    //$('.cmbfield').styleddropdown();

};

function LoadProjects(){
    $.ajax({
        type: "POST",
        url: "class/Project.php",
        data: { 
            action: "GetByUserID"
        }
    })
    .done(function( e ) {            
         loadProjectsByUser(e);
    })    
    .fail(showError);
};

function clearAttachments(){
    document.getElementById("inputFileToLoad").value = "";
    $('#listFiles').html('');
};

function showAttachments(e){
    // Limpia el div que contiene la tabla.
    $('#file-list').html(""); 
    $('#file-list').append("<br><br><br> <table id='tbl-file' class='display' cellspacing='0' width='100%' > </table>");
    var col= "<thead><tr> <th style='display:none;'>ID</th> <th>Nombre del Archivo</th> <th>Fecha</th> <th>Descargar</th> <th>Eliminar</th> </tr></thead>"+
        "<tbody id='tableBody-file'>  </tbody>";
    $('#tbl-file').append(col); 
    //
    var data= JSON.parse(e);
    $.each(data, function(i, item) {
        var row="<tr class=datarow>"+
            "<td style='display:none;' >" + item.id +"</td>" +
            "<td>"+ item.name + "</td>"+
            "<td>"+ item.date + "</td>"+
            "<td><img id=update" + item.id +" src=img/file_download.png class=download></td>"+
            "<td><img id=delete" + item.id +" src=img/file_delete.png class=DeleteFile></td>"+
        "</tr>";        
        $('#tableBody-file').append(row);
        // evento click del boton modificar-eliminar
        $('#update' + item.id).click(DownloadEventHandler);
        $('#delete' + item.id).click(DeleteAttachmentEventHandler);
    })    
    /*$('#tbl-file').DataTable( {
        "order": [[ 1, "asc" ]]
    } );*/
};

function DeleteAttachmentEventHandler(){  
    //$(".modal").css({ display: "block" });  
    idFile = $(this).parents("tr").find("td").eq(0).text();  //Columna 1 = ID tarea.
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: 'DeleteAttachment',                
            idFile:  idFile
        }            
    })
    .done(function() {   
        // limpia control      
        swal({
            position: 'top-end',
            type: 'success',
            title: 'Archivo Eliminado',
            showConfirmButton: false,
            timer: 1500
        });
    })    
    .fail(showError)
    .always(function(){
        LoadAttachments();
    });
};

function DownloadEventHandler(){  
    //$(".modal").css({ display: "block" });  
    idFile = $(this).parents("tr").find("td").eq(0).text();  //Columna 1 = ID tarea.
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: 'DownloadTaskFile',                
            idFile:  idFile
        }            
    })
    .done(function( e ) {        
        // descarga de archivo
        decode_file(e);
    })    
    .fail(showError);
};

function LoadAttachments(){
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: 'LoadTaskFiles',                
            id:  id
        }            
    })
    .done(function( e ) {
        showAttachments(e);
    })    
    .fail(showError);
};

function LoadSubTasksByTask(){
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: 'LoadSubTasksByTask',                
            id:  id
        }            
    })
    .done(function( e ) {
        showSubTasks(e);
    })    
    .fail(showError);
};

function showSubTasks(e){
    var data= JSON.parse(e);
    $.each(data, function(i, item) {
        if(i==0) // primer linea
        {
            $('#subtask').val(item.title);
            $('#estado').val(EstadoTarea(item.status));
            $('#idSubTask').val(item.id);
        }
        else
        {
            addRow('dataTable', item.title, item.position, item.status, item.id);
        }
    })    
};

function SaveTask(){
    // Ajax: insert / Update.
    if(!FormValidate())
        return false;    
    var miAccion= id=='NULL' ? 'Insert' : 'Update';   
    //
    var subTaskElement = new Object();
    // Del texto de descripción elimina los espacios en blanco al inicio y al final  
    // del texto asi como las tabulaciones, los saltos de linea y las comillas dobles.
    var textoDes = $("#description").val();
    textoDes = textoDes.split("\t").join(" ");
    textoDes = textoDes.split("\n").join(" ");
    textoDes = textoDes.split("\"").join("'");
    textoDes = $.trim(textoDes);

    var title_validate = $("#title").val();
    title_validate = title_validate.split("\t").join(" ");
    title_validate = title_validate.split("\n").join(" ");
    title_validate = title_validate.split("\"").join("'");
    title_validate = $.trim(title_validate);
    //
    $("table#dataTable tr").each(function(i, row) {
        console.log(row);
    });
    //    
    varSubTask="0";
    $("table#dataTable tr").each(function() {
        var arrayOfThisRow = [];
        var tableData = $(this).find('td');
        var desc_sub = (tableData[2].firstElementChild.value);
        var id_sub = (tableData[4].firstElementChild.value);
        //if(desc_sub.length>2)
        //{
            varSubTask="1";
            desc_sub = desc_sub.split("\t").join(" ");
            desc_sub = desc_sub.split("\n").join(" ");
            desc_sub = desc_sub.split("\"").join("'");
            desc_sub = $.trim(desc_sub);
            subTaskElement = new Object();
            subTaskElement.title= desc_sub;
            subTaskElement.id= id_sub;
        //}        
        //else {
        //  varSubTask="0";
        //}
        arraySubTask.push(subTaskElement);
    });
    
    if (arrayOffiles.length > 0){    
        for(var i=0; i<arrayOffiles.length; i++) {
            var ImageURL = arrayOffiles[i][1];
            // Split the base64 string in data and contentType
            var block = ImageURL.split(";");
            // Get the content type of the image
            var contentType = block[0].split(":")[1];// In this case "image/gif"
            // get the real base64 content of the file
            var realData = block[1].split(",")[1];// In this case "R0lGODlhPQBEAPeoAJosM...."
            arrayOffiles[i][1] = realData;            
        }
        mifile = "1";
        
        
    }else {
        mifile = "0";
    }   
    $('#btnSaveTask').attr("disabled", "disabled");
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: miAccion, 
            id: id,          
            title:  title_validate,
            description: textoDes,
            projectid: $("#projectid").val(),
            date_started: $("#date_started").val(),
            date_due: $("#date_due").val(),
            mifile: mifile,
            subtask_des: JSON.stringify(arraySubTask),
            subTask: varSubTask,
            objFile: JSON.stringify(arrayOffiles)                       
        }
    })
    .done(function(data) {
        swal({
            position: 'top-end',
            type: 'success',
            title: 'Tarea enviada',
            showConfirmButton: false,
            timer: 1500
        });
        $("#title").val('');
        $("#description").val('');
        formatTableSubTask("dataTable");
        clearAttachments();
        $('#file-list').empty();
        $("#cerrar-modal").click();
        LoadColumns(); 
      })
    .fail(function(error) {
        var log= JSON.parse(error);
        alert(log);
    })
    .always(function() {
        setTimeout('$("#btnSaveTask").removeAttr("disabled")', 1500);
        arraySubTask = [];
        var input = '<TR><TD><INPUT id="chk" type="checkbox" name="chk"/></TD> <TD> <span style="color:#ddd;"> 1 </span></TD> <TD> <INPUT id="subtask" class="sub-task-desc" type="text"/> </TD> <TD> <INPUT type="text" id="estado" name="estado" value="Pendiente"/> </TD> <TD> <INPUT id="idSubTask" type="text" name="idSubTask" value="new"/></TD> </TR>';
        $('#dataTable').append(input); 
    });
};    

//Esta funcion se encarga de agregar
//mas filas en la pantalla de subtareas
function addRow(tableID, contenido=null, posicion=null , estado=null, subtaskId=null) {
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell1 = row.insertCell(0);
    var element1 = document.createElement("input");
    element1.type = "checkbox";
    element1.name="chkbox[]";
    cell1.appendChild(element1);

    var cell2 = row.insertCell(1);
    Count = rowCount + 1;
    cell2.innerHTML =  "<span style='color:#ddd;'>" + Count + "<\/span>";
    // contenido texto
    var cell3 = row.insertCell(2);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.name = "txtbox[]";
    element2.className = " sub-task-desc"
    if(contenido!=null)
        element2.value= contenido;
    cell3.appendChild(element2);
    // estado
    var cell4 = row.insertCell(3);
    var element3 = document.createElement("input");
    element3.type = "text";
    if (estado!=null)
        element3.value= EstadoTarea(estado);
    else element3.value= 'Pendiente';
    cell4.appendChild(element3);    
    // subtask id
    var cell5 = row.insertCell(4);
    var element4 = document.createElement("input");
    element4.type = "text";   
    if (subtaskId!=null)
        element4.value= subtaskId;
    else element4.value= 'new';
    cell5.appendChild(element4); 
};

//Esta funcion borra las filas seleccionadas en 
//la pantalla de crear subtareas
function deleteRow(tableID) {
    try {
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;

    for(var i=0; i<rowCount; i++) {
        var row = table.rows[i];
        var chkbox = row.cells[0].childNodes[0];
        if(null != chkbox && true == chkbox.checked) {
            table.deleteRow(i);
            rowCount--;
            i--;
        }
    }
    }catch(e) {
        alert(e);
    }
};

//Esta funcion reinicia la tabla a su valor origuinal en 
//la pantalla de crear subtareas
function formatTableSubTask(tableID) {
    try {

        $("#subtask").val('');
    //$(("table#dataTable tr td").firstElementChild).val('');




    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;

    for(var i=0; i<(rowCount-1); i++) {
            table.deleteRow(rowCount-i-1);
    }
    //addRow(tableID);
    }catch(e) {
        alert(e);
    }
};

function FormValidate(){
    if($("#title").val()=="")
    {
        $("#title").css("border", "0.3px solid firebrick");
        document.getElementById('title').placeholder = "REQUERIDO";
        $("#title").focus();
        return false;
    }        
    else if($("#title").val().length<5)
    {
        $("#title").css("border", "0.3px solid firebrick");
        // mensaje
        showError("Título: Mínimo 5 digitos sin guiones ni espacios");
        return false;
    }
    //
    if($("#description").val()!="")
    {
        if($("#description").val().length<5)
        {
            $("#description").css("border", "0.3px solid firebrick");
            // mensaje
            showError("La descripción debe tener mínimo 5 caracteres");
            return false;
        }
    }
    
    //      
    
    
    var cadena = $("#description").val();
    CadenaSinEspacios = cadena.trim();
    // document.getElementById('description').val() = CadenaSinEspacios;
    document.getElementById ("description").value = CadenaSinEspacios;

    return true;
};

function EstadoTarea(e=null){
    if (e==null)
    return 'Desconocido';
    else if(e==0)
        return 'Pendiente';
    else if(e==1)
        return 'En Ejecución';
    else if(e==2)
        return 'Completado';
}
