function mostrarListarRecepcion() {
    let contenido = dameContenido("paginas/movimientos/servicios/recepcion/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaRecepcion();
}

function mostrarAgregarRecepcion() {
    let contenido = dameContenido("paginas/movimientos/servicios/recepcion/agregar.php");
    $("#contenido-principal").html(contenido);
    dameFechaActual("fecha");
    cargarListaCliente("#cliente_lst");
}


function cargarListaCliente(componente){
    let datos = ejecutarAjax("controladores/recepcion.php", "leer_cliente=1");
    console.log(datos);
    // console.log("listar_ciudades_activas", datos);
    let option ="";
    if(datos === "0"){
        option = "<option value='0'>Selecciona una opción</option>";
    }else{
        option = "<option value='0'>Selecciona una opción</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function(item){
            option += `<option value="${item.id_cliente}">${item.nombre} ${item.apellido} - ${item.cedula}</option>`;
        });
    }
    $(componente).html(option);

}

$(document).on("change", "#cliente_lst", function (evt) {
    console.log($(this).val());
    cargarListaEquipo("#equipo_lst", $(this).val());
});


function cargarListaEquipo(componente, id){
    let datos = ejecutarAjax("controladores/recepcion.php", "leer_id_equipo="+ id);
    console.log(datos);
    // console.log("listar_ciudades_activas", datos);
    let option ="";
    if(datos === "0"){
        option = "<option value='0'>Selecciona una opción</option>";
    }else{
        option = "<option value='0'>Selecciona una opción</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function(item){
            option += `<option value="${item.id_equipo}">${item.marca} - ${item.modelo}</option>`;
        });
    }
    $(componente).html(option);

}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function agregarTablaDetalleProblema() {

    if ($("#problema_lst").val().trim().length === 0) {
        mensaje_dialogo_info_ERROR("Debes de ingresar un problema");
        return;
    }
    
    if ($("#obs").val().trim().length === 0) {
        $("#obs").val("SIN DESCRIPCION");
    }


    //agregar ''  `` ""
    $("#detalle_recepcion_tb").append(`
            <tr>
                <td>${$("#problema_lst").val()}</td>
                <td>${$("#obs").val()}</td>
                <td><button class="btn btn-danger remover-problema" style= "color: white;">Remover</button></td>
    
            </tr>
        `);


    $("#problema_lst").val("");
    $("#obs").val("");


}


$(document).on("click", ".remover-problema", function (evt) {
    var tr = $(this).closest("tr");
    Swal.fire({
        title: "Atencion",
        text: "Desea remover el registro?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "No",
        confirmButtonText: "Si"
    }).then((result) => {
        if (result.isConfirmed) {
            $(tr).remove();
        }
    });
});


function guardarRecepcion() {

    if ($("#detalle_recepcion_tb").html().trim().length === 0) {
        mensaje_dialogo_info("Debes de agregar datos en la tabla", "Atención");
        return;
    }

    if ($("#cliente_lst").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes seleccionar un cliente", "ATENCION");
        return;
    }
    if ($("#equipo_lst").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes seleccionar un equipo", "ATENCION");
        return;
    }


    //preparamos el JSON para enviar al controlador
    let data = {
        'fecha': $("#fecha").val(),
        'id_cliente': $("#cliente_lst").val(),
        'id_equipo': $("#equipo_lst").val(),
        'estado': "ACTIVO"
    };


    console.log(data);
    let response = ejecutarAjax("controladores/recepcion.php", "guardar=" + JSON.stringify(data));
    console.log(response);

let id = ejecutarAjax("controladores/recepcion.php", "dameUltimoID=1");
    $("#detalle_recepcion_tb tr").each(function (evt) {
        let detalle = {
            'id_recepcion_cabecera': id,
            'problema': $(this).find("td:eq(0)").text(),
            'obs': $(this).find("td:eq(1)").text(),
            'estado': "ACTIVO"

        };
        console.log(detalle);

        let respuesta = ejecutarAjax(
                "controladores/recepcion.php",
                "guardar_detalle=" + JSON.stringify(detalle));
        console.log(respuesta);

    });


    mensaje_dialogo_info("Guardado Correctamente", "Exitoso");
    mostrarListarRecepcion();

}


function cargarTablaRecepcion() {
    let datos = ejecutarAjax("controladores/recepcion.php", "leer_recepcion=1");
    console.log(datos);
    let fila = "";

    if (datos === "0") {
        fila = "NO HAY REGISTROS";
    } else {
        let json_datos = JSON.parse(datos);
        json_datos.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.id_recepcion_cabecera}</td>`;
            fila += `<td>${item.fecha}</td>`;
            fila += `<td>${item.nombre_apellido}</td>`;
            fila += `<td>${item.modelo} - ${item.marca}</td>`;
            fila += `<td>${item.estado}</td>`;
            
            // fila += `<td>${}</td>`;
            fila += `<td>
       
                              <button class="btn btn-danger anular-recepcion">Anular</button>
                              <button class="btn btn-primary imprimir-recepcion">Impresion</button>
                            </td>`;
        fila += `</tr>`;
        });
    }
    $("#recepcion_tb").html(fila);
}


$(document).on("click", ".anular-recepcion", function (evt) {
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
            //borrado fisico
            let response = ejecutarAjax("controladores/recepcion.php",
                    "anular=" + id);

//            console.log(response);
            mensaje_dialogo_info("Anulado correctamente", "ANULADO");
            cargarTablaRecepcion();
        }
    });
});


$(document).on("click", ".imprimir-recepcion", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();

    window.open("paginas/movimientos/servicios/recepcion/imprimir.php?id="+id);

});