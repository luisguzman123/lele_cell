function mostrarAperturaCierre() {
    let contenido = dameContenido("paginas/movimientos/ventas/apertura_cierre/agregar.php");
    $("#contenido-principal").html(contenido);
    calcularTotalGeneralCaja();
}

$(document).on("input", "#efectivo, #tarjeta, #transferencia, #monto_apertura", function () {
    calcularTotalGeneralCaja();
});

function calcularTotalGeneralCaja() {
    let efectivo = quitarDecimalesConvertir($("#efectivo").val());
    let tarjeta = quitarDecimalesConvertir($("#tarjeta").val());
    let transferencia = quitarDecimalesConvertir($("#transferencia").val());
    let apertura = quitarDecimalesConvertir($("#monto_apertura").val());
    let total = efectivo + tarjeta + transferencia + apertura;
    $("#total_general").val(formatearNumero(total));
}

function abrirCaja() {
    let data = "accion=abrir&caja=" + $("#caja").val() +
        "&monto_apertura=" + quitarDecimalesConvertir($("#monto_apertura").val()) +
        "&efectivo=" + quitarDecimalesConvertir($("#efectivo").val()) +
        "&tarjeta=" + quitarDecimalesConvertir($("#tarjeta").val()) +
        "&transferencia=" + quitarDecimalesConvertir($("#transferencia").val());
    let res = ejecutarAjax("controladores/caja.php", data);
    mensaje_dialogo_info(res, "CORRECTO");
}

function cerrarCaja() {
    let data = "accion=cerrar&caja=" + $("#caja").val() +
        "&efectivo=" + quitarDecimalesConvertir($("#efectivo").val()) +
        "&tarjeta=" + quitarDecimalesConvertir($("#tarjeta").val()) +
        "&transferencia=" + quitarDecimalesConvertir($("#transferencia").val()) +
        "&monto_apertura=" + quitarDecimalesConvertir($("#monto_apertura").val());
    let res = ejecutarAjax("controladores/caja.php", data);
    mensaje_dialogo_info(res, "CORRECTO");
}

function generarArqueoCaja() {
    let data = "accion=arqueo&caja=" + $("#caja").val();
    let res = ejecutarAjax("controladores/caja.php", data);
    mensaje_dialogo_info(res, "CORRECTO");
}
