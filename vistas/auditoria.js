function mostrarAuditoria(){
    let contenido = dameContenido("paginas/reportes/auditoria.php");
    $("#contenido-principal").html(contenido);
    cargarTablaAuditoria();
}

function cargarTablaAuditoria(){
    let data = ejecutarAjax("controladores/auditoria.php", "listar=1");
    if(data === "0"){
        if ($.fn.DataTable.isDataTable('#auditoria_tb')) {
            $('#auditoria_tb').DataTable().clear().draw();
        }
        return;
    }

    let json_data = JSON.parse(data);
    if ($.fn.DataTable.isDataTable('#auditoria_tb')) {
        let tabla = $('#auditoria_tb').DataTable();
        tabla.clear().rows.add(json_data).draw();
    } else {
        $('#auditoria_tb').DataTable({
            data: json_data,
            columns: [
                { data: 'id_auditoria' },
                { data: 'usuario' },
                { data: 'accion' },
                { data: 'tabla' },
                { data: 'id_registro' },
                { data: 'detalles' },
                { data: 'fecha' }
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Imprimir',
                    titleAttr: 'Imprimir'
                }
            ],
            language: {
                sSearch: "Buscar: ",
                sInfo: "Mostrando resultados del _START_ al _END_ de un total de _TOTAL_ registros",
                sInfoFiltered: "(filtrado de entre _MAX_ registros)",
                sZeroRecords: "No hay resultados",
                sInfoEmpty: "No hay resultados",
                oPaginate: {
                    sNext: "Siguiente",
                    sPrevious: "Anterior"
                }
            }
        });
    }
}
