function mostrarListarFactura() {
    let contenido = dameContenido("paginas/movimientos/ventas/facturacion/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaFacturas();
    dameFechaActual("desde");
    dameFechaActual("hasta");
}

function mostrarNuevaFactura() {
    let contenido = dameContenido("paginas/movimientos/ventas/facturacion/agregar.php");
    $("#contenido-principal").html(contenido);
    dameFechaActual("fecha");

    //para la siguiente factura
    let factura = ejecutarAjax("controladores/factura_cabecera.php",
            "ultimo_registro=1");

    if (factura === "0") {
        $("#nro_factura").val("001-001-0000001");
        $("#timbrado").val("123456");
    } else {
        let json_factura = JSON.parse(factura);
        let nro_sucursal = json_factura['nro_factura'].split("-")[0];
        let nro_expedicion = json_factura['nro_factura'].split("-")[1];
        let nro_factura = parseInt(
                json_factura['nro_factura'].split("-")[2]);
        nro_factura++;
        $("#nro_factura").val(nro_sucursal + "-" +
                nro_expedicion + "-" + nro_factura.toString().padStart(7, '0'));

        $("#timbrado").val(json_factura['timbrado']);

    }

    //carga de cliente
    cargarListaClientes("#cliente");
    //carga de productos
    cargarListaProductoCompra("#producto");

}

//----------------------------------------------------
//----------------------------------------------------
//----------------------------------------------------
$(document).on("change", "#condicion", function () {
    if ($(this).val() === "CREDITO") {
        let modal = new bootstrap.Modal(document.getElementById('modal-plan'));
        modal.show();
    }
});

//----------------------------------------------------
//----------------------------------------------------
//----------------------------------------------------
$(document).on("click", "#pp-confirmar", function () {
    guardarFactura();
});

//----------------------------------------------------
//----------------------------------------------------
//----------------------------------------------------
$(document).on("change", "#producto", function () {
    let selected = $("#producto option:selected");

    if (selected.val() === "0") {
        $("#cantidad").val("1");
        $("#precio").val("0");
    } else {
        $("#cantidad").val("1");
        let precio = selected.data("precio"); // ✅ obtenemos el precio desde el atributo data-precio
        $("#precio").val(quitarDecimalesConvertir(precio));
    }
});

//---------------------------------------------------------
//---------------------------------------------------------
//---------------------------------------------------------
$(document).on("click", "#pp-agregar", function () {
    if ($("#pp-fecha").val().trim().length === 0 || $("#pp-monto").val().trim().length === 0) {
        mensaje_dialogo_info_ERROR("Debes completar fecha y monto");
        return;
    }
    $("#pp-detalle").append(`
        <tr>
            <td>${$("#pp-detalle tr").length + 1}</td>
            <td>${$("#pp-fecha").val()}</td>
            <td>${formatearNumero($("#pp-monto").val())}</td>
            <td><button class="btn btn-danger rem-cuota">Remover</button></td>
        </tr>
    `);
    $("#pp-fecha").val("");
    $("#pp-monto").val("");
});

$(document).on("click", ".rem-cuota", function (evt) {
    $(this).closest("tr").remove();
    $("#pp-detalle tr").each(function (index) {
        $(this).find("td:eq(0)").text(index + 1);
    });
});

//---------------------------------------------------------
//---------------------------------------------------------
//---------------------------------------------------------
function agregarProductoFactura() {
    // validaciones
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

    // validación de item repetido
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

    // obtener datos
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

    calcularTotalesFactura();
}

//function agregarProductoFactura() {
//    //validaciones
//    if ($("#producto").val() === "0") {
//        mensaje_dialogo_info_ERROR("Debes seleccionar un producto");
//        return;
//    }
//
//    if ($("#precio").val().trim().length === 0) {
//        mensaje_dialogo_info_ERROR("Debes ingresar un precio");
//        return;
//    }
//    if (quitarDecimalesConvertir($("#precio").val()) <= 0) {
//        mensaje_dialogo_info_ERROR("Debes ingresar un precio mayor a cero");
//        return;
//    }
//
//    if ($("#cantidad").val().trim().length === 0) {
//        mensaje_dialogo_info_ERROR("Debes ingresar una cantidad");
//        return;
//    }
//    if (quitarDecimalesConvertir($("#cantidad").val()) <= 0) {
//        mensaje_dialogo_info_ERROR("Debes ingresar una cantidad mayor a cero");
//        return;
//    }
//    //validacion de item repetido
//    let repetido = false;
//
//    $("#datos_tb tr").each(function (evt) {
//        if ($(this).find("td:eq(0)").text() ===
//                $("#producto").val().split("-")[0]) {
//            repetido = true;
//        }
//    });
//
//    if (repetido) {
//        mensaje_dialogo_info_ERROR("El item ya ha sido agregado anteriormente");
//        return;
//    }
//
//
//    $("#datos_tb").append(`
//    <tr>
//        <td>${$("#producto").val().split("-")[0]}</td>
//        <td>${$("#producto option:selected").html().
//            split(" | ")[0]}</td>
//        <td>${$("#cantidad").val()}</td>
//        <td>${formatearNumero($("#precio").val())}</td>
//    
//        <td>${($("#producto").val().split("-")[1] === "0") ?
//            formatearNumero(quitarDecimalesConvertir(
//                    $("#cantidad").val()) *
//                    quitarDecimalesConvertir(
//                            $("#precio").val())) : "0" }</td>
//        
//        <td>${($("#producto").val().split("-")[1] === "5") ?
//            formatearNumero(quitarDecimalesConvertir(
//                    $("#cantidad").val()) *
//                    quitarDecimalesConvertir(
//                            $("#precio").val())) : "0" }</td>
//        
//        <td>${($("#producto").val().split("-")[1] === "10") ?
//            formatearNumero(quitarDecimalesConvertir(
//                    $("#cantidad").val()) *
//                    quitarDecimalesConvertir(
//                            $("#precio").val())) : "0" }</td>
//           
//           <td><button class="btn btn-danger rem-item">Remover</button></td>
//    </tr>
//`);
//    calcularTotalesFactura();
//
//}

function calcularTotalesFactura() {
    let total = 0;
    let total_exenta = 0;
    let total_iva5 = 0;
    let total_iva10 = 0;
    $("#datos_tb tr").each(function (evt) {
        total_exenta += quitarDecimalesConvertir(
                $(this).find("td:eq(4)").text());
        total_iva5 += quitarDecimalesConvertir(
                $(this).find("td:eq(5)").text());
        total_iva10 += quitarDecimalesConvertir(
                $(this).find("td:eq(6)").text());
    });
    $("#t_exenta").text(formatearNumero(total_exenta));
    $("#t_iva5").text(formatearNumero(total_iva5));
    $("#t_iva10").text(formatearNumero(total_iva10));

    $("#iva5").text(formatearNumero(Math.round(
            total_iva5 / 21)));

    $("#iva10").text(formatearNumero(Math.round(
            total_iva10 / 11)));

    $("#t_iva").text(formatearNumero(Math.round(
            total_iva10 / 11) +
            Math.round(total_iva5 / 21)));
}
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
$(document).on("click", ".rem-item", function (evt) {
    $(this).closest("tr").remove();
    calcularTotalesFactura();
});
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
function guardarFactura() {
    //validaciones
    if ($("#cliente").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes seleccionar un cliente");
        return;
    }

    if ($("#datos_tb").html().trim().length === 0) {
        mensaje_dialogo_info_ERROR("No hay productos para la venta");
        return;
    }
    if ($("#condicion").val() === "CREDITO" && $("#pp-detalle tr").length === 0) {
        mensaje_dialogo_info_ERROR("Debes configurar un plan de pago");
        return;
    }
    //JSON
    let cabecera = {
        'nro_factura': $("#nro_factura").val(),
        'fecha': $("#fecha").val(),
        'id_cliente': $("#cliente").val(),
        'condicion': $("#condicion").val(),
        'timbrado': $("#timbrado").val(),
        'estado': 'ACTIVO'
    };
    let res = ejecutarAjax("controladores/factura_cabecera.php",
            "guardar=" + JSON.stringify(cabecera));
    console.log(res);

    //detalle
    $("#datos_tb tr").each(function (evt) {
        let detalle = {
            "id_producto": $(this).find("td:eq(0)").text(),
            "cantidad": $(this).find("td:eq(2)").text(),
            "precio": quitarDecimalesConvertir($(this).find("td:eq(3)").text()),
        };
        res = ejecutarAjax("controladores/factura_detalle.php",
                "guardar=" + JSON.stringify(detalle));
        console.log(res);
    });

    if ($("#condicion").val() === "CREDITO") {
        let totalPlan = 0;
        $("#pp-detalle tr").each(function () {
            totalPlan += quitarDecimalesConvertir($(this).find("td:eq(2)").text());
        });
        let cabeceraPlan = {
            "total": totalPlan
        };
        res = ejecutarAjax("controladores/plan_pago.php",
                "guardar_cabecera=" + JSON.stringify(cabeceraPlan));

        $("#pp-detalle tr").each(function (index) {
            let cuota = {
                "nro_cuota": index + 1,
                "fecha_vencimiento": $(this).find("td:eq(1)").text(),
                "monto_cuota": quitarDecimalesConvertir($(this).find("td:eq(2)").text())
            };
            res = ejecutarAjax("controladores/plan_pago.php",
                    "guardar_detalle=" + JSON.stringify(cuota));
        });
    }

    mensaje_dialogo_info("Guardado Correctamente");

    mostrarListarFactura();

}
//-----------------------------------------------------------
//-----------------------------------------------------------
//-----------------------------------------------------------
function cargarTablaFacturas() {
    let data = ejecutarAjax("controladores/factura_cabecera.php",
            "leer=1");

    if (data === "0") {

    } else {
        let json_data = JSON.parse(data);
        $("#datos_tb").html("");
        json_data.map(function (item) {

            $("#datos_tb").append(`
                    <tr>
                        <td>${item.id_factura_cabecera}</td>
                        <td>${item.nro_factura}</td>
                        <td>${item.fecha}</td>
                        <td>${item.razon_social}</td>
                        <td>${item.condicion}</td>
                        <td>${formatearNumero(item.total)}</td>
                        <td>${item.estado}</td>
                        <td>
                            <button class="btn btn-primary imprimir-factura">Imprimir</button>
                             ${(item.estado === "ANULADO") ? 
                             `<button class="btn btn-success activar-factura">Activar</button>`: 
                             `<button class="btn btn-danger anular-factura">Anular</button>`}
                            
                        </td>
                    </tr>
                `);
        });
    }
}
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
$(document).on("click", ".anular-factura", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();

    let res = ejecutarAjax("controladores/factura_cabecera.php",
            "anular=" + id);
    cargarTablaFacturas();

    // 3) Esperas un ratito y luego muestras el alert
    setTimeout(function () {
        alert("Factura anulada");
    }, 500);

});
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
$(document).on("click", ".activar-factura", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();

    let res = ejecutarAjax("controladores/factura_cabecera.php",
            "activar=" + id);
    cargarTablaFacturas();

    // 3) Esperas un ratito y luego muestras el alert
    setTimeout(function () {
        alert("Factura Activada");
    }, 500);

});
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
$(document).on("click", ".imprimir-factura", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();

    window.open("imprimir.php?id="+id);

});