var id = "NULL";
var vardata= Array;

$(document).ready( function () {
    
    

});

function simulateKeyPress(character) {
    jQuery.event.trigger({ type : 'keypress', which : character.charCodeAt(0) });
  }

function Var(){
   
    
    setTimeout(function() {

          $(function() {
            $('body').keypress(function(e) {
              alert(e.which);
            });
          
            simulateKeyPress("e");
          });



        //tab
        /*e.key="tab";   
        e.keyCode=e.key.charCodeAt(0);          
        e.which=e.keyCode;
        e.altKey=false;
        e.ctrlKey=true;
        e.shiftKey=false;
        e.metaKey=false;
        e.bubbles=true;
        document.dispatchEvent(e);*/
        //ctl + c
        //e.key="ctrl+c";   
        //e.keyCode=e.key.charCodeAt(0);   
        //var e = jQuery.Event("keydown");

        //e.which = 65; // 'C' key code value
        //e.ctrlKey = true;
        /*var e = new Event("keydown");
        e.key="a";   
        e.keyCode=e.key.charCodeAt(0);          
        e.which=e.keyCode;   
        e.altKey=false;
        e.ctrlKey=true;
        e.shiftKey=false;
        e.metaKey=false;
        e.bubbles=true;
        //document.fireEvent(e);
        //e.srcElement.fireEvent (e);
        //event.target.dispatchEvent(e);
        //$("body").trigger(e);
        $("#var01").trigger( {
            type: 'keypress',  key: e.key
        } );
        //alert(e.key);
        //
        e.key="c";   
        e.keyCode=e.key.charCodeAt(0);          
        e.which=e.keyCode;  
        e.altKey=false;
        e.ctrlKey=true;
        e.shiftKey=false;
        e.metaKey=false;
        e.bubbles=true;
        document.dispatchEvent(e);
        alert(e.key);
        //
        e.key="v";   
        e.keyCode=e.key.charCodeAt(0);          
        e.which=e.keyCode;  
        e.altKey=false;
        e.ctrlKey=true;
        e.shiftKey=false;
        e.metaKey=false;
        e.bubbles=true;
        document.dispatchEvent(e);
        alert(e.key);
        //console.log('data: ' + );
        //alert(ClipboardEvent.clipboardData);
        /*navigator.clipboard.read().then(function(data) {
            console.log("Your string: ", data);
          });*/

    }, 5000);


    
  


    /*
    setTimeout(function() {
        $('#var01').val(e.key);
    }, 3000);*/ //3 seconds

    
    /*jQuery.event.trigger({ type : 'keypress', which : character.charCodeAt(0) });

    var inputs = $(':input').keypress(function(e){ 
        if (e.which == 13) {
           e.preventDefault();
           var nextInput = inputs.get(inputs.index(this) + 1);
           if (nextInput) {
              nextInput.focus();
           }
        }
    });*/
}
/*
function onEnterKey (formElement) {
    var press;
    if (window.event) {
       press = window.event.keyCode;
    } else if (e) {
       press = e.which;
    } else {
       return true;
    }
    if (press == 13) {
      formElement.focus();
      return false
    }
    return true 
}*/

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