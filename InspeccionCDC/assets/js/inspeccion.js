class Inspeccion {
    // Constructor
    constructor(id, dataInspeccion, dataEntregaTurno, tablaInspeccion, idComponente, arrayInspeccion, fechaInicial, fechaFinal) {
        this.id = id || null;        
        this.dataInspeccion = dataInspeccion || '';
        this.dataEntregaTurno = dataEntregaTurno || '';
        this.tablaInspeccion = tablaInspeccion || [];
        this.idComponente = idComponente || '';
        this.arrayInspeccion = arrayInspeccion || [];
        this.fechaInicial = fechaInicial || "";
        this.fechaFinal = fechaFinal || "";
    }

    //Getter
    get ReadInspeccion() {
        var miAccion = this.id == null ? 'ReadAll' : 'Read';
        if(miAccion=='ReadAll' && $('#tableBody-Inspeccion').length==0 )
            return;
        $.ajax({
            type: "POST",
            url: "class/Inspeccion.php",
            data: {
                action: miAccion,
                id: this.id
            }
        })
            .done(function (e) {
                inspeccion.setTableInspeccion(e);
            })
            .fail(function (e) {
                inspeccion.showError(e);
            });
    }

    get ReadEntregaTurno() {
        var miAccion = 'ReadEntregaTurno';
        // if(miAccion=='ReadAll' && $('#tableBody-EntregaTurno').length==0 )
            // return;
        $.ajax({
            type: "POST",
            url: "class/Inspeccion.php",
            data: {
                action: miAccion,
                id: this.id
            }
        })
            .done(function (e) {
                inspeccion.setTableEntregaTurno(e);
            })
            .fail(function (e) {
                inspeccion.showError(e);
            });
    }

    ReadHistorial() {
        var referenciaCircular = inspeccion.tablaInspeccion;
        inspeccion.tablaInspeccion = [];
        $.ajax({
            type: "POST",
            url: "class/Inspeccion.php",
            data: {
                action: "ReadAllbyRange",
                obj: JSON.stringify(inspeccion)
            }
        })
            .done(function (e) {
                inspeccion.tablaInspeccion = referenciaCircular;        
                inspeccion.setTableHistorialInspeccion(e); 
            });
    };

    get Save() {
        $('#btnProducto').attr("disabled", "disabled");
        var miAccion = this.id == null ? 'Create' : 'Update';

        var z = this.tablaInspeccion;
        this.tablaInspeccion = [];

        $.ajax({
            type: "POST",
            url: "class/Inspeccion.php",
            data: {
                action: miAccion,
                obj: JSON.stringify(this)
            }
        })
            .done(function (e) {
                this.tablaInspeccion = z;
                swal({
                    type: 'success',
                    title: 'Inspección Guardada!',
                    showConfirmButton: true,
                    timer: 2000
                }).then((result) => {
                    inspeccion.arrayInspeccion = [];
                    window.location.href = "/MonitoreoDC/entregaTurno.html";
                });
            })
            .fail(function (e) {
                inspeccion.showError(e);
            })
            .always(function () {
            });
    }

    setTableInspeccion(e){
        inspeccion.dataInspeccion = JSON.parse(e);        
        this.tablaInspeccion = $('#tblInspeccion').DataTable( {
            data: inspeccion.dataInspeccion,
            responsive: true,
            destroy: true,
            // order: [[ 1, "asc" ]],
            // dom: 'Bfrtip',
            paging: false,
            // buttons: [
            //     {
            //         extend: 'excelHtml5',
            //         exportOptions: {columns: [ 1, 2 ]},                    
            //         messageTop:'Lista Rondas'
            //     },
            //     {
            //         extend: 'pdfHtml5',
            //         orientation : 'landscape',
            //         messageTop:'Lista Rondas',
            //         exportOptions: {
            //             columns: [ 1, 2 ]
            //         }
            //     }
            // ],
            language: {
                "infoEmpty": "Sin componentes",
                "emptyTable": "Sin componentes",
                "search": "Buscar",
                "zeroRecords":    "No hay resultados",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Ultima",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
            columns: [
                {
                    title:"ID",
                    data:"id",
                    className:"itemId",                    
                    width:"auto",
                    // searchable: false
                },
                {
                    title:"SECTOR",
                    data:"sector",
                    width:"22%"
                },
                {
                    title:"COMPONENTE",
                    data:"componente",
                    width:"auto"
                },
                {
                    title:"ESTADO",
                    data:"estado",
                    className: "oculto"
                },
                {
                    title:"ACCION",
                    orderable: false,
                    searchable:false,
                    class: "buttons",
                    width:"13%",
                    render: function ( data, type, row, meta ) {
                        if(row['estado']==1)
                            return '<input type="checkbox" id="toggleReporte'+row['id']+'" class="toggleReporte" data-on="✔" data-off="X" data-onstyle="success" data-offstyle="danger" checked/>'
                        else
                            return '<input type="checkbox" id="toggleReporte'+row['id']+'" class="toggleReporte" data-on="✔" data-off="X" data-onstyle="success" data-offstyle="danger"/>'

                    }
                },
                {
                    title:"DETALLE",
                    data: "detalle",
                    orderable: false,
                    searchable:false,
                    className: "oculto",
                    mRender: function ( data, type, row, meta ) {
                        if (row['estado']==0) 
                            return '<input type="text" id="txtReporte'+row['id']+'" value="'+data+'"/>';
                        else
                            return '<input type="text" id="txtReporte'+row['id']+'" value=""/>';
                    }
                }
            ],
            rowCallback: function (row) {
                $('input.toggleReporte', row).bootstrapToggle({size: 'small', width: '120'});
            }
        });
    };

    setTableEntregaTurno(e){
        inspeccion.dataEntregaTurno = JSON.parse(e);        
        this.tablaInspeccion = $('#tblEntregaTurno').DataTable( {
            data: inspeccion.dataEntregaTurno,
            responsive: true,
            destroy: true,
            // order: [[ 1, "asc" ]],
            // dom: 'Bfrtip',
            paging: false,
            // buttons: [
            //     {
            //         extend: 'excelHtml5',
            //         exportOptions: {columns: [ 1, 2 ]},                    
            //         messageTop:'Lista Rondas'
            //     },
            //     {
            //         extend: 'pdfHtml5',
            //         orientation : 'landscape',
            //         messageTop:'Lista Rondas',
            //         exportOptions: {
            //             columns: [ 1, 2 ]
            //         }
            //     }
            // ],
            language: {
                "infoEmpty": "Sin Alertas Reportadas",
                "emptyTable": "Sin Alertas Reportadas",
                "search": "Buscar",
                "zeroRecords":    "No hay resultados",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Ultima",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
            columns: [
                {
                    title:"ID",
                    data:"id",
                    className:"itemId",                    
                    width:"auto",
                    searchable: false
                },
                {
                    title:"FECHA REPORTE",
                    data:"fecha",
                    width:"auto"
                },
                {
                    title:"USUARIO REPORTA",
                    data:"userReport",
                    width:"auto"
                },
                {
                    title:"SECTOR",
                    data:"idSector",
                    className: "oculto"
                },
                {
                    title:"SECTOR",
                    data:"sector",
                    width:"auto"
                },
                {
                    title:"COMPONENTE",
                    data:"componente",
                    width:"auto"
                },
                {
                    title:"DETALLE",
                    data: "detalle",
                    width: "auto"
                }
            ]
        });
    };

    setTableHistorialInspeccion(e){
        inspeccion.dataEntregaTurno = JSON.parse(e);        
        this.tablaInspeccion = $('#tblHistorialInspeccion').DataTable( {
            data: inspeccion.dataEntregaTurno,
            responsive: true,
            destroy: true,
            order: [[ 1, "asc" ]],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {columns: [ 1, 2, 3, 4, 5 ]},                    
                    messageTop:'Inspección'
                },
                {
                    extend: 'pdfHtml5',
                    orientation : 'landscape',
                    messageTop:'Inspección',
                    exportOptions: {columns: [ 1, 2, 3, 4, 5 ]}
                }
            ],
            language: {
                "infoEmpty": "Sin Registros",
                "emptyTable": "Sin Registros",
                "search": "Buscar",
                "zeroRecords":    "No hay resultados",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Ultima",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
            columns: [
                {
                    title:"ID",
                    data:"id",
                    className:"itemId",                    
                    width:"auto",
                    searchable: false
                },
                {
                    title:"FECHA REPORTE",
                    data:"fecha",
                    width:"auto"
                },
                {
                    title:"USUARIO REPORTA",
                    data:"userReport",
                    width:"auto"
                },
                {
                    title:"SECTOR",
                    data:"idSector",
                    className: "oculto"
                },
                {
                    title:"SECTOR",
                    data:"sector",
                    width:"auto"
                },
                {
                    title:"COMPONENTE",
                    data:"componente",
                    width:"auto"
                },
                {
                    title:"DETALLE",
                    data: "detalle",
                    width: "auto"
                }
            ]
        });
    };
}

//Class Instance
let inspeccion = new Inspeccion();
var tp;