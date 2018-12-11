class Performance {
    // Constructor
    constructor(id, cantidad, fecha) {
        this.id = id || null;
        this.cantidad = cantidad || '';
        this.fecha = fecha || '';
    }

    get tUpdate()  {
        return this.update ="update"; 
    }

    get tSelect()  {
        return this.select = "select";
    }

    set viewEventHandler(_t) {
        this.viewType = _t;        
    }

    //Getter
    get readBilling() {
        var miAccion = 'readBilling';
        //this.id == null ?  'ReadAll'  : 'Read';
        // if(miAccion=='ReadAll' && $('#tmonitoreo tbody').length==0 )
        //     return;
        $.ajax({
            type: "POST",
            url: "class/brm.php",
            data: {
                action: miAccion
            }
        })
            .done(function (e) {
                perf.Reload(e);
            })
            .fail(function (e) {
                perf.showError(e);
            });
    }

    get Save() {
        $('#btnBodega').attr("disabled", "disabled");
        var miAccion = this.id == null ? 'Create' : 'Update';
        this.cantidad = $("#cantidad").val();
        this.fecha = $("#fecha").val();
        this.ubicacion = $("#ubicacion").val();
        this.contacto = $("#contacto").val();        
        this.telefono = $("#telefono").val();
        this.tipo = $('#tipo option:selected').val();
        $.ajax({
            type: "POST",
            url: "class/brm.php",
            data: {
                action: miAccion,
                obj: JSON.stringify(this)
            }
        })
            .done(perf.showInfo)
            .fail(function (e) {
                perf.showError(e);
            })
            .always(function () {
                $("#btnBodega").removeAttr("disabled");
                perf = new Monitoreo();
                perf.ClearCtls();
                perf.Read;
                $("#cantidad").focus();
            });
    }

    get Delete() {
        $.ajax({
            type: "POST",
            url: "class/brm.php",
            data: {
                action: 'Delete',
                id: this.id
            }
        })
            .done(function () {
                swal({
                    //
                    type: 'success',
                    title: 'Eliminado!',
                    showConfirmButton: false,
                    timer: 1000
                });
            })
            .fail(function (e) {
                perf.showError(e);
            })
            .always(function () {
                perf = new Monitoreo();
                perf.Read;
            });
    }

    get ListTipos() {
        var miAccion= 'ListTipos';
        $.ajax({
            type: "POST",
            url: "class/brm.php",
            data: { 
                action: miAccion
            }
        })
        .done(function( e ) {
            perf.ShowListTipo(e);
        })    
        .fail(function (e) {
            perf.showError(e);
        })
        .always(function (e){
            $("#tipo").selectpicker("refresh");
        });
    }

    get List() {
        var miAccion= 'List';
        $.ajax({
            type: "POST",
            url: "class/brm.php",
            data: { 
                action: miAccion
            }
        })
        .done(function( e ) {
            perf.ShowList(e);
        })    
        .fail(function (e) {
            perf.showError(e);
        })
        .always(function (e){
            $("#selbodega").selectpicker("refresh");
        });
    }

    get readByUser() {
        var miAccion = "readByUser";
        $.ajax({
            type: "POST",
            url: "class/brm.php",
            data: {
                action: miAccion
            }
        })
            .done(function (e) {
                perf.ShowAllD(e);
            })
            .fail(function (e) {
                perf.showError(e);
            });
    }

    // Methods
    Reload(e) {
        if (this.id == null)
            this.ShowAll(e);
        else this.ShowItemData(e);
    };

    // Muestra información en ventana
    showInfo() {
        //$(".modal").css({ display: "none" });   
        $(".close").click();
        swal({
            
            type: 'success',
            title: 'Good!',
            showConfirmButton: false,
            timer: 1000
        });
    };

    // Muestra errores en ventana
    showError(e) {
        //$(".modal").css({ display: "none" });  
        var data = JSON.parse(e.responseText);
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Algo no está bien (' + data.code + '): ' + data.msg,
            footer: '<a href>Contacte a Soporte Técnico</a>',
        })
    };

    ClearCtls() {
        $("#id").val('');
        $("#cantidad").val('');
        $("#fecha").val('');
        $("#ubicacion").val('');
        $("#contacto").val('');
        $("#telefono").val('');
        $('#tipo option').prop("selected", false);
    };

    ShowAll(e) {
        // revisa si el dt ya está cargado.
        var t= $('#tmonitoreo').DataTable();
         if(t.rows().count()==0){
            t.clear();
            t.rows.add(JSON.parse(e));
            t.draw();
            $( document ).on( 'click', '#tmonitoreo tbody tr td:not(.buttons)', perf.viewType==undefined || perf.viewType==perf.tUpdate ? perf.UpdateEventHandler : perf.SelectEventHandler);
            $( document ).on( 'click', '.delete', perf.DeleteEventHandler);
            $( document ).on( 'click', '.openView', perf.OpenEventHandler);
         }else{
            t.clear();
            t.rows.add(JSON.parse(e));
            t.draw();
         }
    };

    ShowAllD(e) {
        b.clear();
        b.rows.add(JSON.parse(e));
        b.draw();
    };

    AddBodegaEventHandler(){
        perf.id=$(this).find('td:eq(1)').html();
        perf.cantidad=$(this).find('td:eq(2)').html();
        perf.fecha= $(this).find('td:eq(3)').html();
        perf.tipo= $(this).find('td:eq(4)').html();
        //
        $('#cantidad').val(perf.cantidad);
        $('#fecha').val(perf.fecha);
        $('#tipo').val(perf.tipo);
        $(".close").click();
    };

    OpenEventHandler() {
        // limpia dt
        var t= $('#tInsumo').DataTable();
        t.clear();
        t.draw();
        //
        insumobodega.idBodega = $(this).parents("tr").find(".itemId").text();  //Class itemId = ID del objeto.
        insumobodega.ReadByBodega;
        $(".bs-insumo-modal-lg").modal('toggle');
        $("#nombrebodega").text($(this).parents("tr").find("td:eq(1)").text());        
    };

    UpdateEventHandler() {
        perf.id = $(this).parents("tr").find(".itemId").text() || $(this).find(".itemId").text();
        perf.Read;
    };

    ShowItemData(e) {
        // Limpia el controles
        this.ClearCtls();
        // carga objeto.
        var data = JSON.parse(e)[0];
        perf = new Monitoreo(data.id, data.cantidad, data.fecha, data.ubicacion, data.contacto, data.telefono, data.tipo);
        // Asigna objeto a controles
        $("#id").val(perf.id);
        $("#cantidad").val(perf.cantidad);
        $("#myModalLabel").html('<h1>' + perf.cantidad + '<h1>' );
        $("#fecha").val(perf.fecha);
        $("#ubicacion").val(perf.ubicacion);
        $("#contacto").val(perf.contacto);
        $("#telefono").val(perf.telefono);
        //fk 
        $('#tipo option[value=' + perf.tipo + ']').prop("selected", true);    
        $("#tipo").selectpicker("refresh");
        $(".bs-perf-modal-lg").modal('toggle');
    };

    SelectEventHandler() {
        // Limpia el controles
        perf.ClearCtls();
        // carga objeto.
        perf= new Monitoreo();
        perf.id = $(this).parents("tr").find(".itemId").text() || $(this).find(".itemId").text();
        perf.cantidad = $(this).parents("tr").find("td:eq(1)").text() || $(this).find("td:eq(1)").text();
        perf.fecha = $(this).parents("tr").find("td:eq(2)").text() || $(this).find("td:eq(2)").text();
        perf.tipo = $(this).parents("tr").find("td:eq(3)").text() || $(this).find("td:eq(3)").text();
        // Asigna objeto a controles
        $("#cantidad").val(perf.cantidad);
        $("#fecha").val(perf.fecha);
        $("#tipo").val(perf.tipo);
        // oculta el modal   
        $(".bs-perf-modal-lg").modal('toggle');
        if(perf.tipo=='Interna')
            $("#frmTotales").hide();
        else
            $("#frmTotales").show(); 
    };

    ShowListTipo(e) {
        // carga lista con datos.
        var data = JSON.parse(e);
        // Recorre arreglo.
        $.each(data, function (i, item) {
            $('#tipo').append(`
                <option value=${item.id}>${item.cantidad}</option>
            `);
        })
    };

    ShowList(e) {
        // carga lista con datos.
        var data = JSON.parse(e);
        // Recorre arreglo.
        $.each(data, function (i, item) {
                $('#selbodega').append(`
                    <option value=${item.id}>${item.cantidad}</option>
                `);
        })
    };

    DeleteEventHandler() {
        perf.id = $(this).parents("tr").find(".itemId").text();  //Class itemId = ID del objeto.
        // Mensaje de borrado:
        swal({
            title: 'Eliminar?',
            text: "Esta acción es irreversible!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'No, cancelar!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger'
        }).then((result) => {
            if (result.value) {
                perf.Delete;
            }
        })
    };

    setTable(buttons=true){
        $('#tmonitoreo').DataTable({
            responsive: true,
            info: false,
            pageLength: 10,
            "order": [[ 1, "asc" ]],
            "language": {
                "infoEmpty": "Sin Usuarios Registrados",
                "emptyTable": "Sin Usuarios Registrados",
                "search": "Buscar",
                "zeroRecords":    "No hay resultados",
                "lengthMenu":     "Mostar _MENU_ registros",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Ultima",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
            columns: [
                {
                    title: "id",
                    data: "id",
                    className: "itemId",                    
                    searchable: false
                },
                { title: "Nombre", data: "cantidad" },
                { title: "Descripción", data: "fecha" },
                { title: "Tipo", data: "tipo" },
                {
                    title: "Acción",
                    orderable: false,
                    searchable:false,
                    visible: buttons,
                    className: "buttons",
                    width: '5%',
                    mRender: function () {
                        return '<a class="delete" style="cursor: pointer;"> <i class="glyphicon glyphicon-trash"> </i> </a> | <a class="openView" style="cursor: pointer;"> <i class="glyphicon glyphicon-eye-open"> </i>  </a>' 
                    }
                }
            ]
        });
    }

    Init() {
        // validator.js
//         var validator = new FormValidator({ "events": ['blur', 'input', 'change'] }, document.forms["frmMonitoreo"]);
//         $('#frmMonitoreo').submit(function (e) {
//             e.preventDefault();
//             var validatorResult = validator.checkAll(this);
//             if (validatorResult.valid)
//                 perf.Save;
//             return false;
//         });
//         // on form "reset" event
//         document.forms["frmMonitoreo"].onreset = function (e) {
//             validator.reset();
//         }
        $('#reload').click(function () {
            location.reload();
        });
        $('#btnIniciar').click(function () {
            perf.readBilling;
        });
        //NProgress
        $(function()
        {
            $(document)
                .ajaxStart(NProgress.start)
                .ajaxStop(NProgress.done);
        });

        

    };
}

let perf = new Performance();