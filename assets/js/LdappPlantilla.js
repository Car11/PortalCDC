var id = "NULL";

$(document).ready( function () {
    $('#btnLogin').click(LoadPlantilla);
    //
     // Filtro por fecha
     $('#aplicacion').on('change', function (e) {
        //var optionSelected = $("option:selected", this);
        //filtrofecha = this.value;
        getGroupsByAppName();
    });
    //
    // $("#frmPlantilla").validate({
    //     rules: {
    //         'inp-nombre-chofer': "required",
    //         'inp-cuenta-chofer': "required",
    //         'inp-cedula-chofer': {
    //             required: true,
    //             number:true
    //             //minlenght:5
    //         },
    //         'inp-correo-chofer': {
    //             required: true,
    //             email: true
    //         },
    //         'inp-tel-chofer': {
    //             number: true
    //         }
    //     },
    //     // messages: {
    //     //     'inp-nombre-chofer': "Ingrese el nombre del Chofer.",
    //     //     'inp-cuenta-chofer': "Ingrese el cuenta del Chofer.",
    //     //     'inp-cedula-chofer': "Ingrese el cedula del Chofer."            
    //     // },
    //     submitHandler: Send
    // });  
    
});

function Send(){
    alert('Send();');
};

function LoadPlantilla(){                  
    $.ajax({
        type: "POST",
        url: "../class/Ldapp.php",
        data: { 
            action: 'LoadPlantilla',               
            username: $("#username").val(),
            password: $("#password").val(),
            //ambiente: $("#ambiente").find(":selected").text()
        }            
    })
    .done(function( e ) {        
        $('#aplicacion').html("");
        // populate select - aplicaciones
        var data= JSON.parse(e);
        $.each(data,function(key, value) 
        {
            try {
                $('#aplicacion').append('<option value=' + key + '>' + value["cn"][0] + '</option>');
             }
             catch (e) {  }   
        });
        // ordena arreglo de aplicaciones
        sortSelect('aplicacion');
        // carga Ramas
        getRamas();
        $("#rama").val(3);
    })    
    .fail(function( e ) {        
        alert('Err ' + e);        
    });
};
