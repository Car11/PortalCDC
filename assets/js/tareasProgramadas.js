class TareasProgramadas {
    // Constructor
    constructor(id, user_id, min, hour, dom, year, dow, title, detail, file, files, sub_task, column_id, project_id) {
        this.id = id || null;
        this.user_id = user_id || new Array();
        this.min = min || null;
        this.hour = hour || null;
        this.dom = dom || null;
        this.year = year || null;
        this.dow = dow || null;
        this.title = title || null;
        this.detail = detail || null;
        this.file = file || null;
        this.files = files || null;
        this.sub_task = sub_task || null;
        this.project_id = project_id || null;
        this.column_id = column_id || null;
    };



    cargar_todas() {
        $.ajax({
            type: "POST",
            url: "class/tareasProgramadas.php",
            data: {
                action: "cargar_todas",
                obj: JSON.stringify(tareasProgramadas)
            }
        })
            .done(function (e) {
                if (e != "null") {
                    tareasProgramadas.drawAllTask(e)
                } else {
                    swal({
                        type: 'success',
                        title: 'Listo, no hay tareas que mostrar!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            })
            .fail(function (e) {
                tareasProgramadas.showError(e);
            });
    };

    drawAllTask(e) {
        var tareas = JSON.parse(e);

        tbl_tareas = $('#tbl_tareas').DataTable({
            data: tareas,
            destroy: true,
            "language": {
                "infoEmpty": "Sin Tareas Ingresadas",
                "emptyTable": "Sin Tareas Ingresadas",
                "search": "Buscar",
                "zeroRecords": "No hay resultados",
                "lengthMenu": "Mostar _MENU_ registros",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "order": [
                [0, "desc"]
            ],
            columns: [{
                title: "Consecutivo",
                data: "id"
            },
            {
                title: "Usuario",
                data: "user_id"
            },
            {
                title: "Min",
                data: "min"
            },
            {
                title: "Hora",
                data: "hour"
            },
            {
                title: "DOM",
                data: "dom"
            },
            {
                title: "Año",
                data: "year"
            },
            {
                title: "DOW",
                data: "dow"
            },
            {
                title: "Titulo",
                data: "title"
            },
            {
                title: "Detalle",
                data: "detail",
                render: function (data, type, row) {
                    if (data.length < 10) {
                        return data;
                    } else {

                        return data.substr(0, 60) + "...";
                    }
                }
            },
            // {
            //     title: "Archivos",
            //     data: "file",
            //     render: function (data, type, row) {
            //         if (data == 0) {
            //             return "NO";
            //         } else {

            //             return "SI";
            //         }
            //     }
            // },
            // {
            //     title: "SubTareas",
            //     data: "sub_task",
            //     render: function (data, type, row) {
            //         if (data == 0) {
            //             return "NO";
            //         } else {

            //             return "SI";
            //         }
            //     }
            // },
            {
                title: "Estado",
                "mRender": function(data, type, full) {
                    return '<button type="button" class="btn btn-primary" style="margin-left: 15%;margin-bottom: 10%;" href=#/' + full["id"] + '>  <i class="fa fa-pencil" style="font-size:20px;color:black;"></i> </button>'+
                            '<button type="button" class="btn btn-danger" style="margin-left: 15%;"href=#/' + full["id"] + '> <i class="fa fa-trash-o" style="font-size:20px;color:black;"></i> </button>';
                }
            }
            ]


        });
    };

    create() {
        $.ajax({
            type: "POST",
            url: "class/tareasProgramadas.php",
            data: {
                action: "create",
                obj: JSON.stringify(tareasProgramadas)
            }
        })
            .done(function (e) {
                alert ("ok");
                // swal({
                //     type: 'success',
                //     title: 'Listo, Tarea Guardada!',
                //     showConfirmButton: false,
                //     timer: 2000
                // });
            })
            .fail(function (e) {
                tareasProgramadas.showError(e);
            });
    };

    // Muestra información en ventana
    showInfo() {
        //$(".modal").css({ display: "none" });   
        $(".close").click();
        swal({

            type: 'success',
            title: 'Good!',
            showConfirmButton: false,
            timer: 750
        });
    };

    // Muestra errores en ventana
    showError(e) {
        //$(".modal").css({ display: "none" });  
        var data = JSON.parse(e.responseText);
        // session.in(data)
        // swal({
        //     type: 'error',
        //     title: 'Oops...',
        //     text: 'Algo no está bien (' + data.code + '): ' + data.msg,
        //     // // footer: '<a href>Contacte a Soporte Técnico</a>',
        // });
    };

}
//Class Instance
let tareasProgramadas = new TareasProgramadas();
var tbl_tareas = [];