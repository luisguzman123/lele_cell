//mostrar Lista
function mostrarListarProducto() {
    let contenido = dameContenido("paginas/referenciales/producto/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaProducto();
}

//Mostrar Agregar
function mostrarAgregarProducto() {
    let contenido = dameContenido("paginas/referenciales/producto/agregar.php");
    $("#contenido-principal").html(contenido);
}

//Guardar
function guardarProducto(){
    if($("#nombre").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un nombre", "ERROR");
        return;
    }
    if($("#precio").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un precio", "ERROR");
        return;
    }
    if($("#stock").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un stock", "ERROR");
        return;
    }
    if($("#iva").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar el IVA", "ERROR");
        return;
    }

    let data = {
        'nombre': $("#nombre").val(),
        'precio': quitarDecimalesConvertir($("#precio").val()),
        'stock': $("#stock").val(),
        'estado': $("#estado").val(),
        'iva': $("#iva").val()
    };

    if ($("#id_producto").val() === "0"){
        ejecutarAjax("controladores/producto.php", "guardar="+JSON.stringify(data));
        mensaje_dialogo_info("Guardado correctamente");
    }else{
        data = {...data, "id_producto": $("#id_producto").val()};
        ejecutarAjax("controladores/producto.php", "actualizar="+JSON.stringify(data));
        mensaje_dialogo_info("Actualizado Correctamente");
        $("#id_producto").val("0");
    }
    mostrarListarProducto();
}


$(document).on("keyup", "#precio", function (evt) {
    $(this).val(formatearNumero($(this).val()));
});
$(document).on("click", ".eliminar-producto", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/producto.php",
        data: "eliminar="+id,
        success: function(){
            mensaje_dialogo_info("Eliminado");
            cargarTablaProducto();
        }
    });
});

$(document).on("click", ".editar-producto", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let contenido = dameContenido("paginas/referenciales/producto/agregar.php");
    $("#contenido-principal").html(contenido);
    let data = ejecutarAjax("controladores/producto.php", "leer_producto_id="+id);
    let json_data = JSON.parse(data);
    $("#nombre").val(json_data.nombre);
    $("#precio").val(json_data.precio);
    $("#stock").val(json_data.stock);
    $("#estado").val(json_data.estado);
    $("#iva").val(json_data.iva);
    $("#id_producto").val(id);
});

function cargarTablaProducto(){
    let data = ejecutarAjax("controladores/producto.php", "leer_producto=1");
    if(data === "0"){
        $("#producto_tb").html("");
    }else{
        let json_data = JSON.parse(data);
        $("#producto_tb").html("");
        json_data.map(function(item){
            $("#producto_tb").append(`
                <tr>
                    <td>${item.id_producto}</td>
                    <td>${item.nombre}</td>
                    <td>${formatearNumero((item.precio))}</td>
                    <td>${item.stock}</td>
                    <td>${item.iva}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-warning editar-producto">Editar</button>
                        <button class="btn btn-danger eliminar-producto">Eliminar</button>
                    </td>
                </tr>
            `);
        });
    }
}
