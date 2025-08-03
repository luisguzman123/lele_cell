//mostrar Lista
function mostrarListarTecnico() {
    let contenido = dameContenido("paginas/referenciales/tecnico/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaTecnico();
}

//Mostrar Agregar
function mostrarAgregarTecnico() {
    let contenido = dameContenido("paginas/referenciales/tecnico/agregar.php");
    $("#contenido-principal").html(contenido);
}

//Guardar
function guardarTecnico(){
    if($("#nombre_tecnico").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un nombre", "ERROR");
        return;
    }
    if($("#cedula").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar una cédula", "ERROR");
        return;
    }
    if($("#telefono").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un teléfono", "ERROR");
        return;
    }

    let data = {
        'nombre_tecnico': $("#nombre_tecnico").val(),
        'cedula': $("#cedula").val(),
        'telefono': $("#telefono").val(),
        'estado': $("#estado").val()
    };

    if($("#id_tecnico").val() === "0"){
        ejecutarAjax("controladores/tecnico.php", "guardar="+JSON.stringify(data));
        mensaje_dialogo_info("Guardado correctamente");
    }else{
        data = {...data, "id_tecnico": $("#id_tecnico").val()};
        ejecutarAjax("controladores/tecnico.php", "actualizar="+JSON.stringify(data));
        mensaje_dialogo_info("Actualizado Correctamente");
        $("#id_tecnico").val("0");
    }
    mostrarListarTecnico();
}

$(document).on("click", ".eliminar-tecnico", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/tecnico.php",
        data: "eliminar="+id,
        success: function(){
            mensaje_dialogo_info("Eliminado");
            cargarTablaTecnico();
        }
    });
});

$(document).on("click", ".editar-tecnico", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let contenido = dameContenido("paginas/referenciales/tecnico/agregar.php");
    $("#contenido-principal").html(contenido);
    let data = ejecutarAjax("controladores/tecnico.php", "leer_tecnico_id="+id);
    let json_data = JSON.parse(data);
    $("#nombre_tecnico").val(json_data.nombre_tecnico);
    $("#cedula").val(json_data.cedula);
    $("#telefono").val(json_data.telefono);
    $("#estado").val(json_data.estado);
    $("#id_tecnico").val(id);
});

function cargarTablaTecnico(){
    let data = ejecutarAjax("controladores/tecnico.php", "leer_tecnico=1");
    if(data === "0"){
        $("#tecnico_tb").html("");
    }else{
        let json_data = JSON.parse(data);
        $("#tecnico_tb").html("");
        json_data.map(function(item){
            $("#tecnico_tb").append(`
                <tr>
                    <td>${item.id_tecnico}</td>
                    <td>${item.nombre_tecnico}</td>
                    <td>${item.cedula}</td>
                    <td>${item.telefono}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-warning editar-tecnico">Editar</button>
                        <button class="btn btn-danger eliminar-tecnico">Eliminar</button>
                    </td>
                </tr>
            `);
        });
    }
}

