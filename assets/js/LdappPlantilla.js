var id = "NULL";

$(document).ready( function () {
    //$('#btnLogin').click(LoadPlantilla); 
    $('#btnLogin').click(function(){
        getApps();
        getRamas();
    }); 
    //
    //DisableForm();
    //$('#frmPlantilla').children(':input').attr('disabled', 'disabled');
    //$('#frmPlantilla').children(':select').attr('disabled', 'disabled');
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

function DisableForm(){
    $('#frmPlantilla').children(':input').attr('disabled', 'disabled');
};

function EnableForm(){
    $('#frmPlantilla').children(':input').removeAttr('disabled');
};

function Send(){
    alert('Send();');
};

// function LoadPlantilla(){                  
//     $.ajax({
//         type: "POST",
//         url: "../class/Ldapp.php",
//         data: { 
//             action: 'Connect',//'LoadPlantilla',               
//             username: $("#username").val(),
//             password: $("#password").val(),
//             ambiente: $("#ambiente").find(":selected").text()
//         }            
//     })
//     .done(function( e ) {    
//         var data= JSON.parse(e); 
//         // Check for data errors
//         if(data.iderr!=null){
//             $('#aplicacion').html("<optgroup label='Aplicaciones'></optgroup>");
//             $('#rama').html("<optgroup label='Rama'></optgroup>");
//             $('#grupo').html("<optgroup label='Grupo'></optgroup>");
//             alert(data.iderr + ': ' + data.error)
//             return;
//         }
//         // apps
//         getApps();
//         // carga Ramas
//         //getRamas();
//         //$("#rama").val(3);
//     })    
//     .fail(function( e ) {        
//         alert('Err ' + e);        
//     });
// };
