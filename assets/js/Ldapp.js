var id = "NULL";

$(document).ready( function () {
    
});

function Connect(){                  
    $.ajax({
        type: "POST",
        url: "class/Ldapp.php",
        data: { 
            action: 'Connect',               
            username: $("#username").val(),
            password: $("#password").val(),
            ambiente: $("#ambiente").find(":selected").text()
        }            
    })
    .done(function( e ) {        
        $('#aplicacion').html("");
        // populate select aplicacion
        var data= JSON.parse(e);
        $.each(data,function(key, value) 
        {
            try {
                $('#aplicacion').append('<option value=' + key + '>' + value["cn"][0] + '</option>');
             }
             catch (e) {  }   
        });
        // ordena arreglo
        sortSelect('aplicacion');
        // carga Ramas
        getRamas();
    })    
    .fail(function( e ) {        
        alert('Err ' + e);        
    });
};

function getRamas(){
    // var idFile = $(this).parents("tr").find("td").eq(0).text();                   
    $.ajax({
        type: "POST",
        url: "class/Ldapp.php",
        data: { 
            action: 'getRamas'
        }            
    })
    .done(function( e ) {        
        $('#rama').html("<optgroup label='Rama'></optgroup>");
        // populate select aplicacion
        var data= JSON.parse(e);
        $.each(data,function(key, value) 
        {
            try {
                $('#rama').append('<option value=' + key + '>' + value["ou"][0] + '</option>');
             }
             catch (e) {  }   
        });
        // ordena arreglo
        sortSelect('rama');
        $("#rama").val(0);
    })    
    .fail(function( e ) {        
        alert('Err ' + e);        
    });
};

function getGroupsByAppName(){
    // var idFile = $(this).parents("tr").find("td").eq(0).text();                   
    $.ajax({
        type: "POST",
        url: "class/Ldapp.php",
        data: { 
            action: 'getGroupsByAppName',               
            username:  $("#username").val(),
            password: $("#password").val(),
            ambiente: $("#ambiente").find(":selected").text(),
            app: $("#aplicacion").find(":selected").text()
        }            
    })
    .done(function( e ) {        
        $('#grupo').html("");
        // populate select aplicacion
        var data= JSON.parse(e); 
        //$("#grupo").selectpicker();
        $.each(data,function(key, value) 
        {
            try {
                $('#grupo').append('<option value=' + key + '>' + value["cn"][0] + '</option>');               
            }
            catch (e) {  }              
        });       
        //ordena arreglo
        sortSelect('grupo');
        $("#grupo").selectpicker("refresh");
    })    
    .fail(function( e ) {        
        alert('Err ' + e);        
    });
};

function sortSelect(ctlSelect){
    var options = $('#'+ctlSelect+' option');
    var arr = options.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        var t1 = o1.t.toLowerCase(), t2 = o2.t.toLowerCase();
        return t1 > t2 ? 1 : t1 < t2 ? -1 : 0;
    });
    options.each(function(i, o) {
        //console.log(i);
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });
};

function AddUser(){
    if(!$('#userlist').val()==''){
        $("#grupo option:selected").each(function() {
        alert(this.text + ' ' + this.value);        
        // llama a codigo php para agregar usuario a grupo.
        // muestra mensaje de usuario agregado o fallido.
        // muestra lista de grupos a los que pertenece.
        });
    } else alert('Ingrese los valores del usuario.');
}

function getMembershipByUser(){
    var arrayOfLines = $('#usuarios').val().split('\n');
    //$.each(arrayOfLines, function(index, item) {
    //});               
    $.ajax({
        type: "POST",
        url: "class/Ldapp.php",
        data: { 
            action: 'getMembershipByUser',   
            uids: arrayOfLines           
        }            
    })
    .done(function( e ) {        
       $('#membresia').html("");
        // populate select aplicacion
        var data= JSON.parse(e);
        $.each(data,function(key, value) 
        {
            try {
                $('#membresia').append('<option value=' + key + '>' + value['dn'] + ' ['+ value['description'][0] +']' + '</option>');
             }
             catch (e) {  }   
        });
        // ordena arreglo
        sortSelect('membresia');
        $("#membresia").selectpicker("refresh");
        //alert(e);
    })    
    .fail(function( e ) {        
        alert('Err ' + e);        
    });
};
