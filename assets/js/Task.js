var id = "NULL";

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
    // datepicker
    /*$(function () {
        $('#datetimepicker1').datetimepicker();
    });*/
    //
    Load();
    LoadProjects();
});

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
    // Recorre arreglo.
    $.each(data, function(i, item) {
        var row=
            '<tr>'+
                '<td align="center">'+
                    '<a id=Update'+item.id+' class="btn btn-default"><em class="fa fa-pencil"></em></a>'+
                    '<a id=Delete'+item.id+' class="btn btn-danger"><em class="fa fa-trash"></em></a>'+
                '</td>'+
                '<td class="hidden-xs">'+ item.id +'</td>'+
                '<td>'+ item.title +'</td>'+
                //'<td>'+ item.description + '</td>'+
                '<td>'+ item.owner_id + '</td>'+
                '<td>'+ item.position +'</td>'+
                '<td>'+ 'PROYECTO X' +'</td>'+
                //'<td>'+ item.date_creation +'</td>'+
                //'<td>'+ item.date_modification +'</td>'+
            '</tr>';
        $('#task-tbody').append(row);            
        // evento click del boton modificar-eliminar
        $('#Update'+item.id).click(UpdateEventHandler);
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
    /*$("#date_creation").val(data[2].title);
    $("#project_id").val(data[3].title);
    $("#column_id").val(data[4].title);
    $("#owner_id").val(data[5]); //assigned
    $("#date_started").val(data[6].title);*/
    // Call API in order to get attachments and comments.
    //LoadAttachments();
};

function loadProjectsByUser(e){
    // DATA
    var data= JSON.parse(e);
    $.each(data, function(i, item) {
        var row="<li id="+item.id+">" + item.name + 
            // "<div id="+item.id+"></div>" +         
        "</li>";
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