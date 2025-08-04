//mostrar Lista
function mostrarListarCargo() {
    let contenido = dameContenido("paginas/referenciales/cargo/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaCargo();
}

//Mostrar Agregar
function mostrarAgregarCargo() {
    let contenido = dameContenido("paginas/referenciales/cargo/agregar.php");
    $("#contenido-principal").html(contenido);
}

//Guardar
function guardarCargo(){
    if($("#descripcion").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar una descripción", "ERROR");
        return;
    }

    let data = {
        'descripcion': $("#descripcion").val(),
        'estado': $("#estado").val()
    };

    if($("#id_cargo").val() === "0"){
        ejecutarAjax("controladores/cargo.php", "guardar="+JSON.stringify(data));
        mensaje_dialogo_info("Guardado correctamente");
    }else{
        data = {...data, "id_cargo": $("#id_cargo").val()};
        ejecutarAjax("controladores/cargo.php", "actualizar="+JSON.stringify(data));
        mensaje_dialogo_info("Actualizado Correctamente");
        $("#id_cargo").val("0");
    }
    mostrarListarCargo();
}

$(document).on("click", ".eliminar-cargo", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/cargo.php",
        data: "eliminar="+id,
        success: function(){
            mensaje_dialogo_info("Eliminado");
            cargarTablaCargo();
        }
    });
});

$(document).on("click", ".editar-cargo", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let contenido = dameContenido("paginas/referenciales/cargo/agregar.php");
    $("#contenido-principal").html(contenido);
    let data = ejecutarAjax("controladores/cargo.php", "leer_cargo_id="+id);
    let json_data = JSON.parse(data);
    $("#descripcion").val(json_data.descripcion);
    $("#estado").val(json_data.estado);
    $("#id_cargo").val(id);
});

function cargarTablaCargo(){
    let data = ejecutarAjax("controladores/cargo.php", "leer_cargo=1");
    if(data === "0"){
        $("#cargo_tb").html("");
    }else{
        let json_data = JSON.parse(data);
        $("#cargo_tb").html("");
        json_data.map(function(item){
            $("#cargo_tb").append(`
                <tr>
                    <td>${item.id_cargo}</td>
                    <td>${item.descripcion}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-warning editar-cargo">Editar</button>
                        <button class="btn btn-danger eliminar-cargo">Eliminar</button>
                    </td>
                </tr>
            `);
        });
    }
}
