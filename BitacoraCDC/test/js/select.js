$('.drop_datacenter').select2({
    placeholder: {
        id: 'DC',
        text: 'Seleccione Centro de Datos'
    },
    width: '100%',   
    theme: 'bootstrap4', 
    ajax: {
        url: "../class/DataCenter.php",
        dataType: 'json',               
        type: "POST",
        data: function (params) {
            var query = {
                action: "SeleccionarDataCenter"
            }    
            return query;
        },
        processResults: function (data, params) {
            var data = $.map(data, function (obj) {
                obj.id = obj.id;
                obj.text = obj.nombre;
                return obj;
            });
            return {
                results: data
            };
        },
    },
});
