function Login(){$("#login-form").validate({rules:{password:{required:!0},username:{required:!0}},messages:{password:{required:"Ingrese su contraseña."},username:{required:"Ingrese su usuario de dominio."}},submitHandler:submitForm})}function submitForm(){$.ajax({type:"POST",url:"class/Usuario.php",data:{action:"Login",username:$("#username").val(),password:$("#password").val(),beforeSend:function(){$("#error").fadeOut()}}}).done(function(r){var s=JSON.parse(r);"nologin"==s.status?$("#error").fadeIn(2e3,function(){$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Usuario/Contraseña inválido!</div>')}):"error"==s.status?$("#error").fadeIn(2e3,function(){$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error!</div>')}):"OK"==s.status&&(location.href=s.url)}).fail(function(r){var s=JSON.parse(r);$("#error").fadeIn(2e3,function(){$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+s.status+" !</div>")})})}