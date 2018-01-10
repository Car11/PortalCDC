
function Login() {
    $.ajax({
        type: "POST",
        url: "class/Usuario.php",
        data: { 
            action: 'Login',               
            username:  $("#username").val(),
            password: $("#password").val()
        }            
    })
    .done(function( e ) {        
        // Mensaje de login invalido
        if(e)
            alert('OK!');
        else alert('Invalido!')
    })    
    .fail(function( e ) {        
        alert('Error:  ' + e);        
    });
};