var id="NULL",vardata=Array;$(document).ready(function(){});function Gen(){var a="";switch($("#basedatos").val()){case"Oracle":a="ora";break;case"Sybase":a="syb";break;case"SqlServer":a="sql";break;case"MySql":a="mys"}$("#appname").val($("#app").val().toUpperCase()+($("#prd")[0].checked?"prd":"cer")),$("#fullappname").val(($("#prd")[0].checked?"ASP":"ASC")+$("#app").val().toLowerCase()+$("#node").val()),$("#clustername").val("C"+$("#app").val().toUpperCase()+($("#prd")[0].checked?"prd":"cer")),$("#membername").val("AS"+($("#prd")[0].checked?"P":"C")+$("#app").val().toLowerCase()+$("#node").val()),$("#alias").val("J2C"+a+$("#app").val().toUpperCase()+(""==$("#dsdescription").val()?"":"_")+$("#dsdescription").val().toLowerCase()+($("#prd")[0].checked?"prd":"cer")+"Alias"),$("#description").val("JAAS "+a.toUpperCase()+" "+$("#app").val().toUpperCase()+" "+$("#dsdescription").val().toUpperCase()+" ("+($("#prd")[0].checked?"prd":"cer")+")"),$("#datasource").val("DS"+a+$("#app").val().toUpperCase()+(""==$("#dsdescription").val()?"":"_")+$("#dsdescription").val().toLowerCase()+($("#prd")[0].checked?"prd":"cer")),$("#jndi").val("jdbc/"+a+$("#app").val().toUpperCase()+(""==$("#dsdescription").val()?"":"_")+$("#dsdescription").val().toLowerCase()+($("#prd")[0].checked?"prd":"cer"));var e="";switch($("#wasversion").val()){case"WAS 7":e=" /was7data"+($("#prd")[0].checked?"prd":"cer")+"/logs/"+$("#fullappname").val()+" ";break;case"WAS 9":e=" /wasdata"+($("#prd")[0].checked?"prd":"cer")+"/logs/"+$("#fullappname").val()+" "}$("#ftp").val("sudo mkftpuser ftp"+$("#app").val().toLowerCase().substring(0,5)+e+'"'+$("#encargado").val()+", "+$("#email").val()+", "+$("#dept").val()+'"')}