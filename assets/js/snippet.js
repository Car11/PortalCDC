// POO Class Task
function Task(id, nombre, nodo, cluster) {
    // Var
    this.id = id;
    this.nombre = nombre;
    this.nodo = nodo;
    this.cluster = cluster;
    // Methods
    this.Get = function () {
        alert(this.id);
        alert(this.nombre);
    };
};
// DOM
$(document).ready(function () {
    // Close modal
    this.Exit = function () {
        $(".modal").css({ display: "none" });
    };
    // Load lists
    Load();
});

// Muestra información en ventana
function showInfo() {
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
function showError() {
    alert('show error');
    /*$(".modal").css({ display: "none" });  
    $("#textomensaje").text("Error al procesar la información");
    $("#mensajetop").css("background-color", "firebrick");
    $("#mensajetop").css("color", "white");    
    $("#mensajetop").css("visibility", "visible");
    $("#mensajetop").slideDown("slow");
    $("#mensajetop").slideDown("slow").delay(3000).slideUp("slow");*/
};

// Carga lista
function Load() {
    $.ajax({
        type: "POST",
        url: "../class/Task.php",
        data: {
            action: "LoadTasksByUser"
        }
    })
        .done(function (e) {
            ShowData(e);
        })
        .fail(showError);
};


function ShowData(e) {
    // Limpia el div que contiene la tabla.
    $('#task-tbody').html("");
    // carga lista con datos.
    var data = JSON.parse(e);
    // Recorre arreglo.
    $.each(data, function (i, item) {
        var row =
            '<tr>' +
            '<td align="center">' +
            '<a id=Update' + item.id + ' class="btn btn-default"><em class="fa fa-pencil"></em></a>' +
            '<a id=Delete' + item.id + ' class="btn btn-danger"><em class="fa fa-trash"></em></a>' +
            '</td>' +
            '<td class="hidden-xs">' + item.id + '</td>' +
            '<td>' + item.nombre + '</td>' +
            '<td>' + item.nodo + '</td>' +
            '<td>' + item.cluster + '</td>' +
            '</tr>';
        $('#task-tbody').append(row);
        // evento click del boton modificar-eliminar
        $('#Update' + item.id).click(UpdateEventHandler);
        $('#Delete' + item.id).click(DeleteEventHandler);
    })
};

function UpdateEventHandler() {
    $(".modal").css({ display: "block" });
    id = $(this).parents("tr").find("td").eq(1).text();  //Columna 1 = ID tarea.
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: {
            action: 'Load',
            id: id
        }
    })
        .done(function (e) {
            ShowTaskData(e);
        })
        .fail(showError);
};

function DeleteEventHandler() {
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
        //Delete();
    })
};

function Delete() {
    /*id = $(this).parents("tr").find("td").eq(1).text();  //Columna 1 = ID tarea.
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
    .fail(showError);*/
};

function CleanCtls() {
    $("#nombre").val('');
    $("#nodo").val('');
    $("#cluster").val('');
};

function ShowTaskData(e) {
    // Limpia el controles
    CleanCtls();
    // carga lista con datos.
    var data = JSON.parse(e);
    $("#nombre").val(data[0].title);
    $("#nodo").val(data[0].description);
    $("#cluster").val(taskdate);
};

function New() {
    CleanCtls();
    // Show modal.
    $(".modal").css({ display: "block" });
};

function FormValidate(){
};

// Save
function Save(){   
    // Ajax: insert / Update.
    if(!FormValidate())
        return false;
    var miAccion= id=='NULL' ? 'Insert' : 'Update';
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: miAccion,  
            id: id,              
            nombre:  $("#nombre").val(),
            nodo: $("#nodo").val(),
            cluster: $("#cluster").val()
        }
    })
    .done(showInfo)
    .fail(showError)
    .always(Load);
}; 