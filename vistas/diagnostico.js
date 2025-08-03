function mostrarListarDiagnostico() {
    let contenido = dameContenido("paginas/movimientos/servicios/diagnostico/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaDiagnostico();
}

function mostrarAgregarDiagnostico() {
    let contenido = dameContenido("paginas/movimientos/servicios/diagnostico/agregar.php");
    $("#contenido-principal").html(contenido);
    dameFechaActual("fecha");
    cargarListaRecepcion("#recepcion_lst");
}

function cargarListaRecepcion(componente) {
    let datos = ejecutarAjax("controladores/diagnostico.php", "leer_recepcion=1");
    let option = "";
    if (datos === "0") {
        option = "<option value='0'>Selecciona una opción</option>";
    } else {
        option = "<option value='0'>Selecciona una opción</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function (item) {
            option += `<option value="${item.id_recepcion_cabecera}">${item.id_recepcion_cabecera} - ${item.cliente}</option>`;
        });
    }
    $(componente).html(option);
}

function agregarDetalleDiagnostico() {
    if ($("#descripcion_prueba").val().trim().length === 0) {
        mensaje_dialogo_info_ERROR("Debes de ingresar una descripción", "ATENCION");
        return;
    }
    if ($("#resultado").val().trim().length === 0) {
        $("#resultado").val("SIN RESULTADO");
    }
    if ($("#obs_detalle").val().trim().length === 0) {
        $("#obs_detalle").val("SIN OBS");
    }

    $("#detalle_diagnostico_tb").append(`
        <tr>
            <td>${$("#descripcion_prueba").val()}</td>
            <td>${$("#resultado").val()}</td>
            <td>${$("#obs_detalle").val()}</td>
            <td><button class="btn btn-danger remover-detalle">Remover</button></td>
        </tr>
    `);

    $("#descripcion_prueba").val("");
    $("#resultado").val("");
    $("#obs_detalle").val("");
}

$(document).on("click", ".remover-detalle", function (evt) {
    var tr = $(this).closest("tr");
    Swal.fire({
        title: "Atencion",
        text: "Desea remover el registro?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "No",
        confirmButtonText: "Si",
    }).then((result) => {
        if (result.isConfirmed) {
            $(tr).remove();
        }
    });
});

function guardarDiagnostico() {
    if ($("#detalle_diagnostico_tb").html().trim().length === 0) {
        mensaje_dialogo_info("Debes de agregar datos en la tabla", "Atención");
        return;
    }
    if ($("#recepcion_lst").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes seleccionar una recepción", "ATENCION");
        return;
    }
    let data = {
        'id_recepcion_cabecera': $("#recepcion_lst").val(),
        'fecha_diagnostico': $("#fecha").val(),
        'id_tecnico': $("#tecnico_lst").val(),
        'costo_estimado': 0,
        'estado_diagnostico': "PENDIENTE",
        'observaciones': $("#observaciones").val()
    };
    let response = ejecutarAjax("controladores/diagnostico.php", "guardar=" + JSON.stringify(data));
    let id = ejecutarAjax("controladores/diagnostico.php", "dameUltimoID=1");
    $("#detalle_diagnostico_tb tr").each(function () {
        let detalle = {
            'id_diagnostico': id,
            'descripcion_prueba': $(this).find("td:eq(0)").text(),
            'resultado': $(this).find("td:eq(1)").text(),
            'observaciones': $(this).find("td:eq(2)").text()
        };
        ejecutarAjax("controladores/diagnostico.php", "guardar_detalle=" + JSON.stringify(detalle));
    });
    mensaje_dialogo_info("Guardado Correctamente", "Exitoso");
    mostrarListarDiagnostico();
}

function cargarTablaDiagnostico() {
    let datos = ejecutarAjax("controladores/diagnostico.php", "leer_diagnostico=1");
    let fila = "";
    if (datos === "0") {
        fila = "NO HAY REGISTROS";
    } else {
        let json_datos = JSON.parse(datos);
        json_datos.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.id_diagnostico}</td>`;
            fila += `<td>${item.id_recepcion_cabecera}</td>`;
            fila += `<td>${item.fecha_diagnostico}</td>`;
            fila += `<td>${formatearNumero(item.costo_estimado)}</td>`;
            fila += `<td>${item.estado_diagnostico}</td>`;
            fila += `<td><button class="btn btn-danger anular-diagnostico">Anular</button> <button class="btn btn-primary imprimir-diagnostico">Impresion</button></td>`;
            fila += `</tr>`;
        });
    }
    $("#diagnostico_tb").html(fila);
}

$(document).on("click", ".anular-diagnostico", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let estado = $(this).closest("tr").find("td:eq(4)").text();
    if (estado.trim() === 'ANULADO') {
        mensaje_dialogo_info_ERROR("No puedes anular este registro", "ATENCION");
        return;
    }
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
            ejecutarAjax("controladores/diagnostico.php", "anular=" + id);
            mensaje_dialogo_info("Anulado correctamente", "ANULADO");
            cargarTablaDiagnostico();
        }
    });
});

$(document).on("click", ".imprimir-diagnostico", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    window.open("paginas/movimientos/servicios/diagnostico/imprimir.php?id=" + id);
});
