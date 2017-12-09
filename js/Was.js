var id = "NULL";

$(document).ready( function () {
    
    

});

function Gen(){
    // CLUSTER
    $("#clustername").val(
        "C" + $("#app").val().toUpperCase()  + ($("#prd")[0].checked ? "prd" : "cer")
    );
    $("#membername").val(
        "AS" + ($("#prd")[0].checked ? "P" : "C") + $("#app").val().toLowerCase() + $("#node").val()
    );
    // JAAS
    $("#alias").val(
        "J2C"  + "ora" + $("#app").val().toLowerCase() + ($("#prd")[0].checked ? "prd" : "cer") + "Alias"
    );
    $("#description").val(
        "JAAS "  + "ORA " + $("#app").val().toUpperCase() + " (" +  ($("#prd")[0].checked ? "prd" : "cer") + ")"  
    );
    //DS
    $("#datasource").val(
        "DS"  + "ora" + $("#app").val().toLowerCase() + ($("#prd")[0].checked ? "prd" : "cer")   
    );
    $("#jndi").val(
        "jdbc/"  + "ora" + $("#app").val().toLowerCase() + ($("#prd")[0].checked ? "prd" : "cer")   
    );
    //FTP
    $("#ftp").val(
        "sudo mkftpuser ftp" +  $("#app").val().toLowerCase()  + " /was"
        
        + ($("#prd")[0].checked ? "prd" : "cer")   
    );
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