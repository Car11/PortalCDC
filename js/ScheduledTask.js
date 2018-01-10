var id = "NULL";
var arrayOfThisfile = [];
var arrayOffiles = [];

//Llama a la funcion de Load y LoadProjects al cargar la pagina
$(document).ready( function () {
    //vuelve al menu
    this.Exit = function(){
        $(".modal").css({ display: "none" });
    }; 
    Load();
    LoadProjects();
    Check_SubTask_Status();
    encode_Files();
   
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
  }

// Llama a la funcion LoadScheduledTask dentro de class/ScheduledTask.php para
// traer los datos de todas las tareas programadas en la base de datos
// y mostrarlas con el proceso ShowData(e)
function Load(){
    $.ajax({
        type: "POST",
        url: "class/ScheduledTask.php",
        data: { 
            action: "LoadScheduledTask"
        }
    })
    .done(function( e ) {            
        ShowData(e); 
    })    
    .fail(showError);
};

// Llama a la funcion GetByUserID dentro de class/ScheduledTask.php para
// traer los proyectos donde el usuario tiene permisos para crear tareas
// una vez que trae los proyectos de la base de datos, se los enviar a 
// loadProjectsByUser para que los impirima en una tabla dentro de la pagina web
function LoadProjects(){
    $.ajax({
        type: "POST",
        url: "class/ScheduledTask.php",
        data: { 
            action: "GetByUserID"
        }
    })
    .done(function( e ) {            
         loadProjectsByUser(e);
    })    
    .fail(showError);
};



// Completa en la pagina web una tabla con todos los proyectos traidos desde la base de datos
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

//Imprime en la pagina la tabla con las tareas existentes en la base de datos
function ShowData(e){
    // Limpia el div que contiene la tabla.
    $('#item-list').html(""); 
    $('#item-list').append("<br><br><br> <table id='tbl-items' class='display tbl-items' cellspacing='0' width='100%' > </table>");
    var col= "<thead><tr> <th style='display:none;'>ID</th> <th>Usuario</th> <th>Minuto</th>  <th>Hora</th> <th>DOM</th> <th>Año</th> <th>DOW</th> <th>Titulo</th> <th>Detalle</th><th>VER TAREA</th>  </tr></thead>"+
        "<tbody id='tableBody'>  </tbody>";
    $('#tbl-items').append(col); 
    // carga lista con datos.
    var data= JSON.parse(e);
    // Recorre arreglo.
    $.each(data, function(i, item) {
        var row="<tr class=datarow>"+
            "<td style='display:none;' >" + item.id +"</td>" +
            "<td style='text-align:center'>"+ item.username + "</td>"+
            "<td>"+ item.min + "</td>"+
            "<td>"+ item.hour + "</td>"+
            "<td>"+ item.dom +"</td>"+
            "<td>"+ item.year +"</td>"+
            "<td>"+ item.dow +"</td>"+
            "<td>"+ item.title +"</td>"+
            "<td>"+ item.detail +"</td>"+
            //"<td><img id=imgdelete src=img/file_mod.png class=modificar></td>"+
            "<td><img id=imgdelete src=img/file_delete.png class=eliminar></td>"+
        "</tr>";
        $('#tableBody').append(row);
    })
    // evento click del boton modificar-eliminar
    //$('.modificar').click(UpdateEventHandler);
    $('.eliminar').click(EventoClickEliminar);
    // formato tabla
    $('#tbl-items').DataTable( {
        "order": [[ 5, "asc" ]]
    } );
};

// evento click del boton eliminar
function EventoClickEliminar(){
    id = $(this).parents("tr").find("td").eq(0).text();    
    // Mensaje de borrado:
    //alert (id);
    swal({
        title: 'Eliminar esta tarea programada?',
        text: "Esta acción es irreversible!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function(isConfirm) {
        if (isConfirm) {
            Eliminar(id);
            swal("Borrada!", "La tarea programada ha sido eliminada.", "success");
        } else {
            swal("Cancelled", "Your imaginary file is safe :)", "error");
        }
    });

// ).then(function () {
//         // eliminar registro.   
//     alert ("si entro");
//         Eliminar();
//     })
};

function Eliminar(id){      
    alert (id);      
    $.ajax({
        type: "POST",
        url: "class/ScheduledTask.php",
        data: {
            action: 'Delete',
            idScheduledTask:  id
        }
        /*,statusCode: {
            200: function (response) {
                alert('200 ec');         
            }
        }*/
    })          //  codigo bueno ***************************
    // .done(function(e){
    //     if(e=="Registro en uso")
    //     {
    //         swal(
    //         'Mensaje!',
    //         'El registro se encuentra  en uso, no es posible eliminar.',
    //         'error'
    //     );
    //     }
    //     else swal(
    //         'Eliminado!',
    //         'El registro se ha eliminado.',
    //         'success'
    //     );
    //     ReCargar();
    // })        
    // .fail(muestraError);
};


// Abre nuevo modal de Solicitud de Servicio - Nueva tarea programada.
function New() {        
    // limpia valores.        
    id="NULL";
    // Muestra modal.
    $(".modal").css({ display: "block" });         
};

function SaveScheduledTask(){   
    // Ajax: insert / Update.
    if(!FormValidate())
        return false;
    
    var miAccion= id=='NULL' ? 'Insert' : 'Update';
    var varDow;    
    var varDom;
    if(document.getElementById("chkDow").checked)
    {
        varDow="t";
    }        
    else {
        varDow=$("#dow").val();
    }
    

    if(document.getElementById("chkDom").checked)
    {
        varDom="t";
    }        
    else {
        varDom=$("#dom").val();
    }
    if(document.getElementById("chkSubTask").checked)
    {
        varSubTask="1";
    }else {
        varSubTask="0";
    }      
    
    var arraySubTask = [];
    
    $("table#dataTable tr").each(function() {
        var arrayOfThisRow = [];
        var tableData = $(this).find('td');

        var desc_sub = (tableData[2].firstElementChild.value);

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
        var mifile = "1";
        
        
    }else {
        var mifile = "0";
    }   
    
    $.ajax({
        type: "POST",
        url: "class/ScheduledTask.php",
        data: { 
            action: miAccion,
            projectid: $("#projectid").val(),           
            title:  $("#title").val(),
            description: $("#description").val(),
            minute: $("#minute").val(),
            hour:   $("#hour").val(),
            dom:    varDom,
            year:   $("#year").val(),
            subtask_des: JSON.stringify(arraySubTask),
            subTask: varSubTask,
            file: mifile,
            objFile: JSON.stringify(arrayOffiles),
            dow:    varDow            
        }
    })
    .done(function(data) {
        alert(data);
        $("#title").val('');
        $("#description").val('');
        $("#minute").val('00');
        $("#hour").val('00');
        $("#year").val('2017');
        $("#dow").val('Todos');
      })
    .fail(showError)
    //.always(ReCargar);
};    


// function Check_SubTask_Status()
// {
//     var btnAdd = document.getElementById("btnAdd");
//     btnAdd.disabled = !btnAdd.disabled;

//     var btnDel = document.getElementById("btnDel");
//     btnDel.disabled = !btnDel.disabled;


//     var tableSubtask = document.getElementById("chk");
//     tableSubtask.disabled = !tableSubtask.disabled;

//     var tableSubtask = document.getElementById("subtask");
//     tableSubtask.disabled = !tableSubtask.disabled;

// }

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
}

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
}




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
    if($("#description").val()=="")
    {
        $("#description").css("border", "0.3px solid firebrick");
        document.getElementById('description').placeholder = "REQUERIDO";
        $("#description").focus();
        return false;
    }
    else if($("#description").val().length<5)
    {
        $("#description").css("border", "0.3px solid firebrick");
        // mensaje
        showError("La descripción debe tener mínimo 5 caracteres");
        return false;
    }
    //      
    
    
    var cadena = $("#description").val();
    CadenaSinEspacios = cadena.trim();
    // document.getElementById('description').val() = CadenaSinEspacios;
    document.getElementById ("description").value = CadenaSinEspacios;

    return true;
};


// Muestra información en ventana
function showInfo(){     
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
    /*$(".modal").css({ display: "none" });  
    $("#textomensaje").text("Error al procesar la información");
    $("#mensajetop").css("background-color", "firebrick");
    $("#mensajetop").css("color", "white");    
    $("#mensajetop").css("visibility", "visible");
    $("#mensajetop").slideDown("slow");
    $("#mensajetop").slideDown("slow").delay(3000).slideUp("slow");*/
};






// (function ($) {
//     $.fn.styleddropdown = function () {
//         return this.each(function () {
//             var obj = $(this)
//             obj.find('.field').click(function () { //onclick event, 'list' fadein
//                 obj.find('.list').fadeIn(400);

//                 $(document).keyup(function (event) { //keypress event, fadeout on 'escape'
//                     if (event.keyCode == 27) {
//                         obj.find('.list').fadeOut(400);
//                     }
//                 });

//                 obj.find('.list').hover(function () {},
//                     function () {
//                         $(this).fadeOut(400);
//                     });
//             });

//             obj.find('.list li').click(function () { //onclick event, change field value with selected 'list' item and fadeout 'list'
//                 obj.find('.field')
//                     .val($(this).html())
//                     //.children('div',  $(this).attr('id')  ) 
//                     .attr('id',  $(this).attr('id'))
//                     .css({
//                         'background': '#fff',
//                         'color': '#333'
//                     });
//                 obj.find('.list').fadeOut(400);
//             });
//         });
//     };
// })(jQuery);




// function Insert_Sub_Task_Image(){
//     $.ajax({
//         type: "POST",
//         url: "class/ScheduledTask.php",
//         data: { 
//             action: "Insert_Sub_Task_Image"
//         }
//     })
//     .done(function( e ) {            
//          //loadProjectsByUser(e);
//          alert(e);
//     })    
//     .fail(showError);
// };
// function OpenSubScheduledTask(e){
//     //$(".modal").css({ display: "block" });
//     $('#myModal').modal('show')

// }

// function CloseSubScheduledTask(e){
//     //$(".modal").css({ display: "block" });
//     $('#myModal').modal('hide')

// }

// function addSubTaskTable(){
    
//         var table = document.getElementById("subTask");
//         var row = table.insertRow(0);
//         var cell1 = row.insertCell(0);
//         var cell2 = row.insertCell(1);
//         cell1.innerHTML = $("#title_subtask").val();
//         $("#title_subtask").val('');
//         alert(row);
//     };


// function UpdateEventHandler(){
//     id = $(this).parents("tr").find("td").eq(0).text();                   
//     $.ajax({
//         type: "POST",
//         url: "class/sfdsafdsa.php",
//         data: { 
//             action: 'Load',                
//             id:  id
//         }            
//     })
//     .done(function( e ) {
//         // mensaje de visitante salida correcta.
//         /*var data= JSON.parse(e);
//         $("#cedula").val(data[0].cedula);
//         $("#empresa").val(data[0].empresa);
//         $("#nombre").val(data[0].nombre);
//         $("#permiso")[0].checked= data[0].permisoanual==1?true:false;
//         $(".modal").css({ display: "block" }); */
//     })    
//     .fail(function(e){
//         /*$(".modal").css({ display: "none" });  
//         $("#textomensaje").text(e);
//         $("#mensajetop").css("background-color", "firebrick");
//         $("#mensajetop").css("color", "white");    
//         $("#mensajetop").css("visibility", "visible");
//         $("#mensajetop").slideDown("slow");
//         $("#mensajetop").slideDown("slow").delay(3000).slideUp("slow");*/
//     });
// };

// Original para cargar una lista de una tabla Completa en la pagina web una tabla con todos los proyectos traidos desde la base de datos
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
//     $('.cmbfield').styleddropdown();

// };


/*var formReady = false;


$(document).ready( function () {
    //Da la apariencia del css datatable
    ReCargar();

    //vuelve al menu
    this.onVuelve = function(){
        location.href = "ListaVisitantes.php";                       
    }; 

    // cierra el modal
    $(".close").click( function(){
        // muestra modal con info básica formulario. y btn cerrar./ x para cerrar
        $(".modal").css({ display: "none" });
    });

     // Cierra el MODAL en cualquier parte de la ventana
    window.onclick = function(event) {
        if (event.target.className=="modal") {
            $(".modal").css({ display: "none" });
        }    
    };
 

    //valida cedula unica al perder el foco en el input cedula.
    $('#cedula').focusout(ValidaCedulaUnica);

});



// Muestra errores en ventana
function muestraError_Visita(msg){        
    $("#textomensaje-secundario").text(msg);
    $("#mensajetop-secundario").css("background-color", "firebrick");
    $("#mensajetop-secundario").css("color", "white");    
    $("#mensajetop-secundario").css("visibility", "visible");
    $("#mensajetop-secundario").slideDown("slow");
    $("#mensajetop-secundario").slideDown("slow").delay(3000).slideUp("slow");
};

// AJAX: Carga la lista 
function ReCargar(){
    $.ajax({
        type: "POST",
        url: "class/Visitante.php",
        data: { 
            action: "CargarTodos"
        }
    })
    .done(function( e ) {            
        // Limpia el div que contiene la tabla.
        $('#lista').html(""); 
        $('#lista').append("<br><br><br> <table id='tblLista' class='display' > </table>");
        var col= "<thead><tr> <th style='display:none;'>ID</th> <th>CEDULA</th> <th>NOMBRE</th>  <th>EMPRESA</th> <th>PERMISO ANUAL</th> <th>MODIFICAR</th> <th>ELIMINAR</th> </tr></thead>"+
            "<tbody id='tableBody'>  </tbody>";
        $('#tblLista').append(col); 
        // carga lista con datos.
        var data= JSON.parse(e);
        // Recorre arreglo.
        $.each(data, function(i, item) {
            var row="<tr class=fila>"+
                "<td style='display:none;' >" + item.id +"</td>" +
                "<td>"+ item.cedula + "</td>"+
                "<td>"+ item.nombre + "</td>"+
                "<td>"+ item.empresa + "</td>"+
                "<td>"+ item.permisoanual +"</td>"+
                "<td><img id=imgdelete src=img/file_mod.png class=modificar></td>"+
                "<td><img id=imgdelete src=img/file_delete.png class=eliminar></td>"+
            "</tr>";
            $('#tableBody').append(row);
        })
        // evento click del boton modificar-eliminar
        $('.modificar').click(EventoClickModificar);
        $('.eliminar').click(EventoClickEliminar);
        // formato tabla
        $('#tblLista').DataTable( {
            "order": [[ 2, "asc" ]]
        } ); 
    })    
    .fail(muestraError);
};

// Abre nuevo modal.
this.Nuevo = function() {        
    // limpia valores.        
    id="NULL";
    $("#cedula").val("");
    $("#empresa").val("");
    $("#nombre").val("");
    $("#permiso")[0].checked = false;
    $("#cedula").css({
        "border": "1px solid #C2C2C2"
    });
     $("#nombre").css({
        "border": "1px solid #C2C2C2"
    });
     $("#empresa").css({
        "border": "1px solid #C2C2C2"
    });
    // Muestra modal.
    $(".modal").css({ display: "block" });         
};

// evento click del boton eliminar
function EventoClickEliminar(){
    id = $(this).parents("tr").find("td").eq(0).text();    
    // Mensaje de borrado:
    swal({
        title: 'Eliminar el Perfil?',
        text: "Esta acción es irreversible!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger'
    }).then(function () {
        // eliminar registro.
        Eliminar();
    })
};

function EventoClickModificar(){
    $("#cedula").css({
        "border-color": "green",
        "border-width": "0.3px"
    });
    //                
    id = $(this).parents("tr").find("td").eq(0).text();           
    // Ajax: Consulta visitante.        
    $.ajax({
        type: "POST",
        url: "class/Visitante.php",
        data: { 
            action: 'CargarID',                
            idvisitante:  id
        }            
    })
    .done(function( e ) {
        // mensaje de visitante salida correcta.
        var data= JSON.parse(e);
        $("#cedula").val(data[0].cedula);
        $("#empresa").val(data[0].empresa);
        $("#nombre").val(data[0].nombre);
        $("#permiso")[0].checked= data[0].permisoanual==1?true:false;
        $(".modal").css({ display: "block" }); 
    })    
    .fail(function(e){
        $(".modal").css({ display: "none" });  
        $("#textomensaje").text(e);
        $("#mensajetop").css("background-color", "firebrick");
        $("#mensajetop").css("color", "white");    
        $("#mensajetop").css("visibility", "visible");
        $("#mensajetop").slideDown("slow");
        $("#mensajetop").slideDown("slow").delay(3000).slideUp("slow");
    });
};

function wait(ms){
          
    var start = new Date().getTime();
    var end = start;
    while(end < start + ms) {
      end = new Date().getTime();
   }
   
}


function Eliminar(){            
    $.ajax({
        type: "POST",
        url: "class/Visitante.php",
        data: { 
            action: 'Eliminar',                
            idvisitante:  id
        }
        /*,statusCode: {
            200: function (response) {
                alert('200 ec');         
            }
        }*/
  /*  })            codigo bueno ***************************
    .done(function(e){
        if(e=="Registro en uso")
        {
            swal(
            'Mensaje!',
            'El registro se encuentra  en uso, no es posible eliminar.',
            'error'
        );
        }
        else swal(
            'Eliminado!',
            'El registro se ha eliminado.',
            'success'
        );
        ReCargar();
    })        
    .fail(muestraError);
};




*/