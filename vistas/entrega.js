function mostrarListarEntrega() {
    let contenido = dameContenido("paginas/movimientos/servicios/entrega/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaEntrega();
}

function mostrarAgregarEntrega() {
    let contenido = dameContenido("paginas/movimientos/servicios/entrega/agregar.php");
    $("#contenido-principal").html(contenido);
    dameFechaActual("fecha_entrega");
    cargarListaServicios("#servicio_lst");
}

function cargarListaServicios(componente) {
    let datos = ejecutarAjax("controladores/servicio_entrega.php", "leer_servicio=1");
    let option = "";
    if (datos === "0") {
        option = "<option value='0'>Sin servicios</option>";
    } else {
        option = "<option value='0'>-- Seleccione un servicio --</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function(item){
            option += `<option value="${item.id_servicio}" data-monto="${item.total_general}">${item.id_servicio} - ${item.cliente}</option>`;
        });
    }
    $(componente).html(option);
}

$(document).on("change", "#servicio_lst", function(){
    let monto = $(this).find("option:selected").data("monto") || 0;
    $("#monto_servicio").val(formatearNumero(monto));
});

function guardarEntrega() {
    if($("#servicio_lst").val() === "0"){
        mensaje_dialogo_info_ERROR("Debes seleccionar un servicio", "ATENCION");
        return;
    }
    let data = {
        id_servicio: $("#servicio_lst").val(),
        fecha_entrega: $("#fecha_entrega").val(),
        id_usuario: $("#id_usuario").val(),
        monto_servicio: quitarDecimalesConvertir($("#monto_servicio").val())
    };
    ejecutarAjax("controladores/servicio_entrega.php", "guardar=" + JSON.stringify(data));
    mensaje_dialogo_info("Guardado Correctamente", "Exitoso");
    mostrarListarEntrega();
}

function cargarTablaEntrega() {
    let datos = ejecutarAjax("controladores/servicio_entrega.php", "leer=1");
    let fila = "";
    if (datos === "0") {
        fila = "NO HAY REGISTROS";
    } else {
        let json_datos = JSON.parse(datos);
        json_datos.map(function(item){
            fila += `<tr>`;
            fila += `<td>${item.id_entrega}</td>`;
            fila += `<td>${item.id_servicio} - ${item.cliente}</td>`;
            fila += `<td>${formatearNumero(item.monto_servicio)}</td>`;
            fila += `<td>${item.fecha_entrega}</td>`;
            fila += `<td>${item.usuario || ''}</td>`;
            fila += `<td><button class='btn btn-danger anular-entrega'>Anular</button> <button class='btn btn-primary imprimir-entrega'>Imprimir</button></td>`;
            fila += `</tr>`;
        });
    }
    $("#entrega_tb").html(fila);
}

$(document).on("click", ".anular-entrega", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    Swal.fire({
        title: 'Estas seguro?',
        text: "Desea anular esta registro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            ejecutarAjax("controladores/servicio_entrega.php", "anular=" + id);
            mensaje_dialogo_info("Anulado correctamente", "ANULADO");
            cargarTablaEntrega();
        }
    });
});

$(document).on("click", ".imprimir-entrega", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    window.open("paginas/movimientos/servicios/entrega/imprimir.php?id=" + id);
});
