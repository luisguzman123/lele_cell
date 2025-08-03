//mostrar Lista
function mostrarListarProveedor() {
    let contenido = dameContenido("paginas/referenciales/proveedor/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaProveedor();
}

//Mostrar Agregar
function mostrarAgregarProveedor() {
    let contenido = dameContenido("paginas/referenciales/proveedor/agregar.php");
    $("#contenido-principal").html(contenido);
}

//Guardar
function guardarProveedor(){
    if($("#nombre_proveedor").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un nombre", "ERROR");
        return;
    }
    if($("#ruc").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un RUC", "ERROR");
        return;
    }
    if($("#telefono").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un teléfono", "ERROR");
        return;
    }

    let data = {
        'nombre_proveedor': $("#nombre_proveedor").val(),
        'ruc': $("#ruc").val(),
        'telefono': $("#telefono").val(),
        'estado': $("#estado").val()
    };

    if($("#id_proveedor").val() === "0"){
        ejecutarAjax("controladores/proveedor.php", "guardar="+JSON.stringify(data));
        mensaje_dialogo_info("Guardado correctamente");
    }else{
        data = {...data, "id_proveedor": $("#id_proveedor").val()};
        ejecutarAjax("controladores/proveedor.php", "actualizar="+JSON.stringify(data));
        mensaje_dialogo_info("Actualizado Correctamente");
        $("#id_proveedor").val("0");
    }
    mostrarListarProveedor();
}

$(document).on("click", ".eliminar-proveedor", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/proveedor.php",
        data: "eliminar="+id,
        success: function(){
            mensaje_dialogo_info("Eliminado");
            cargarTablaProveedor();
        }
    });
});

$(document).on("click", ".editar-proveedor", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let contenido = dameContenido("paginas/referenciales/proveedor/agregar.php");
    $("#contenido-principal").html(contenido);
    let data = ejecutarAjax("controladores/proveedor.php", "leer_proveedor_id="+id);
    let json_data = JSON.parse(data);
    $("#nombre_proveedor").val(json_data.nombre_proveedor);
    $("#ruc").val(json_data.ruc);
    $("#telefono").val(json_data.telefono);
    $("#estado").val(json_data.estado);
    $("#id_proveedor").val(id);
});

function cargarTablaProveedor(){
    let data = ejecutarAjax("controladores/proveedor.php", "leer_proveedor=1");
    if(data === "0"){
        $("#proveedor_tb").html("");
    }else{
        let json_data = JSON.parse(data);
        $("#proveedor_tb").html("");
        json_data.map(function(item){
            $("#proveedor_tb").append(`
                <tr>
                    <td>${item.id_proveedor}</td>
                    <td>${item.nombre_proveedor}</td>
                    <td>${item.ruc}</td>
                    <td>${item.telefono}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-warning editar-proveedor">Editar</button>
                        <button class="btn btn-danger eliminar-proveedor">Eliminar</button>
                    </td>
                </tr>
            `);
        });
    }
}
