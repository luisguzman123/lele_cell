function mostrarAperturaCierre() {
    let contenido = dameContenido("paginas/movimientos/ventas/apertura_cierre/agregar.php");
    $("#contenido-principal").html(contenido);
    calcularTotalGeneralCaja();
    verificarEstadoCaja();
}

$(document).on("input", "#efectivo, #tarjeta, #transferencia, #monto_apertura", function () {
    calcularTotalGeneralCaja();
});

$(document).on("change", "#caja", function () {
    verificarEstadoCaja();
});

function calcularTotalGeneralCaja() {
    let efectivo = quitarDecimalesConvertir($("#efectivo").val());
    let tarjeta = quitarDecimalesConvertir($("#tarjeta").val());
    let transferencia = quitarDecimalesConvertir($("#transferencia").val());
    let apertura = quitarDecimalesConvertir($("#monto_apertura").val());
    let total = efectivo + tarjeta + transferencia + apertura;
    $("#total_general").val(formatearNumero(total));
}

function verificarEstadoCaja() {
    let datos = ejecutarAjax("controladores/caja.php", "accion=estado&caja=" + $("#caja").val());
    let info = {};
    try {
        info = JSON.parse(datos);
    } catch (e) {
        info = {};
    }

    if (info.accion === "ABRIR") {
        $("#monto_apertura").val(formatearNumero(info.monto_apertura));
        $("#efectivo").val(formatearNumero(info.efectivo));
        $("#tarjeta").val(formatearNumero(info.tarjeta));
        $("#transferencia").val(formatearNumero(info.transferencia));
        $("#total_general").val(formatearNumero(info.total));
        $("#abrir-btn").hide();
        $("#cerrar-btn").show();
    } else {
        $("#monto_apertura").val("0");
        $("#efectivo").val("0");
        $("#tarjeta").val("0");
        $("#transferencia").val("0");
        calcularTotalGeneralCaja();
        $("#abrir-btn").show();
        $("#cerrar-btn").hide();
    }
}

function abrirCaja() {
    let data = "accion=abrir&caja=" + $("#caja").val() +
        "&monto_apertura=" + quitarDecimalesConvertir($("#monto_apertura").val()) +
        "&efectivo=" + quitarDecimalesConvertir($("#efectivo").val()) +
        "&tarjeta=" + quitarDecimalesConvertir($("#tarjeta").val()) +
        "&transferencia=" + quitarDecimalesConvertir($("#transferencia").val());
    let res = ejecutarAjax("controladores/caja.php", data);
    mensaje_dialogo_info(res, "CORRECTO");
    verificarEstadoCaja();
}

function cerrarCaja() {
    let data = "accion=cerrar&caja=" + $("#caja").val() +
        "&efectivo=" + quitarDecimalesConvertir($("#efectivo").val()) +
        "&tarjeta=" + quitarDecimalesConvertir($("#tarjeta").val()) +
        "&transferencia=" + quitarDecimalesConvertir($("#transferencia").val()) +
        "&monto_apertura=" + quitarDecimalesConvertir($("#monto_apertura").val());
    let res = ejecutarAjax("controladores/caja.php", data);
    mensaje_dialogo_info(res, "CORRECTO");
    window.open("paginas/movimientos/ventas/apertura_cierre/imprimir.php?caja=" + $("#caja").val());
    verificarEstadoCaja();
}

function generarArqueoCaja() {
    let data = "accion=arqueo&caja=" + $("#caja").val();
    let res = ejecutarAjax("controladores/caja.php", data);
    mensaje_dialogo_info(res, "CORRECTO");
    window.open("paginas/movimientos/ventas/apertura_cierre/imprimir.php?caja=" + $("#caja").val());
}
