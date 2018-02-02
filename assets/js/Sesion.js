
function Login() {
    //valida form
    $("#login-form").validate({
        rules: {
            password: {
                required: true
            },
            username: {
                required: true
            }
        },
        messages: {
            password:{
                required: "Ingrese su contraseña."
            },
            username:{
                required: "Ingrese su usuario de dominio."
            }
        },
        submitHandler: submitForm
    });  
};

function submitForm(){
    $.ajax({
        type: "POST",
        url: "class/Usuario.php",
        data: { 
            action: 'Login',               
            username:  $("#username").val(),
            password: $("#password").val(),
            beforeSend: function(){
                $("#error").fadeOut();
            } 
        }        
    })
    .done(function( e ) {        
        var data= JSON.parse(e);
        if(data.status=='nologin')
            $("#error").fadeIn(2000, function(){      
                $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Usuario/Contraseña inválido!</div>');
            });
        else if(data.status=='error')
            $("#error").fadeIn(2000, function(){      
                $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error!</div>');
            });
        else if(data.status=='OK'){
            location.href= data.url;
        }
    })    
    .fail(function( e ) {        
        var data= JSON.parse(e);
        $("#error").fadeIn(2000, function(){      
            $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data.status+' !</div>');
        });
    });
};

