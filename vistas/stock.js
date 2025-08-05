function mostrarListaStock() {
    let contenido = dameContenido("paginas/referenciales/stock/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaStock();
}
function cargarTablaStock() {
    let data = ejecutarAjax("controladores/producto.php", "leer_producto=1");
    let registros = [];

    if (data !== "0") {
        let json = JSON.parse(data);
        registros = json.map(item => [item.id_producto, item.nombre, item.stock]);
    }

    // Limpiar tabla
    const tbody = document.querySelector("#tabla_stock tbody");
    tbody.innerHTML = "";

    // Cargar filas
    registros.forEach((r, i) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${r[0]}</td>
            <td>${r[1]}</td>
            <td>${r[2]}</td>
        `;
        tbody.appendChild(tr);
    });
}

//function cargarTablaStock() {
//    let data = ejecutarAjax("controladores/producto.php", "leer_producto=1");
//    let registros = [];
//    if (data !== "0") {
//        let json = JSON.parse(data);
//        json.forEach(function(item){
//            registros.push([item.id_producto, item.nombre, item.stock]);
//        });
//    }
//    if ($.fn.DataTable.isDataTable('#tabla_stock')) {
//        $('#tabla_stock').DataTable().destroy();
//    }
//    $('#tabla_stock tbody').empty();
//    registros.forEach(function(r){
//        $('#tabla_stock tbody').append(`<tr><td>${r[0]}</td><td>${r[1]}</td><td>${r[2]}</td></tr>`);
//    });
//    $('#tabla_stock').DataTable({
//        dom: 'Bfrtip',
//        buttons: [
//            { extend: 'excelHtml5', text: 'Excel', className: 'btn btn-success' },
//            { extend: 'pdfHtml5', text: 'PDF', className: 'btn btn-danger' }
//        ],
//        language: {
//            search: 'Buscar:',
//            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
//            infoFiltered: '(filtrado de _MAX_ registros)',
//            zeroRecords: 'No hay resultados',
//            infoEmpty: 'No hay resultados',
//            paginate: { next: 'Siguiente', previous: 'Anterior' }
//        }
//    });
//}
