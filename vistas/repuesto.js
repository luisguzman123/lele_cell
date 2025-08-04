//mostrar Lista
function mostrarListarRepuesto() {
    let contenido = dameContenido("paginas/referenciales/repuesto/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaRepuesto();
}

//Mostrar Agregar
function mostrarAgregarRepuesto() {
    let contenido = dameContenido("paginas/referenciales/repuesto/agregar.php");
    $("#contenido-principal").html(contenido);
}

//Guardar
function guardarRepuesto(){
    if($("#nombre_repuesto").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un nombre", "ERROR");
        return;
    }
    if($("#precio").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un precio", "ERROR");
        return;
    }

    let data = {
        'nombre_repuesto': $("#nombre_repuesto").val(),
        'precio': $("#precio").val(),
        'estado': $("#estado").val()
    };

    if($("#id_repuesto").val() === "0"){
        ejecutarAjax("controladores/repuesto.php", "guardar="+JSON.stringify(data));
        mensaje_dialogo_info("Guardado correctamente");
    }else{
        data = {...data, "id_repuesto": $("#id_repuesto").val()};
        ejecutarAjax("controladores/repuesto.php", "actualizar="+JSON.stringify(data));
        mensaje_dialogo_info("Actualizado Correctamente");
        $("#id_repuesto").val("0");
    }
    mostrarListarRepuesto();
}

$(document).on("click", ".eliminar-repuesto", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/repuesto.php",
        data: "eliminar="+id,
        success: function(){
            mensaje_dialogo_info("Eliminado");
            cargarTablaRepuesto();
        }
    });
});

$(document).on("click", ".editar-repuesto", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let contenido = dameContenido("paginas/referenciales/repuesto/agregar.php");
    $("#contenido-principal").html(contenido);
    let data = ejecutarAjax("controladores/repuesto.php", "leer_repuesto_id="+id);
    let json_data = JSON.parse(data);
    $("#nombre_repuesto").val(json_data.nombre_repuesto);
    $("#precio").val(json_data.precio);
    $("#estado").val(json_data.estado);
    $("#id_repuesto").val(id);
});

function cargarTablaRepuesto(){
    let data = ejecutarAjax("controladores/repuesto.php", "leer_repuesto=1");
    if(data === "0"){
        $("#repuesto_tb").html("");
    }else{
        let json_data = JSON.parse(data);
        $("#repuesto_tb").html("");
        json_data.map(function(item){
            $("#repuesto_tb").append(`
                <tr>
                    <td>${item.id_repuesto}</td>
                    <td>${item.nombre_repuesto}</td>
                    <td>${item.precio}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-warning editar-repuesto">Editar</button>
                        <button class="btn btn-danger eliminar-repuesto">Eliminar</button>
                    </td>
                </tr>
            `);
        });
    }
}

