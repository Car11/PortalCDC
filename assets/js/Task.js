var id = "NULL";
var mifile = "0";
var arrayOfThisfile = [];
var arrayOffiles = [];

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
    
    $("#btn-create-new-task").click(function(){
        $(function () {
            var d_actual = new Date(Date()+"GMT-0000");
            var d_actual_iso = d_actual.toISOString().slice(0, 16);
            document.getElementById("date_started").value = d_actual_iso;
        });
    
    });


    

    Load();
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
});


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
    $("#date_creation").val('');
    $("#project_id").val('');
    $("#column_id").val('');
    $("#owner_id").val('');
    $("#date_started").val('');
};

function ShowTaskData(e){
    // Limpia el controles
    CleanCtls();
    // carga lista con datos.
    var data= JSON.parse(e);
    $("#title").val(data[0].title);
    $("#description").val(data[0].description);
    var taskdate= new Date(Number(data[0].date_due*1000));
    $("#date_due").val(taskdate);
    
    $("#project_id").val(data[0].project_id);
    /*$("#date_creation").val(data[2].title);
    $("#column_id").val(data[4].title);
    $("#owner_id").val(data[5]); //assigned
    $("#date_started").val(data[6].title);*/
    // Call API in order to get attachments and comments.
    LoadAttachments();
};

// function loadProjectsByUser(e){
//     // DATA
//     var data= JSON.parse(e);
//     $.each(data, function(i, item) {
//         var row="<li id="+item.id+">" + item.name + 
//             // "<div id="+item.id+"></div>" +         
//         "</li>";
//         $('.list').append(row);
//     });  
//     //formato combobox
//     //$('.cmbfield').styleddropdown();

// };


//Esta funcion carga en el dropdown los projectos a los
//cuales el usuario tiene acceso a solicitar tareas  
// Revisar duplicado
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
            "<td><img id=imgdelete src=img/file_download.png class=download></td>"+
            "<td><img id=imgdelete src=img/file_delete.png class=DeleteFile></td>"+
        "</tr>";
        $('#tableBody-file').append(row);
    })
    // evento click del boton modificar-eliminar
    //$('.download').click(DownloadEventHandler);
    //$('.eliminarArchivo').click(EventoClickEliminar);
    /*$('#tbl-file').DataTable( {
        "order": [[ 1, "asc" ]]
    } );*/
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

function SaveTask(){   
    // Ajax: insert / Update.
    if(!FormValidate())
        return false;
    
    var miAccion= id=='NULL' ? 'Insert' : 'Update';
    //var varDow;    
    //var varDom;
    // if(document.getElementById("chkDow").checked)
    // {
    //     varDow="t";
    // }        
    // else {
    //     varDow=$("#dow").val();
    // }
    

    // if(document.getElementById("chkDom").checked)
    // {
    //     varDom="t";
    // }        
    // else {
    //     varDom=$("#dom").val();
    // }

    // if(document.getElementById("chkSubTask").checked)
    // {
    //     varSubTask="1";
    // }else {
    //     varSubTask="0";
    // }      
    
    var arraySubTask = [];
    
    $("table#dataTable tr").each(function() {
        var arrayOfThisRow = [];
        var tableData = $(this).find('td');
        var desc_sub = (tableData[2].firstElementChild.value);
        if(desc_sub.length>2)
        {
            varSubTask="1";
        }        
        else {
            varSubTask="0";
        }
        arraySubTask.push(desc_sub);
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
    
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: miAccion,           
            title:  $("#title").val(),
            description: $("#description").val(),
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
        // alert(data);
        $("#title").val('');
        $("#description").val('');
        formatTableSubTask("dataTable");
        clearAttachments();
        $('#file-list').empty();
        Load();
        $("#cerrar-modal").click();
        // var cerrar = document.getElementById(".modal");
        // cerrar.click();
      })
    .fail(function(error) {
        var log= JSON.parse(error);
        alert(log);
    })
    //.always(ReCargar);
};    


  //Esta funcion se encarga de agregar
//mas filas en la pantalla de subtareas
function addRow(tableID) {
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

    var cell3 = row.insertCell(2);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.name = "txtbox[]";
    element2.className = " sub-task-desc"
    cell3.appendChild(element2);
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
