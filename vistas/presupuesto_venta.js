function mostrarListarPresupuestoVenta() {
    let contenido = dameContenido("paginas/movimientos/ventas/presupuesto/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaPresupuestoVenta();
    dameFechaActual("desde");
    dameFechaActual("hasta");
}

function mostrarNuevoPresupuestoVenta() {
    let contenido = dameContenido("paginas/movimientos/ventas/presupuesto/agregar.php");
    $("#contenido-principal").html(contenido);
    dameFechaActual("fecha_emision");
    dameFechaActual("fecha_vencimiento");

    let ultimo = ejecutarAjax("controladores/presupuesto_venta_cabecera.php","ultimo_registro=1");
    if (ultimo === "0") {
        $("#nro_presupuesto").val("0000001");
    } else {
        let json = JSON.parse(ultimo);
        let nro = parseInt(json['nro_presupuesto']);
        nro++;
        $("#nro_presupuesto").val(nro.toString().padStart(7, '0'));
    }

    cargarListaClientes("#cliente");
    cargarListaProductoCompra("#producto");
}

$(document).on("change", "#producto", function () {
    let selected = $("#producto option:selected");

    if (selected.val() === "0") {
        $("#cantidad").val("1");
        $("#precio").val("0");
    } else {
        $("#cantidad").val("1");
        let precio = selected.data("precio");
        $("#precio").val(quitarDecimalesConvertir(precio));
    }
});

function agregarProductoPresupuestoVenta() {
    if ($("#producto").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes seleccionar un producto");
        return;
    }

    if ($("#precio").val().trim().length === 0 || quitarDecimalesConvertir($("#precio").val()) <= 0) {
        mensaje_dialogo_info_ERROR("Debes ingresar un precio válido");
        return;
    }

    if ($("#cantidad").val().trim().length === 0 || quitarDecimalesConvertir($("#cantidad").val()) <= 0) {
        mensaje_dialogo_info_ERROR("Debes ingresar una cantidad válida");
        return;
    }

    let repetido = false;
    $("#datos_tb tr").each(function () {
        if ($(this).find("td:eq(0)").text() === $("#producto").val()) {
            repetido = true;
        }
    });

    if (repetido) {
        mensaje_dialogo_info_ERROR("El item ya ha sido agregado anteriormente");
        return;
    }

    const id = $("#producto").val();
    const nombre = $("#producto option:selected").text();
    const precio = quitarDecimalesConvertir($("#precio").val());
    const cantidad = quitarDecimalesConvertir($("#cantidad").val());
    const iva = parseInt($("#producto option:selected").data("iva"));

    const subtotal = precio * cantidad;
    let exentas = 0, iva5 = 0, iva10 = 0;

    if (iva === 0) exentas = subtotal;
    else if (iva === 5) iva5 = subtotal;
    else if (iva === 10) iva10 = subtotal;

    $("#datos_tb").append(`
        <tr>
            <td>${id}</td>
            <td>${nombre}</td>
            <td>${cantidad}</td>
            <td>${formatearNumero(precio)}</td>
            <td>${formatearNumero(exentas)}</td>
            <td>${formatearNumero(iva5)}</td>
            <td>${formatearNumero(iva10)}</td>
            <td><button class="btn btn-danger rem-item">Remover</button></td>
        </tr>
    `);

    calcularTotalesPresupuestoVenta();
}

$(document).on("click", ".rem-item", function () {
    $(this).closest("tr").remove();
    calcularTotalesPresupuestoVenta();
});

function calcularTotalesPresupuestoVenta() {
    let total_exenta = 0;
    let total_iva5 = 0;
    let total_iva10 = 0;
    $("#datos_tb tr").each(function () {
        total_exenta += quitarDecimalesConvertir($(this).find("td:eq(4)").text());
        total_iva5 += quitarDecimalesConvertir($(this).find("td:eq(5)").text());
        total_iva10 += quitarDecimalesConvertir($(this).find("td:eq(6)").text());
    });
    $("#t_exenta").text(formatearNumero(total_exenta));
    $("#t_iva5").text(formatearNumero(total_iva5));
    $("#t_iva10").text(formatearNumero(total_iva10));

    $("#iva5").text(formatearNumero(Math.round(total_iva5 / 21)));
    $("#iva10").text(formatearNumero(Math.round(total_iva10 / 11)));
    $("#t_iva").text(formatearNumero(Math.round(total_iva10 / 11) + Math.round(total_iva5 / 21)));
}

function guardarPresupuestoVenta() {
    if ($("#cliente").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes seleccionar un cliente");
        return;
    }

    if ($("#datos_tb").html().trim().length === 0) {
        mensaje_dialogo_info_ERROR("No hay productos");
        return;
    }

    let cabecera = {
        'nro_presupuesto': $("#nro_presupuesto").val(),
        'fecha_emision': $("#fecha_emision").val(),
        'fecha_vencimiento': $("#fecha_vencimiento").val(),
        'id_cliente': $("#cliente").val(),
        'condicion': $("#condicion").val(),
        'estado': 'ACTIVO'
    };
    ejecutarAjax("controladores/presupuesto_venta_cabecera.php","guardar=" + JSON.stringify(cabecera));

    $("#datos_tb tr").each(function () {
        let detalle = {
            'id_producto': $(this).find("td:eq(0)").text(),
            'cantidad': $(this).find("td:eq(2)").text(),
            'precio': quitarDecimalesConvertir($(this).find("td:eq(3)").text())
        };
        ejecutarAjax("controladores/presupuesto_venta_detalle.php","guardar=" + JSON.stringify(detalle));
    });

    mensaje_dialogo_info("Guardado Correctamente");
    mostrarListarPresupuestoVenta();
}

function cargarTablaPresupuestoVenta() {
    let data = ejecutarAjax("controladores/presupuesto_venta_cabecera.php","leer=1");
    if (data !== "0") {
        let json = JSON.parse(data);
        $("#datos_tb").html("");
        json.map(function (item) {
            $("#datos_tb").append(`
                <tr>
                    <td>${item.id_presupuesto_venta}</td>
                    <td>${item.nro_presupuesto}</td>
                    <td>${item.fecha_emision}</td>
                    <td>${item.fecha_vencimiento}</td>
                    <td>${item.razon_social}</td>
                    <td>${item.condicion}</td>
                    <td>${formatearNumero(item.total)}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-primary imprimir-presupuesto-venta">Imprimir</button>
                        ${(item.estado === "ANULADO") ? `<button class='btn btn-success activar-presupuesto-venta'>Activar</button>` : `<button class='btn btn-danger anular-presupuesto-venta'>Anular</button>`}
                    </td>
                </tr>
            `);
        });
    }
}

$(document).on("click", ".anular-presupuesto-venta", function () {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    ejecutarAjax("controladores/presupuesto_venta_cabecera.php","anular=" + id);
    cargarTablaPresupuestoVenta();
    setTimeout(function(){alert("Presupuesto anulado");},500);
});

$(document).on("click", ".activar-presupuesto-venta", function () {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    ejecutarAjax("controladores/presupuesto_venta_cabecera.php","activar=" + id);
    cargarTablaPresupuestoVenta();
    setTimeout(function(){alert("Presupuesto Activado");},500);
});

$(document).on("click", ".imprimir-presupuesto-venta", function () {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    window.open("paginas/movimientos/ventas/presupuesto/imprimir.php?id="+id);
});
