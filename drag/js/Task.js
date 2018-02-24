$(document).ready( function () {
    LoadColumns();    
});


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
    // Recorre arreglo.
    $.each(data, function(i, item) {   
        switch(item.position) {
            case '1':
                class_position ="drag-column-on-hold";
                break;
            case '2':
                class_position = "drag-column-in-progress";
                break;
            case '3':
                class_position = "drag-column-needs-review";
                break;
            case '4':
                class_position = "drag-column-approved";
                break;
            default:
                class_position = "drag-column-on-hold";
        }

        var row=
            // '<li class="drag-column drag-column-on-hold" id=column' + item.position + '>' +
                '<li class="drag-column ' + class_position + '">' +
                '<span class="drag-column-header">' +
                    '<h2>' + item.title + '</h2>' +
                    '<svg class="drag-header-more" data-target="options' + item.position + '" fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/</svg>' +
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
    LoadTask();
};


function LoadTask(){
    $.ajax({
        type: "POST",
        url: "class/Task.php",
        data: { 
            action: "LoadTask"
        }
    })
    .done(function( e ) {            
        //alert(e);
        ShowTask(e); 
    })    
    // .fail(showError);
};


function ShowTask(e){ 
    // carga lista con datos.
    var data= JSON.parse(e);

    // Recorre arreglo.
    $.each(data, function(i, item) {  
        var d_creation = new Date((item.date_creation)*1000);
        var d_creation_iso = d_creation.toISOString().slice(0, 16).replace('T', ' ');
        var posicion = '#'+item.position;
        var row=
            '<li class="drag-item">' +
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
