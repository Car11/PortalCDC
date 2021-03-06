var id = "NULL";
var mifile = "0";
var arrayOfThisfile = [];
var arrayOffiles = [];
var arraySubTask = [];
var active_project_id = null;

$(document).ready( function () {
    //1. CARGA DE LOS PROYECTOS DEL USUARIO
    //2. CARGA LAS COLUMNAS DEL PRIMERO PROYECTO ENCONTRADO
    //3. CARGA LAS TAREAS DE LAS COLUMNAS DEL PRIMER PROYECTO ENCONTRADO
    
    LoadProjects();

    //logout
    $('#logout').click(function(){
        $.ajax({
          type: "POST",
          url: "class/Sesion.php",
          data: { 
            action: 'logout'
          }
      })
      .done(function( ) {
        location.href= 'index.html';
      });
    });
    //vuelve al menu
    this.Exit = function(){
        CleanCtls();
        $(".modal").css({ display: "none" });        
    };
    //
    $('#btnSearch').click(function(){
        $('#search').show();
    });
    $("#search").on('keyup', function (e) {
        var searchText = $('#buscar').val();
        $('.drag-inner-list > li').each(function(){            
            var currentLiText = $(this)[0].className.toLowerCase(),
                showCurrentLi = currentLiText.indexOf(searchText.toLowerCase()) !== -1;
            $(this).toggle(showCurrentLi);
        });  
        if (e.keyCode == 113) {
            // Al presionar f2 busca en el historial las tareas cerradas.
            LoadTaskByName();
        }
    });
    setInterval(function() {
      LoadTasks(); 
    }, 5000);
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
        CleanCtls();
        clearAttachments();        
    });
    $("#btnSaveComment").click(function(){
        comment.taskId= id;
        comment.Save;
        //$("#frmComment").validator('update') 
    });
    $(".modal-open").click(function(){
        alert('cerrar modal');
    });
});

function sel_ProyectobyUser_change(el){
  active_project_id = parseInt(el.value);
  $('li.task').html('');
  LoadColumns();
}

function BtnCreateNew(){
    id= "NULL";
    $('#row-comments').hide();
    $('#ModalLabel').text('Ingresar Nueva Tarea');
    //
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: "serverDatetime"
        }
    })
    .done(function(e) {
        var d_actual = e.slice(0, 16);
        document.getElementById("date_started").value = d_actual;
        document.getElementById("date_due").value = "";
    })    
    .fail(function(){
        var d_actual = new Date(Date()+"GMT-0000");
        var d_actual_iso = d_actual.toISOString().slice(0, 16);
        document.getElementById("date_started").value = d_actual_iso;
        document.getElementById("date_due").value = "";
    });
    //CleanCtls();
    //clearAttachments();
};

function LoadColumns(){
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: "LoadColumns",
            project_id: active_project_id
        }
    })
    .done(function( e ) {
        ShowColumn(e);
    })    
};

function ShowColumn(e){
    // Limpia el div que contiene la tabla.
    $('#drag-list').html("");
    // carga lista con datos.
    var data= JSON.parse(e);
    //
    var class_position="";
    var btn_add="";
    var btn_template="";
    // Recorre arreglo.
    $.each(data, function(i, item) {   
        switch(item.position) {
            case '1':
                class_position ="drag-column-on-hold";
                btn_add = '<button type="button" style="background-color: transparent; border: 0;" id="btn-create-new-task" onclick="BtnCreateNew()" data-toggle="modal" data-target=".bd-example-modal-lg"> <span class="fa fa-plus-circle" aria-hidden="true" </span></button>';
                // btn_template = '<button type="button" style="background-color: transparent; border: 0;" id="btn-show-list" onclick="" data-toggle="modal" data-target=".bd-list-modal-lg"> <span class="fa fa-chevron-down" aria-hidden="true" </span></button>';
                break;
            case '2':
                class_position = "drag-column-in-progress";
                btn_add="";
                btn_template = "";
                break;
            case '3':
                class_position = "drag-column-needs-review";
                btn_add="";
                btn_template = "";
                break;
            case '4':
                class_position = "drag-column-approved";
                btn_add="";
                btn_template = "";
                break;
            default:
                class_position = "drag-column-on-hold";
                btn_add="";
                btn_template = "";
        }
        //
        var row=
            // '<li class="drag-column drag-column-on-hold" id=column' + item.position + '>' +
                '<li class="drag-column ' + class_position + '">' +
                '<span class="drag-column-header">' +
                    '<h2 style="color: white; font-family: Lato; font-size: 1.3rem; margin: 0; text-transform: uppercase; font-weight: 150; line-height: 1.5; -webkit-font-smoothing: antialiased;">' + item.title + '</h2>' +
                    // '<button type="button" id="btn-create-new-task" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target=".bd-example-modal-lg">Crear Nueva</button>' +
                    btn_template + btn_add + 
                    // '<svg class="drag-header-more" data-target="options' + item.position + '" fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/</svg>' +
                '</span>' +                    
                '<div class="drag-options" id="options7"></div>' + 
                '<ul class="drag-inner-list" id="' + item.id + '">' +
                '</ul>' +
            '</li>';
        $('#drag-list').append(row);            
    })
    LoadTasks();
};

function LoadTasks(){
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: "LoadTask",
            project_id: active_project_id
        }
    })
    .done(function( e ) {            
        //alert(e);
        ShowTasks(e); 
    })    
};

function LoadTaskByName(){
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: "LoadTaskByName"
        }
    })
    .done(function( e ) {            
        //alert(e);
        ShowTasks(e); 
    })    
};

function ShowTasks(e){ 
    // carga lista con datos.
    var data= JSON.parse(e);
    // Recorre arreglo.
    $.each(data, function(i, item) {         
      var color= "red";
      switch(item.position) {
        case '1':
            color = "#FB7D44"
            break;
        case '2':
            color = "#2A92BF";
            break;
        case '3':
            color = "#F4CE46";
            break;
        case '4':
            color = "#00B961";
            break;
        default:
          color = "#00B961";
      }

      var d_started = moment(item.date_started*1000).format();
      var d_creation_iso = d_started.slice(0, 16).replace('T', ' ');
      var column_id = '#'+item.column_id;
      var row=
          // '<li class="drag-item" onclick="open_task()">' +
          '<li class="'+item.id+' task cajaTarea" onclick="open_task(' + item.id + ')" onmouseover="taskMouseOver(this)" onmouseout="taskMouseOut(this)" style="border-left-color: '+ color +';border-left-style: solid;margin-top: 5px;margin-bottom: 5px;color: black;background-color: whitesmoke; padding:10px;">'+
            '<p>No: ' + item.id + '<p>'+
            '<p style="font-weight: 600;">Asunto: ' + item.title.slice(0, 35) + '<p>' +
            '<p style="text-align:right;font-weight: 100;">Fecha: ' + d_creation_iso + '<p>' +
            '<p style="text-align: right;color:#444444;letter-spacing: 0.4px;"> <svg class="svg-icon" viewBox="0 0 20 20"> <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path> </svg>' + item.name + '<p>' +
          '</li>'
      if ($(`.${item.id}`).length){//Si ya existe entonces valide si esta en otra columna 
        let colActual = $(`.${item.id}`).parent().attr('id');
        let colNueva = item.column_id;
        if (colActual != colNueva){ //Si esta en otra columna, elimine la otra tarea y creela en la nueva columna 
          $(`.${item.id}`).remove();
          $(column_id).append(row);
        }
      }else{// Si no Existe entonces agreguela 
        $(column_id).append(row);        
      } 
    });
    $('#buscar').val('');
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
    
    $('.bd-example-modal-lg').modal('show')
}

function taskMouseOver(x) {
    x.style.backgroundColor = "darkgray";
    x.style.fontWeight = "600"
    x.style.cursor = "pointer";
}

function taskMouseOut(x) {
    x.style.backgroundColor = "whitesmoke";
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


function downloadURI(uri, name) {
    var link = document.createElement("a");
    link.download = name;
    link.href = uri;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    delete link;
};

// var blobObject = null;

// function createDownloadLink(anchorSelector, str, fileName){
	
//     var link = document.createElement("a");
//     link.setAttribute("id", "export");

// 	if(window.navigator.msSaveOrOpenBlob) {
// 		var fileData = [str];
// 		blobObject = new Blob(fileData);
// 		link.click(function(){
// 			window.navigator.msSaveOrOpenBlob(blobObject, fileName);
// 		});
// 	} else {
//         // var url = "data:text/plain;charset=utf-8," + encodeURIComponent(str);
//         var url = encodeURIComponent(str);
//         link.setAttribute("href", url);
//         link.click();
// 	}
// }

function saveFile (name, type, data) {
	if (data != null && navigator.msSaveBlob)
		return navigator.msSaveBlob(new Blob([data], { type: type }), name);
	var a = $("<a style='display: none;'/>");
    var url = window.URL.createObjectURL(new Blob([data], {type: type}));
	a.attr("href", url);
	a.attr("download", name);
	$("body").append(a);
	a[0].click();
  window.URL.revokeObjectURL(url);
  a.remove();
}

function decode_file(e, filename){
    var filedec= e.split('"');
    var newstr= filedec[1]; //.replace('\', "");
    newstr= newstr.replace(/\\/g, '');
    //var decodedData = window.atob(newstr); 

    var res = newstr.substr(0, 5);
    
    switch(res) {
         case "iVBOR":
            newstr = "data:image/png;base64,"+newstr;
            break;
         case "/9J/4":
            newstr = "data:application/pdf;base64,"+newstr;
            break;
         case"AAAAF":
            newstr = "data:video/mp4;base64,"+newstr;
            break;
         case "JVBER":
            newstr = "data:application/pdf;base64,"+newstr;
            break;
         case "UEsDB":
            newstr = "data:application/msword;base64,"+newstr;
            break;
        case "TVqQA":
            newstr = "data:application/x-msdownload;base64,"+newstr;
            break;
        case "PGh0b":
            newstr = "data:text/html;base64,"+newstr;
            break;
        case "/9j/4":
            newstr = "data:image/jpg;base64,"+newstr;//data:image/jpeg;base64,/9j/4AAQSk
            break;
        default:
            newstr = "data:application/octet-stream;base64,"+newstr;    
    }
    
    download(newstr, filename);

};

// Muestra información en ventana
function showInfo(){
    swal({
        position: 'top-end',
        type: 'success',
        title: 'Good!',
        showConfirmButton: false,
        timer: 750
    });
};

// Muestra errores en ventana
function showError(e){
    var data = JSON.parse(e.responseText);
    swal({
        type: 'error',
        title: 'Oops...',
        text: 'Algo no está bien (' + data.code + '): ' + data.msg, 
        footer: '<a href>Contacte a Soporte Técnico</a>',
      })
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
    // Recorre arreglo.
    $.each(data, function(i, item) {
        var d_started = new Date((item.date_started)*1000);
        var d_started_iso = d_started.toISOString().slice(0, 16).replace('T', ' ');
        var row=
            '<tr>'+
                '<td align="center">'+
                    '<a id=Update'+item.id+' class="btn btn-default"><em class="fa fa-pencil"></em></a>'+
                    '<a id=Delete'+item.id+' class="btn btn-danger"><em class="fa fa-trash"></em></a>'+
                '</td>'+
                '<td class="hidden-xs">'+ item.id +'</td>'+
                '<td style="min-width: 17em; max-width: 17em;">'+ item.title +'</td>'+
                '<td style="min-width: 22em; max-width: 22em;">'+ item.description + '</td>'+
                '<td style="min-width: 6em; max-width: 7em;">'+ item.position +'</td>'+
                 '<td style="min-width: 9em; max-width: 9em;">'+ d_started_iso +'</td>'+
            '</tr>';
        $('#task-tbody').append(row);
    })
};

function UpdateEventHandler(){
    $(".bd-example-modal-lg").css({ display: "block" });  
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
    //controls generales
    $("#title").val('');
    $("#description").val('');
    $("#column_id").val('');
    $("#owner_id").val('');
    $('#newComment').val('');
    $('#hascomments').hide();
    // adjuntos
    arrayOffiles = [];
    // subtareas
    arraySubTask = [];        
    $('#dataTable').empty();
    // 
    $('#dataTable').append(`
        <tr>
            <td> <input id="chk" type="checkbox" name="chk"/> </td>
            <td> <span style="color:#ddd;"> 1 </span> </td>
            <td> <input id="subtask" class="sub-task-desc" type="text"/> </td>
            <td> <label id="estado" name="estado" class="label label-primary"> Pendiente </label> </td>
            <td  style="visibility: hidden"> <input id="idSubTask" name="idSubTask" value="new"/> </td>
        </tr>
    `); 
    // comentarios
    $('#commentBox').html('');
    id="NULL";
};

function ShowTaskData(e){
    clearAttachments();
    //deshabilita comentarios si es una tarea nueva
    /*if(id=="NULL"){
        $('#newComment').attr("disabled", "disabled");
    } else  */

    $('#newComment').removeAttr("disabled");
    $('#row-comments').show();
    $('#ModalLabel').text('Modificar Tarea');
    // carga lista con datos.
    var data= JSON.parse(e);

    // data[0].description = data[0].description.replace(/<br\s*[\/]?>/gi, "\n");
    // data[0].description = data[0].description.replace(/<tab\s*[\/]?>/gi, "\t");
    // data[0].description = data[0].description.replace(/'/g, '"');
//FIN
    
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
    $("#date_started").val(d_started_iso);
    $("#date_due").val(d_due_iso);
    // Call API in order to get attachments and comments.
    LoadAttachments();
    LoadSubTasksByTask();
    // Comentarios
    comment.taskId= id;
    comment.LoadbyTask;
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
        $('#sel_ProyectobyUser').append(row);
    });
};

function LoadProjects(){
    $.ajax({
        type: "POST",
        url: "class/Project.php",
        data: { 
            action: "GetProjectsByUserID"
        }
    })
    .done(function( e ) {
      if (e){
        $('li.task').html('');
        loadProjectsByUser(e);
        active_project_id = parseInt(JSON.parse(e)[0].id);
        LoadColumns();
      }
    })    
    .fail(showError);
};

function clearAttachments(){
    document.getElementById("inputFileToLoad").value = "";
    $('#listFiles').html('');
    $('#file-list').html(""); 
};

function showAttachments(e){
    // Limpia el div que contiene la tabla.
    $('#file-list').html(""); 
    $('#file-list').append("<br><br><br> <table id='tbl-file' class='display' cellspacing='0' width='100%' > </table>");
    var col= "<thead><tr> <th style='display:none;'>ID</th> <th>Nombre del Archivo</th> <th>Fecha</th> <th></th> <th></th> </tr></thead>"+
        "<tbody id='tableBody-file'>  </tbody>";
    $('#tbl-file').append(col); 
    //
    var data= JSON.parse(e);
    $.each(data, function(i, item) {
        // evento click del boton modificar-eliminar
        $('#tableBody-file').append(`
            <tr class=datarow>
                <td style='display:none;' > ${item.id} </td>
                <td> ${item.name} </td>
                <td>${moment(item.date*1000).format('MMMM Do YYYY, h:mm')} </td>
                <td> <a class="js-modal-confirm" id="update${item.id}" > <i class="glyphicon glyphicon-download-alt" aria-hidden="true"> </i> Descargar </a>
                <td> <a class="js-modal-confirm" id="delete${item.id}"> <i class="glyphicon glyphicon-trash" aria-hidden="true"> </i> Eliminar </a>
                <img id=update" + item.id +" class=download></td>
            </tr>
        `);
        $('#update' + item.id).click(DownloadEventHandler);
        $('#delete' + item.id).click(DeleteAttachmentEventHandler);
    })    
};

function DeleteAttachmentEventHandler(){  
    //$(".modal").css({ display: "block" });  
    idFile =$(this).parents("tr").find("td").eq(0).text().trim();  //Columna 1 = ID tarea.
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
            timer: 750
        });
    })    
    .fail(showError)
    .always(function(){
        LoadAttachments();
    });
};

function DownloadEventHandler(){  
    //$(".modal").css({ display: "block" });  
    idFile = $(this).parents("tr").find("td").eq(0).text().trim();  //Columna 1 = ID tarea.
    idName = $(this).parents("tr").find("td").eq(1).text().trim();  //Columna 2 = Nombre de Archivo.

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
        //window.location = 'data:jpg/image;base64,iVBORw0KGgoAAAANSUhEUgAAAK8AAACvAQMAAACxXBw2AAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAWVJREFUSInNlr2Vg0AMhMUjIKQEl0Jpx3ZGKS7BIYHfzukPHevDKVolmO85mBWaWRG0Nhrf82vZMOprpe4wGMuPwMQlf3vT4/kjD64czJJUMAtUzDq3wPyX+UU9YMA7eInXbvCnwKFKn6kDjDqhaawPROB2Tu7EbhKITlx554ul7sYfAr0GYKcFK7V1Jz6UMX4ApU47e3wNrO80JOOjnoTAGjvxoGknSsJeHtQ8oRyHVQ8gjZbUlMbSnIVhn9wFlkMgD6McAJaaRZ1FWdhm0Dpoc1DJvITyF49p2N4Dh7n16iuemhQTm4Nj+Nwkmpqz53c2HiMHrQKL2Wm0CVVMeVi2MM1BK73qxFKOPcY3SsQ+fC4wYl3aLv2WRxJ2Sc02c74BJZS2PnArUA6z+P4NP9Wagk8bdVTtEOMacyjJzY3I7zRsX/oKq5fUSfnYG3jaqHGEkuw6OdgkNQLP6y3kyqZ/W+9t+BeB6j/x9fcYdwAAAABJRU5ErkJggg==' 

        decode_file(e, idName);
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
    $('#dataTable').empty();
    var data= JSON.parse(e);
    $.each(data, function(i, item) {
        addRow('dataTable', item.title, item.position, item.status, item.id);
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

    textoDes = textoDes.replace(/\n/g,"\n\r");
    textoDes = $.trim(textoDes);

    var title_validate = $("#title").val();
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
            // desc_sub = desc_sub.split("\t").join(" ");
            // desc_sub = desc_sub.split("\n").join(" ");
            // desc_sub = desc_sub.split("\"").join("'");
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
            project_id: active_project_id,
            title:  title_validate,
            description: textoDes,
            date_started: $("#date_started").val(),
            // date_due: $("#date_due").val(),
            mifile: mifile,
            subtask_des: JSON.stringify(arraySubTask),
            subTask: varSubTask,
            objFile: JSON.stringify(arrayOffiles)                       
        }
    })
    .done(function(e) {
        var data = JSON.parse(e);
        if(!data.result){
            swal({
                position: 'top-end',
                type: 'error',
                title: 'Ha ocurrido un error al crear la tarea.',
                showConfirmButton: true,
                timer: 3000
            });
            return;
        }

        swal({
            position: 'top-end',
            type: 'success',
            title: 'Tarea enviada',
            showConfirmButton: false,
            timer: 750
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
        var log= JSON.parse(error.responseText);
        if(log.code==-666)
            setTimeout(
                function(){
                    let timerInterval
                    Swal.fire({
                        title: 'Sesión Expirada!',
                        html: 'Redireccionando en <strong></strong> segundos.',
                        timer: 3000,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                                Swal.getContent().querySelector('strong')
                                    .textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        onClose: () => {
                            clearInterval(timerInterval);
                            location.href = 'Login.php';
                        }
                    }).then((result) => {
                        location.href = 'Login.php';
                    });
                },
                3000
            );
    })
    .always(function() {
        setTimeout('$("#btnSaveTask").removeAttr("disabled")', 750);                
        CleanCtls();
        clearAttachments();
    });
};    

//Esta funcion se encarga de agregar
//mas filas en la pantalla de subtareas
function addRow(tableID, contenido=null, posicion=null , estado=null, subtaskId='new') {
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
    cell4.innerHTML+=`
        <label class="label label-primary" > ${EstadoTarea(estado)}  </label>
    `;
    // subtask id
    var cell5 = row.insertCell(4);    
    cell5.className= "tdhide";
    cell5.innerHTML+=`
        <input name="idSubTask" value="${subtaskId}" />
    `;
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
                DeleteSubTask(table.rows[i].lastChild.childNodes[1].value);
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
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        for(var i=0; i<(rowCount-1); i++) {
                table.deleteRow(rowCount-i-1);
        }
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
    var cadena = $("#description").val();
    CadenaSinEspacios = cadena.trim();
    document.getElementById ("description").value = CadenaSinEspacios;
    return true;
};

function EstadoTarea(e=null){
    if (e==null)
    {
        return 'Pendiente';
    }
    else if(e==0)
    {
        return 'Pendiente';
    }
    else if(e==1)
        return 'En Ejecución';
    else if(e==2)
        return 'Completado';
}

function DeleteSubTask(idSubTaskDeleted) {
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: 'DeleteSubTask',                
            idSubTask:  idSubTaskDeleted
        }            
    })
    .done(function() {
        // swal({
        //     //position: 'top-end',
        //     type: 'success',
        //     title: 'Eliminado!',
        //     showConfirmButton: false,
        //     timer: 1000
        // });
    })    
    .fail(function (e) {
        showError(e);
    });
}
