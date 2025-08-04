function mostrarListarGarantia() {
    let contenido = dameContenido("paginas/movimientos/servicios/garantia/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaGarantia();
}

function mostrarAgregarGarantia() {
    let contenido = dameContenido("paginas/movimientos/servicios/garantia/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaServicio("#servicio_lst");
    dameFechaActual("fecha_inicio");
}

function cargarTablaGarantia() {
    let data = ejecutarAjax("controladores/servicio_garantia.php", "leer=1");
    $("#garantia_tb").html("");
    if (data === "0") {
        $("#garantia_tb").html("<tr><td colspan='6'>NO HAY REGISTRO</td></tr>");
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function (item) {
            $("#garantia_tb").append(`
                <tr>
                    <td>${item.id_garantia}</td>
                    <td>${item.id_servicio} - ${item.cliente}</td>
                    <td>${item.fecha_inicio}</td>
                    <td>${item.duracion_dias}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class='btn btn-danger anular-garantia'>Anular</button>
                        <button class='btn btn-primary imprimir-garantia'>Imprimir</button>
                    </td>
                </tr>
            `);
        });
    }
}

$(document).on("click", ".anular-garantia", function () {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    Swal.fire({
        title: '¿Anular garantía?',
        text: "Una vez anulada, no podrás revertir esta acción.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, anular',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            ejecutarAjax("controladores/servicio_garantia.php", "anular=" + id);
            cargarTablaGarantia();
            Swal.fire('¡Anulada!', 'La garantía ha sido anulada.', 'success');
        }
    });
});

$(document).on("click", ".imprimir-garantia", function () {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    imprimirGarantia(id);
});

function cargarListaServicio(componente) {
    let data = ejecutarAjax("controladores/servicio_garantia.php", "leer_servicio=1");
    if (data === "0") {
        $(componente).html("<option value='0'>Sin servicios</option>");
    } else {
        let json_data = JSON.parse(data);
        $(componente).html("<option value='0'>-- Seleccione un servicio --</option>");
        json_data.map(function (item) {
            $(componente).append(`<option value="${item.id_servicio}">${item.id_servicio} - ${item.cliente}</option>`);
        });
    }
}

function guardarGarantia() {
    if ($("#servicio_lst").val() === "0") {
        alert("Seleccione un servicio");
        return;
    }
    let cab = {
        id_servicio: $("#servicio_lst").val(),
        fecha_inicio: $("#fecha_inicio").val(),
        duracion_dias: $("#duracion").val(),
        estado: 'Vigente'
    };
    ejecutarAjax("controladores/servicio_garantia.php", "guardar=" + JSON.stringify(cab));
    mensaje_dialogo_info("Garantía registrada correctamente", "REGISTRADO");
    mostrarListarGarantia();
}

function imprimirGarantia(id) {
    window.open("paginas/movimientos/servicios/garantia/imprimir.php?id=" + id);
}
