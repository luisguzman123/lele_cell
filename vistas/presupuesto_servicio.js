function mostrarListarPresupuestoServicio(){
    let contenido = dameContenido("paginas/movimientos/servicios/presupuesto/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaPresupuestoServicio();
}

function mostrarAgregarPresupuestoServicio(){
    let contenido = dameContenido("paginas/movimientos/servicios/presupuesto/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaDiagnostico("#diagnostico_lst");
    dameFechaActual("fecha");
}

function cargarTablaPresupuestoServicio(){
    let data = ejecutarAjax("controladores/presupuesto_servicio.php","leer=1");
    $("#presupuesto_servicio_tb").html("");
    if(data === "0"){
        $("#presupuesto_servicio_tb").html("<tr><td colspan='6'>NO HAY REGISTRO</td></tr>");
    }else{
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            $("#presupuesto_servicio_tb").append(`
                <tr>
                    <td>${item.id_presupuesto_servicio}</td>
                    <td>${item.id_diagnostico} - ${item.cliente}</td>
                    <td>${item.fecha_presupuesto}</td>
                    <td>
                        <select class="form-select form-select-sm estado-presupuesto-servicio">
                            <option value="Enviado">Enviado</option>
                            <option value="Aprobado">Aprobado</option>
                            <option value="Rechazado">Rechazado</option>
                        </select>
                    </td>
                    <td>${item.observaciones || ''}</td>
                    <td>
                        <button class='btn btn-danger anular-presupuesto-servicio'>Anular</button>
                        <button class='btn btn-primary imprimir-presupuesto-servicio'>Imprimir</button>
                    </td>
                </tr>
            `);
            $("#presupuesto_servicio_tb").find('tr:last .estado-presupuesto-servicio').val(item.estado);
        });
    }
}

$(document).on("click",".anular-presupuesto-servicio",function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    if(confirm("¿Anular presupuesto?")){
        ejecutarAjax("controladores/presupuesto_servicio.php","anular="+id);
        cargarTablaPresupuestoServicio();
    }
});

$(document).on("click", ".imprimir-presupuesto-servicio", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    imprimirPresupuestoServicio(id);
});

$(document).on("change", ".estado-presupuesto-servicio", function(){
    let fila = $(this).closest("tr");
    let id = fila.find("td:eq(0)").text();
    let estado = $(this).val();
    ejecutarAjax("controladores/presupuesto_servicio.php", "cambiar_estado="+id+"&estado="+estado);
});

function cargarListaDiagnostico(componente){
    let data = ejecutarAjax("controladores/diagnostico.php","leer_diagnostico_pendiente=1");
    if(data === "0"){
        $(componente).html("<option value='0'>Sin diagnósticos</option>");
    }else{
        let json_data = JSON.parse(data);
        $(componente).html("<option value='0'>-- Seleccione un diagnóstico --</option>");
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_diagnostico}">${item.id_diagnostico} - Fecha: ${item.fecha_diagnostico} - Cliente: ${item.cliente} </option>`);
        });
    }
}

function agregarDetallePresupuestoServicio(){
    if($("#concepto").val().trim().length === 0){
        alert("Ingrese concepto");
        return;
    }
    let cantidad = parseInt($("#cantidad").val()) || 0;
    let precio = parseInt($("#precio_unitario").val()) || 0;
    if(cantidad <= 0 || precio <= 0){
        alert("Cantidad y precio deben ser mayores a cero");
        return;
    }
    let subtotal = cantidad * precio;
    $("#detalle_presupuesto_servicio_tb").append(`
        <tr data-subtotal="${subtotal}">
            <td>${$("#concepto").val()}</td>
            <td>${cantidad}</td>
            <td>${formatearNumero(precio)}</td>
            <td>${formatearNumero(subtotal)}</td>
            <td><button class='btn btn-danger remover-item'>Remover</button></td>
        </tr>
    `);
    calcularTotalPresupuestoServicio();
    $("#concepto").val('');
    $("#cantidad").val(1);
    $("#precio_unitario").val(0);
}

$(document).on("click",".remover-item",function(){
    $(this).closest("tr").remove();
    calcularTotalPresupuestoServicio();
});

function calcularTotalPresupuestoServicio(){
    let total = 0;
    $("#detalle_presupuesto_servicio_tb tr").each(function(){
        total += parseInt($(this).data("subtotal")) || 0;
    });
    $("#total_presupuesto_servicio").text(formatearNumero(total));
}

function guardarPresupuestoServicio(){
    if($("#diagnostico_lst").val() === "0"){
        alert("Seleccione un diagnóstico");
        return;
    }
    if($("#detalle_presupuesto_servicio_tb tr").length === 0){
        alert("Agregue detalle");
        return;
    }
    let cab = {
        id_diagnostico: $("#diagnostico_lst").val(),
        fecha_presupuesto: $("#fecha").val(),
        validez_dias: $("#validez").val(),
        estado: 'Enviado',
        observaciones: $("#observaciones").val()
    };
    ejecutarAjax("controladores/presupuesto_servicio.php","guardar="+JSON.stringify(cab));
    let id = ejecutarAjax("controladores/presupuesto_servicio.php","dameUltimoId=1");
    $("#detalle_presupuesto_servicio_tb tr").each(function(){
        let det = {
            id_presupuesto_servicio: id,
            concepto: $(this).find("td:eq(0)").text(),
            cantidad: parseInt($(this).find("td:eq(1)").text()),
            precio_unitario: quitarDecimalesConvertir($(this).find("td:eq(2)").text())
        };
        ejecutarAjax("controladores/presupuesto_servicio.php","guardar_detalle="+JSON.stringify(det));
    });
    mensaje_dialogo_info("Diagnostico registrado correctamente", "REGISTRADO");
    mostrarListarPresupuestoServicio();
}

function imprimirPresupuestoServicio(id){
    window.open("paginas/movimientos/servicios/presupuesto/imprimir.php?id="+id);
}
