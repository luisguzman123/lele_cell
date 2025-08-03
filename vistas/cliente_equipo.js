function mostrarListarClienteEquipo() {
    let contenido = dameContenido("paginas/referenciales/cliente_equipo/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaClienteEquipo();
}


function mostrarAgregarClienteEquipo() {
    let contenido = dameContenido("paginas/referenciales/cliente_equipo/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaCliente("#cliente_id");
    cargarListaEquipoCliente("#equipo_id");
}

//eliminar
$(document).on("click", ".eliminar-cliente_equipo", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    console.log(id);

    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/cliente_equipo.php",
        data: "eliminar=" + id,
        success: function (datos) {
            console.log(datos);
            mensaje_dialogo_info("Eliminado");
            cargarTablaClienteEquipo();
        }
    });
});
//editar
$(document).on("click", ".editar-cliente_equipo", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();

    let contenido = dameContenido("paginas/referenciales/cliente_equipo/agregar.php");
    $("#contenido-principal").html(contenido);

    let data = ejecutarAjax("controladores/cliente_equipo.php", "leer_cliente_equipo_id=" + id);


    let json_data = JSON.parse(data);

    cargarListaCliente("#cliente_id");
    cargarListaEquipo("#equipo_id");

    $("#cliente_id").val(json_data.id_cliente);
    $("#equipo_id").val(json_data.id_equipo);
    $("#tipo_bloqueo").val(json_data.tipo_pass);
    $("#clave_equipo").val(json_data.pass);
    $("#imei").val(json_data.imei);



    $("#id_cliente_equipo").val(id);

});

//
//function cargarListaProductos(componente){
//    let data  = ejecutarAjax("controladores/producto.php",
//    "leer=1");
//    
//    if(data === "0"){
//        $(componente).html("");
//    }else{
//        let json_data =  JSON.parse(data);
//        $(componente).html("<option value='0'>\n\
//Selecciona un Producto</option>");
//        json_data.map(function (item) {
//            $(componente).append(`
//<option value="${item.id_producto}-${item.iva}">${item.nombre} | Precio: ${formatearNumero(item.precio)}</option>`);
//        });
//    }
//}



///listas
function cargarListaCliente(componente) {
    let datos = ejecutarAjax("controladores/cliente_equipo.php", "leer_cliente=1");
    console.log(datos);
    // console.log("listar_ciudades_activas", datos);
    let option = "";
    if (datos === "0") {
        option = "<option value='0'>Selecciona una opción</option>";
    } else {
        option = "<option value='0'>Selecciona una opción</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function (item) {
            option += `<option value="${item.id_cliente}">${item.nombre} ${item.apellido} - ${item.cedula}</option>`;
        });
    }
    $(componente).html(option);

}
///listas
function cargarListaEquipoCliente(componente) {
    let datos = ejecutarAjax("controladores/cliente_equipo.php", "leer_equipo=1");
    console.log(datos);
    // console.log("listar_ciudades_activas", datos);
    let option = "";
    if (datos === "0") {
        option = "<option value='0'>Selecciona una opción</option>";
    } else {
        option = "<option value='0'>Selecciona una opción</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function (item) {
            option += `<option value="${item.id_equipo}">${item.marca} - ${item.modelo}</option>`;
        });
    }
    $(componente).html(option);

}

//GUARDAR
function guardarClienteEquipo() {
    if ($("#cliente_id").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes de seleccionar un cliente", "ERROR");
        return;
    }

    if ($("#equipo_id").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes de seleccionar un equipo", "ERROR");
        return;
    }
    if ($("#tipo_bloqueo").val().trim().length === 0) {
        mensaje_dialogo_info_ERROR("Debes de ingresar un tipo de bloqueo", "ERROR");
        return;
    }
    if ($("#clave_equipo").val().trim().length === 0) {
        mensaje_dialogo_info_ERROR("Debes de ingresar una clave de equipo", "ERROR");
        return;
    }
    if ($("#imei").val().trim().length === 0) {
        mensaje_dialogo_info_ERROR("Debes de ingresar un imei", "ERROR");
        return;
    }


    let data = {
        'id_cliente': $("#cliente_id").val(),
        'id_equipo': $("#equipo_id").val(),
        'imei': $("#imei").val(),
        'tipo_pass': $("#tipo_bloqueo").val(),
        'pass': $("#clave_equipo").val(),
        'estado': "ACTIVO"
    };
    console.log(data);

    if ($("#id_cliente_equipo").val() === "0") {

        let guardar = ejecutarAjax("controladores/cliente_equipo.php", "guardar=" + JSON.stringify(data));
        console.log(guardar);
        mensaje_dialogo_info("Guardado correctamente");
    } else {
        data = {...data, "id_cliente_equipo": $("#id_cliente_equipo").val()};
        res = ejecutarAjax("controladores/cliente_equipo.php",
                "actualizar=" + JSON.stringify(data));
        console.log(res);
        mensaje_dialogo_info("Actualizado Correctamente");
        $("#id_equipo").text("");
        $("#btn_guardar").text("Guardar");

    }

    mostrarListarClienteEquipo();
}

//mostrar 
function cargarTablaClienteEquipo() {
    let data = ejecutarAjax("controladores/cliente_equipo.php", "leer_equipo_cliente=1");
    console.log(data);
    if (data === "0") {

    } else {
        let json_data = JSON.parse(data);
        $("#cliente_equipo_tb").html("");
        json_data.map(function (item) {

            $("#cliente_equipo_tb").append(`
                        <tr>
                            <td>${item.id_cliente_equipo}</td>
                            <td>${item.nombre_cliente}</td>
                            <td>${item.modelo} - ${item.marca}</td>
                            <td>${item.tipo_pass}</td>
                            <td>${item.estado}</td>
                            <td>
                              <button class="btn btn-warning editar-cliente_equipo">Editar</button>
                              <button class="btn btn-danger eliminar-cliente_equipo">Eliminar</button>
                            </td>
                        </tr>
            `);
        });
    }
}
