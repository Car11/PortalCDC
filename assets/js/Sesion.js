
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
        if(data.status=='badUsername')
            $("#error").fadeIn(2000, function(){      
                $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; El usuario debe ser: usuario@dominio.ice</div>');
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




class Session {
    // Constructor
    constructor(user_id, userName, rol, name, estado) {
        this.user_id = user_id || null;
        this.userName = userName || null;
        this.rol = rol || null;
        this.name = name || null;
        this.estado = estado || null;
    };


    check(){
        $.ajax({
            type: "POST",
            url: "class/Sesion.php",
            data: { 
                action: "check"
            }
        })
        .done(function( e ) {
            var user = JSON.parse(e);

            if (user.estado){
                session.user_id = user.userid;
                session.userName = user.username;
                session.rol = user.rol;
                session.name = user.name;
                session.estado = user.estado;
            }else
                window.location.href = "Login.php";

            
        })    
        // .fail(showError);
    }
}

    //Class Instance
let session = new Session();