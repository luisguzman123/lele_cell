//mostrar Lista
function mostrarListarPermiso() {
    let contenido = dameContenido("paginas/referenciales/permiso/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaPermiso();
}

//Mostrar Agregar
function mostrarAgregarPermiso() {
    let contenido = dameContenido("paginas/referenciales/permiso/agregar.php");
    $("#contenido-principal").html(contenido);
}

//Guardar
function guardarPermiso(){
    if($("#descripcion").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar una descripción", "ERROR");
        return;
    }

    let data = {
        'descripcion': $("#descripcion").val(),
        'estado': $("#estado").val()
    };

    if($("#id_permiso").val() === "0"){
        ejecutarAjax("controladores/permiso.php", "guardar="+JSON.stringify(data));
        mensaje_dialogo_info("Guardado correctamente");
    }else{
        data = {...data, "id_permiso": $("#id_permiso").val()};
        ejecutarAjax("controladores/permiso.php", "actualizar="+JSON.stringify(data));
        mensaje_dialogo_info("Actualizado Correctamente");
        $("#id_permiso").val("0");
    }
    mostrarListarPermiso();
}

$(document).on("click", ".eliminar-permiso", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/permiso.php",
        data: "eliminar="+id,
        success: function(){
            mensaje_dialogo_info("Eliminado");
            cargarTablaPermiso();
        }
    });
});

$(document).on("click", ".editar-permiso", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let contenido = dameContenido("paginas/referenciales/permiso/agregar.php");
    $("#contenido-principal").html(contenido);
    let data = ejecutarAjax("controladores/permiso.php", "leer_permiso_id="+id);
    let json_data = JSON.parse(data);
    $("#descripcion").val(json_data.descripcion);
    $("#estado").val(json_data.estado);
    $("#id_permiso").val(id);
});

function cargarTablaPermiso(){
    let data = ejecutarAjax("controladores/permiso.php", "leer_permiso=1");
    if(data === "0"){
        $("#permiso_tb").html("");
    }else{
        let json_data = JSON.parse(data);
        $("#permiso_tb").html("");
        json_data.map(function(item){
            $("#permiso_tb").append(`
                <tr>
                    <td>${item.id_permiso}</td>
                    <td>${item.descripcion}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-warning editar-permiso">Editar</button>
                        <button class="btn btn-danger eliminar-permiso">Eliminar</button>
                    </td>
                </tr>
            `);
        });
    }
}

