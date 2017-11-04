var id = "NULL";

$(document).ready( function () {
    //vuelve al menu
    this.Exit = function(){
        $(".modal").css({ display: "none" });
    };     
    LoadProjects();
});

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
    $('.cmbfield').styleddropdown();

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

// guarda el registro.
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
            title:  $("#title").val(),
            description: $("#description").val(),
            project_id: $(".field").attr('id')
        }
    })
    .done(function(data) {
        alert(data);
        $("#title").val('');
        $("#description").val('');
      })
    .fail(showError)
    //.always(ReCargar);
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
    if($("#project").val()=="")
    {
        $("#project").css("border", "0.3px solid firebrick");
        document.getElementById('project').placeholder = "REQUERIDO";
        $("#project").focus();
        return false;
    }
    //        
    return true;
};

// Abre nuevo modal.
function New() {        
    // limpia valores.        
    id="NULL";
    /*$("#cedula").val("");
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
    });*/
    // Muestra modal.
    $(".modal").css({ display: "block" });         
};


(function ($) {
    $.fn.styleddropdown = function () {
        return this.each(function () {
            var obj = $(this)
            obj.find('.field').click(function () { //onclick event, 'list' fadein
                obj.find('.list').fadeIn(400);

                $(document).keyup(function (event) { //keypress event, fadeout on 'escape'
                    if (event.keyCode == 27) {
                        obj.find('.list').fadeOut(400);
                    }
                });

                obj.find('.list').hover(function () {},
                    function () {
                        $(this).fadeOut(400);
                    });
            });

            obj.find('.list li').click(function () { //onclick event, change field value with selected 'list' item and fadeout 'list'
                obj.find('.field')
                    .val($(this).html())
                    //.children('div',  $(this).attr('id')  ) 
                    .attr('id',  $(this).attr('id'))
                    .css({
                        'background': '#fff',
                        'color': '#333'
                    });
                obj.find('.list').fadeOut(400);
            });
        });
    };
})(jQuery);

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