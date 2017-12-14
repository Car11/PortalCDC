var id = "NULL";

$(document).ready( function () {
    
    

});

function Connect(){
    // var idFile = $(this).parents("tr").find("td").eq(0).text();                   
    $.ajax({
        type: "POST",
        url: "class/Ldapp.php",
        data: { 
            action: 'Connect',                
            username:  $("#username").val(),
            password: $("#password").val()
        }            
    })
    .done(function( e ) {        
        alert('Listo!!');
        
    })    
    .fail(function( e ) {        
        alert('Err xxx');
        
    });
};
/*
String.prototype.format = function() {
    var str = this;
    for (var i = 0; i < arguments.length; i++) {       
      var reg = new RegExp("\\{" + i + "\\}", "gm");             
      str = str.replace(reg, arguments[i]);
    }
    return str;
  }
*/