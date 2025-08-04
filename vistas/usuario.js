//mostrar Lista
function mostrarListarUsuario() {
    let contenido = dameContenido("paginas/referenciales/usuario/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaUsuario();
}

//Mostrar Agregar
function mostrarAgregarUsuario() {
    let contenido = dameContenido("paginas/referenciales/usuario/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaCargo("#cargo_id");
    cargarListaPermiso("#permiso_id");
}

//Guardar
function guardarUsuario(){
    if($("#usuario").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un usuario", "ERROR");
        return;
    }
    if($("#password").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar una contraseña", "ERROR");
        return;
    }
    if($("#cargo_id").val() === "0"){
        mensaje_dialogo_info_ERROR("Debes de seleccionar un cargo", "ERROR");
        return;
    }
    if($("#permiso_id").val() === "0"){
        mensaje_dialogo_info_ERROR("Debes de seleccionar un permiso", "ERROR");
        return;
    }

    let data = {
        'usuario': $("#usuario").val(),
        'password': $("#password").val(),
        'id_cargo': $("#cargo_id").val(),
        'id_permiso': $("#permiso_id").val()
    };

    if($("#id_usuario").val() === "0"){
        ejecutarAjax("controladores/usuario.php", "guardar="+JSON.stringify(data));
        mensaje_dialogo_info("Guardado correctamente");
    }else{
        data = {...data, "id_usuario": $("#id_usuario").val()};
        ejecutarAjax("controladores/usuario.php", "actualizar="+JSON.stringify(data));
        mensaje_dialogo_info("Actualizado Correctamente");
        $("#id_usuario").val("0");
    }
    mostrarListarUsuario();
}

$(document).on("click", ".eliminar-usuario", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/usuario.php",
        data: "eliminar="+id,
        success: function(){
            mensaje_dialogo_info("Eliminado");
            cargarTablaUsuario();
        }
    });
});

$(document).on("click", ".editar-usuario", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let contenido = dameContenido("paginas/referenciales/usuario/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaCargo("#cargo_id");
    cargarListaPermiso("#permiso_id");
    let data = ejecutarAjax("controladores/usuario.php", "leer_usuario_id="+id);
    let json_data = JSON.parse(data);
    $("#usuario").val(json_data.usuario);
    $("#cargo_id").val(json_data.id_cargo);
    $("#permiso_id").val(json_data.id_permiso);
    $("#id_usuario").val(id);
});

function cargarTablaUsuario(){
    let data = ejecutarAjax("controladores/usuario.php", "leer_usuario=1");
    if(data === "0"){
        $("#usuario_tb").html("");
    }else{
        let json_data = JSON.parse(data);
        $("#usuario_tb").html("");
        json_data.map(function(item){
            $("#usuario_tb").append(`
                <tr>
                    <td>${item.id_usuario}</td>
                    <td>${item.usuario}</td>
                    <td>${item.cargo}</td>
                    <td>${item.permiso}</td>
                    <td>
                        <button class="btn btn-warning editar-usuario">Editar</button>
                        <button class="btn btn-danger eliminar-usuario">Eliminar</button>
                    </td>
                </tr>
            `);
        });
    }
}

function cargarListaCargo(componente){
    let datos = ejecutarAjax("controladores/usuario.php", "leer_cargo=1");
    let option = "";
    if(datos === "0"){
        option = "<option value='0'>Selecciona una opción</option>";
    }else{
        option = "<option value='0'>Selecciona una opción</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function(item){
            option += `<option value="${item.id_cargo}">${item.descripcion}</option>`;
        });
    }
    $(componente).html(option);
}

function cargarListaPermiso(componente){
    let datos = ejecutarAjax("controladores/usuario.php", "leer_permiso=1");
    let option = "";
    if(datos === "0"){
        option = "<option value='0'>Selecciona una opción</option>";
    }else{
        option = "<option value='0'>Selecciona una opción</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function(item){
            option += `<option value="${item.id_permiso}">${item.descripcion}</option>`;
        });
    }
    $(componente).html(option);
}
