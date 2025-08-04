let listaPedidosProveedor = [];
function mostrarListaPedidoProveedor() {
    let contenido = dameContenido("paginas/movimientos/compra/pedido_proveedor/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaPedidoProveedor();
}

function mostrarAgregarPedidoProveedor() {
    let contenido = dameContenido("paginas/movimientos/compra/pedido_proveedor/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaProductoCompra("#producto_lst");
    cargarListaProveedorCompra("#proveedor");
    dameFechaActual("fecha");
}

function cargarTablaPedidoProveedor(filtro = "") {
    let data = ejecutarAjax("controladores/pedido_proveedor.php", "leer=1");
    $("#pedido_proveedor_tb").html("");
    if (data === "0") {
        $("#pedido_proveedor_tb").html("<tr><td colspan='5'>NO HAY REGISTRO</td></tr>");
    } else {
        listaPedidosProveedor = JSON.parse(data);
        filtrarPedidoProveedor(filtro);
    }
}

function filtrarPedidoProveedor(texto = "") {
    $("#pedido_proveedor_tb").html("");
    let datos = listaPedidosProveedor;
    if (texto.trim().length) {
        texto = texto.toLowerCase();
        datos = datos.filter(it => it.nombre_proveedor.toLowerCase().includes(texto) || String(it.id_pedido).includes(texto));
    }
    if (datos.length === 0) {
        $("#pedido_proveedor_tb").html("<tr><td colspan='5'>SIN RESULTADOS</td></tr>");
        return;
    }
    datos.map(function(item) {
        $("#pedido_proveedor_tb").append(`
                <tr>
                    <td>${item.id_pedido}</td>
                    <td>${item.fecha}</td>
                    <td>${item.nombre_proveedor}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-danger anular-pedido-proveedor">Anular</button>
                        <button class="btn btn-primary imprimir-pedido-proveedor">Imprimir</button>
                    </td>
                </tr>
            `);
    });
}

function cargarListaProductoPedidoProveedor(componente){
    let data  = ejecutarAjax("controladores/producto.php","leer=1");
    if(data === "0"){
        $(componente).html("");
    }else{
        let json_data =  JSON.parse(data);
        $(componente).html("<option value='0'>Selecciona un Producto</option>");
        json_data.map(function (item) {
            $(componente).append(`<option value="${item.id_producto}">${item.nombre}</option>`);
        });
    }
}

function cargarListaProveedorPedidoProveedor(componente){
    let data = ejecutarAjax("controladores/proveedor_proyecto.php","leer_activo=1");
    if(data === "0"){
        $(componente).html("");
    }else{
        let json_data = JSON.parse(data);
        $(componente).html("<option value='0'>Selecciona un proveedor</option>");
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_proveedor}">${item.nombre_proveedor}</option>`);
        });
    }
}

function agregarProductoPedidoProveedor(){
    if($("#producto_lst").val() === "0"){
        mensaje_dialogo_info_ERROR("Debes seleccionar un producto","ATENCION");
        return;
    }
    if($("#cantidad").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes ingresar una cantidad","ATENCION");
        return;
    }
    if(parseInt($("#cantidad").val()) <= 0){
        mensaje_dialogo_info_ERROR("La cantidad debe ser mayor a cero","ATENCION");
        return;
    }
    let repetido = false;
    $("#detalle_tb tr").each(function(){
        if($(this).find("td:eq(0)").text() === $("#producto_lst").val()){
            repetido = true;
        }
    });
    if(repetido){
        mensaje_dialogo_info_ERROR("El registro ya ha sido agregado","ATENCION");
        return;
    }
    let cantidad = parseInt($("#cantidad").val());
    $("#detalle_tb").append(`
        <tr>
            <td>${$("#producto_lst").val()}</td>
            <td>${$("#producto_lst option:selected").text()}</td>
            <td>${cantidad}</td>
            <td><button class='btn btn-danger remover-item'>Remover</button></td>
        </tr>
    `);
}

$(document).on("click",".remover-item",function(){
    $(this).closest("tr").remove();
});

function guardarPedidoProveedor(){
    if($("#detalle_tb tr").length === 0){
        mensaje_dialogo_info_ERROR("Debes agregar productos","ATENCION");
        return;
    }
    if($("#proveedor").val() === "0"){
        mensaje_dialogo_info_ERROR("Debes seleccionar un proveedor","ATENCION");
        return;
    }
    let cabecera = {
        'fecha': $("#fecha").val(),
        'observacion': $("#observacion").val(),
        'proveedor': $("#proveedor").val(),
        'estado':'PENDIENTE'
    };
    ejecutarAjax("controladores/pedido_proveedor.php","guardar="+JSON.stringify(cabecera));
    let id = ejecutarAjax("controladores/pedido_proveedor.php","dameUltimoId=1");
    $("#detalle_tb tr").each(function(){
        let detalle = {
            'id_pedido': id,
            'id_producto': $(this).find("td:eq(0)").text(),
            'cantidad': $(this).find("td:eq(2)").text()
        };
        ejecutarAjax("controladores/pedido_proveedor.php","guardar_detalle="+JSON.stringify(detalle));
    });
    mensaje_dialogo_info("Guardado Correctamente");
    mostrarListaPedidoProveedor();
}

$(document).on("click",".anular-pedido-proveedor",function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    Swal.fire({
        title: "Anulacion",
        text: "Estas seguro de anular el registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si"
    }).then((result)=>{
        if(result.isConfirmed){
            ejecutarAjax("controladores/pedido_proveedor.php","anular="+id);
            cargarTablaPedidoProveedor();
        }
    });
});

function imprimirPedidoProveedor(id){
    window.open("paginas/movimientos/compra/pedido_proveedor/imprimir.php?id="+id);
}

$(document).on("click",".imprimir-pedido-proveedor",function(){
    imprimirPedidoProveedor($(this).closest("tr").find("td:eq(0)").text());
});

$(document).on("keyup","#buscar-pedido-proveedor",function(){
    filtrarPedidoProveedor($(this).val());
});


function cargarListaProductoCompra(componente){
    let data  = ejecutarAjax("controladores/producto.php","leer=1");
    if(data === "0"){
        $(componente).html("");
    }else{
        let json_data = JSON.parse(data);
        $(componente).html("<option value='0'>Selecciona un Producto</option>");
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_producto}" data-precio="${item.precio}" data-iva="${item.iva}">${item.nombre}</option>`);
        });
    }
}

function cargarListaProveedorCompra(componente){
    let data = ejecutarAjax("controladores/proveedor.php","leer=1");
    console.log(data);
    if(data === "0"){
        $(componente).html("");
    }else{
        let json_data = JSON.parse(data);
        $(componente).html("<option value='0'>Selecciona un proveedor</option>");
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_proveedor}">${item.nombre_proveedor}</option>`);
        });
    }
}