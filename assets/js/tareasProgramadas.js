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

    cargarByProyecto() {
        $.ajax({
            type: "POST",
            url: "class/tareasProgramadas.php",
            data: {
                action: "cargarByProyecto",
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
                data: "min",
                render: function (data, type, row) {
                    if (data == "t") {
                        return "Todos";
                    } else {

                        return data;
                    }
                }
            },
            {
                title: "Hora",
                data: "hour",
                render: function (data, type, row) {
                    if (data == "t") {
                        return "Todas";
                    } else {

                        return data;
                    }
                }
            },
            {
                title: "DOM",
                data: "dom",
                render: function (data, type, row) {
                    if (data == "t") {
                        return "Todos";
                    } else {

                        return data;
                    }
                }
            },
            {
                title: "Año",
                data: "year",
                render: function (data, type, row) {
                    if (data == "t") {
                        return "Todos";
                    } else {

                        return data;
                    }
                }
            },
            {
                //0 Domingo, 1 Lunes... 6 Sabado
                title: "DOW",
                data: "dow",
                render: function (data, type, row) {
                    // if (data == "t") {
                    //     return "Todos";
                    // } else {

                    //     return data;
                    // }

                    switch (data) {
                        case "t":
                            return "Todos";
                            break;
                        case "0":
                            return "Domingo"
                            break;
                        case "1":
                            return "Lunes";
                            break;
                        case "2":
                            return "Martes";
                            break;
                        case "3":
                            return "Miercoles";
                            break;
                        case "4":
                            return "Jueves";
                            break;
                        case "5":
                            return "Viernes";
                            break;
                        case "6":
                            return "Sabado";
                            break;
                        default:
                            return "No definido";
                    }
                }
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
            {
                title: "Eliminar",
                "mRender": function (data, type, full) {
                    return '<button type="button" class="btn btn-danger buttons deleteTask" style="width: 100%;"> <i class="fa fa-trash-o" style="font-size:20px;color:black;"></i> </button></center>';
                }
            }
            ]


        });
    };

    loadTaskbyID() {
        $.ajax({
            type: "POST",
            url: "class/tareasProgramadas.php",
            data: {
                action: "loadTaskbyID",
                obj: JSON.stringify(tareasProgramadas)
            }
        })
            .done(function (e) {
                tareasProgramadas.openTask(e);
            })
            .fail(function (e) {
                tareasProgramadas.showError(e);
            });
    };

    openTask(e) {
        var task = JSON.parse(e);

        tareasProgramadas.updateTask = true;
        tareasProgramadas.clearControls();

        $("#inp_titulo").val(task.title);
        $("#inp_descripcion").val(task.detail);

        if (task.hour == "t") {
            $("#chk_all_hora").prop("checked", true);
            $('#inp_hora').attr("disabled", true);
            $('#inp_hora').append($('<option>', {
                value: "t",
                text: 'Todas'
            }));
            $("#inp_hora").val("t");
        }
        else {
            $("#inp_hora option[value='t']").remove();
            $('#inp_hora').attr("disabled", false);
            $("#inp_hora").val(task.hour);
        }

        if (task.min == "t") {
            $("#chk_all_min").prop("checked", true);
            $('#inp_min').attr("disabled", true);
            $('#inp_min').append($('<option>', {
                value: "t",
                text: 'Todos'
            }));
            $("#inp_min").val("t");
        }
        else {
            $("#inp_min option[value='t']").remove();
            $('#inp_min').attr("disabled", false);
            $("#inp_min").val(task.min);
        }

        if (task.dom == "t") {
            $("#chk_all_dom").prop("checked", true);
            $('#inp_dom').attr("disabled", true);
            $('#inp_dom').append($('<option>', {
                value: "t",
                text: 'Todos'
            }));
            $("#inp_dom").val("t");
        }
        else {
            $("#inp_dom option[value='t']").remove();
            $('#inp_dom').attr("disabled", false);
            $("#inp_dom").val(task.dom);
        }

        if (task.dow == "t") {
            $("#chk_all_dow").prop("checked", true);
            $('#inp_dow').attr("disabled", true);
            $('#inp_dow').append($('<option>', {
                value: "t",
                text: 'Todos'
            }));
            $("#inp_dow").val("t");
        }
        else {
            $("#inp_dow option[value='t']").remove();
            $('#inp_dow').attr("disabled", false);
            $("#inp_dow").val(task.dow);
        }

        if (task.year == "t") {
            $("#chk_all_year").prop("checked", true);
            $('#inp_year').attr("disabled", true);
            $('#inp_year').append($('<option>', {
                value: "t",
                text: 'Todos'
            }));
            $("#inp_year").val("t");
        }
        else {
            $("#inp_year option[value='t']").remove();
            $('#inp_year').attr("disabled", false);
            $("#inp_year").val(task.year);
        }

        if (task.sub_task != 0) {
            $.each(task.sub_task, function (index, value) {
                if (index == 0) {
                    $(".inp_subtask").val(value.title);
                    $(".inp_subtask").attr("id", value.id);
                }
                else {

                    $("#frm_agrega_subtask").before(`
                        <form class="form-row form-inline form_subtareas">
                            <div class="input-group col-10" style="margin-bottom: 5px;">
                                <div class="input-group-prepend">
                                    <div class="input-group-text count_input_subTask">${ ($(".inp_subtask").length) + 1}</div>
                                </div>
                                <input type="text" class="form-control inp_subtask"
                                    placeholder="Detalle de Sub Tarea" id="${value.id}" value="${value.title}">
                                <div class="input-group-append" onclick="tareasProgramadas.deleteSubTask(this)">
                                    <span class="input-group-text"><i class="fa fa-trash-o" style="font-size:20px;color:crimson;"></i></span>
                                </div>
                            </div>
                            <div class="form-check col-2">
                                <label class="form-check-label">
                                    Por enviar
                                </label>
                            </div>
                            <br>
                        </form>
                    `);
                }
            });
        }

        if (task.file != 0) {
            tareasProgramadas.loadFiles(task.file);
        }


        $('#modal_new_task').modal('show');
    };

    loadFiles(files) {

        $.each(files, function (index, file) {

            var item = $('#img_preview').children().length + 1;
            var image = new Image();
            image.src = `data:image/png;base64,${file.image_file_base64}`;
            image.height = "75";
            image.id = `preview_${item}`;
            image.title = file.name;
            image.style = "margin:2%;";
            $('#img_preview').append(image);
            $('#img_preview').append(`<label>${file.name}</label> <br> `);

        })
    };

    deleteTask() {
        $.ajax({
            type: "POST",
            url: "class/tareasProgramadas.php",
            data: {
                action: "deleteTask",
                obj: JSON.stringify(tareasProgramadas)
            }
        })
            .done(function (e) {
                tareasProgramadas.cargar_todas();
                alert("Listo Tarea Borrada");

            })
            .fail(function (e) {
                tareasProgramadas.showError(e);
            });
    };

    deleteSubTask(del_SubTask) {
        if ($(".count_input_subTask").length > 1) {
            $(del_SubTask.parentElement.parentElement).remove();
        }
        else {
            del_SubTask.previousElementSibling.form[0].value = "";
        }
        $('.count_input_subTask').each(function (i, subTask) {
            subTask.textContent = i + 1;
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
                tareasProgramadas.cargar_todas();
                alert("ok");
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

    update() {
        $.ajax({
            type: "POST",
            url: "class/tareasProgramadas.php",
            data: {
                action: "update",
                obj: JSON.stringify(tareasProgramadas)
            }
        })
            .done(function (e) {
                tareasProgramadas.cargar_todas();
                alert("Actualizada");
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

    clearControls() {
        $("#inp_titulo").val("");
        $("#inp_descripcion").val("");
        $("#btn_file_load").val("");
        $("#img_preview").empty();
        $(".form_subtareas").remove();
        $(".inp_subtask").val("");
        $(".chkbox").prop('checked', false);
        $(".inp_sel option[value='t']").remove();
        $(".inp_sel").val($(".inp_sel option:first").val());
        $('.inp_sel').attr("disabled", false);
        $('#accordion .collapse').attr("data-parent", "#accordion").collapse('hide');
        if ($(".form_first_subTask").length < 1) {
            $("#frm_agrega_subtask").before(`
                <form class="form-row form-inline form_first_subTask">
                    <div class="input-group col-10" style="margin-bottom: 5px;">
                        <div class="input-group-prepend">
                            <div class="input-group-text count_input_subTask" value=1>1</div>
                        </div>
                        <input type="text" class="form-control inp_subtask first_inp_subtask"
                            placeholder="Detalle de subtarea">
                        <div class="input-group-append" onclick="tareasProgramadas.deleteSubTask(this)">
                            <span class="input-group-text"><i class="fa fa-trash-o"
                                    style="font-size:20px;color:crimson;"></i> </span>
                        </div>
                    </div>
                    <div class="form-check col-2">
                        <label class="form-check-label">
                            Por enviar
                        </label>
                    </div>
                    <br>
                </form>
            `);
        }
    }

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
var updateTask = false;