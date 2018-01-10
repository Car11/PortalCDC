var id = "NULL";

$(document).ready( function () {
    
    

});

function Gen(){
    //data base
    var db="";
    switch($('#basedatos').val()){
        case 'Oracle':
            db='ora';
            break;
        case 'Sybase':
            db='syb';
            break;
        case 'SqlServer':
            db='sql';
            break;
        case 'MySql':
            db='mys';
            break;
    }
    //FULL APP NAME
    $("#fullappname").val(
        ($("#prd")[0].checked ? "ASP" : "ASC") +  $("#app").val().toLowerCase()  + $("#node").val()
    );
    // CLUSTER
    $("#clustername").val(
        "C" + $("#app").val().toUpperCase()  + ($("#prd")[0].checked ? "prd" : "cer")
    );
    $("#membername").val(
        "AS" + ($("#prd")[0].checked ? "P" : "C") + $("#app").val().toLowerCase() + $("#node").val()
    );
    // JAAS
    $("#alias").val(
        "J2C"  + db + $("#app").val().toLowerCase() + ($("#prd")[0].checked ? "prd" : "cer") + "Alias"
    );
    $("#description").val(
        "JAAS "  + db.toUpperCase() + " " + $("#app").val().toUpperCase() + " (" +  ($("#prd")[0].checked ? "prd" : "cer") + ")"  
    );
    //DS
    $("#datasource").val(
        "DS"  + db + $("#app").val().toLowerCase() + ($("#prd")[0].checked ? "prd" : "cer")   
    );
    $("#jndi").val(
        "jdbc/"  + db + $("#app").val().toLowerCase() + ($("#prd")[0].checked ? "prd" : "cer")   
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