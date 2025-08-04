let listaPresupuestos = [];
function mostrarListaPresupuesto() {
    let contenido = dameContenido("paginas/movimientos/compra/presupuesto/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaPresupuesto();
}

function mostrarAgregarPresupuesto() {
    let contenido = dameContenido("paginas/movimientos/compra/presupuesto/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaProductoPresupuesto("#producto_lst");
    cargarListaProveedorCompra("#proveedor");
    cargarListaPedidoPresupuesto("#pedido_lst");
    dameFechaActual("fecha");
}

function cargarTablaPresupuesto(filtro = "") {
    let data = ejecutarAjax("controladores/presupuesto.php", "leer=1");
    $("#presupuesto_tb").html("");
    if (data === "0") {
        $("#presupuesto_tb").html("<tr><td colspan='7'>NO HAY REGISTRO</td></tr>");
    } else {
        listaPresupuestos = JSON.parse(data);
        filtrarPresupuesto(filtro);
    }
}

function filtrarPresupuesto(texto = "") {
    $("#presupuesto_tb").html("");
    let datos = listaPresupuestos;
    if (texto.trim().length) {
        texto = texto.toLowerCase();
        datos = datos.filter(it => it.nombre_proveedor.toLowerCase().includes(texto) || String(it.id_presupuesto).includes(texto));
    }
    if (datos.length === 0) {
        $("#presupuesto_tb").html("<tr><td colspan='7'>SIN RESULTADOS</td></tr>");
        return;
    }
    datos.map(function(item) {
        $("#presupuesto_tb").append(`
                <tr>
                    <td>${item.id_presupuesto}</td>
                    <td>${item.fecha}</td>
                    <td>${item.nombre_proveedor}</td>
                    <td>${formatearNumero(item.total)}</td>
                    <td>${item.observacion}</td>
                    <td>
                        <select class="form-select form-select-sm estado-presupuesto">
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="APROBADO">APROBADO</option>
                            <option value="ANULADO">ANULADO</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-danger anular-presupuesto">Anular</button>
                        <button class="btn btn-primary imprimir-presupuesto">Imprimir</button>
                    </td>
                </tr>
            `);
        $("#presupuesto_tb").find('tr:last .estado-presupuesto').val(item.estado);
    });
}

function cargarListaProductoPresupuesto(componente){
    let data  = ejecutarAjax("controladores/producto.php","leer=1");
    if(data === "0"){
        $(componente).html("");
    }else{
        let json_data =  JSON.parse(data);
        $(componente).html("<option value='0'>Selecciona un Producto</option>");
        json_data.map(function (item) {
            $(componente).append(`<option value="${item.id_producto}" data-precio="${item.precio}">${item.nombre}</option>`);
        });
    }
}

$(document).on("change", "#producto_lst", function(){
    let precio = $(this).find("option:selected").data("precio") || 0;
    $("#precio").val(precio);
});

$(document).on("change","#pedido_lst",function(){
    if($(this).val() === "0"){
        $("#detalle_tb").html("");
        $("#proveedor").val("0");
        calcularTotalPresupuestoCompra();
        return;
    }
    let id = $(this).val();
    let data = ejecutarAjax("controladores/pedido_proveedor.php","leer_detalle="+id);
    $("#detalle_tb").html("");
    if(data !== "0"){
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            $("#detalle_tb").append(`
                <tr data-subtotal="0">
                    <td>${item.id_producto}</td>
                    <td>${item.nombre}</td>
                    <td>${item.cantidad}</td>
                    <td><input type="number" class="form-control precio-pedido" value="0" min="0"></td>
                    <td class="subtotal-pedido">0</td>
                    <td><button class='btn btn-danger remover-item'>Remover</button></td>
                </tr>
            `);
        });
    }
    $("#proveedor").val($(this).find("option:selected").data("proveedor"));
    calcularTotalPresupuestoCompra();
});

$(document).on("input", ".precio-pedido", function(){
    let fila = $(this).closest("tr");
    let precio = parseInt($(this).val()) || 0;
    let cantidad = parseInt(fila.find("td:eq(2)").text());
    let subtotal = precio * cantidad;
    fila.data("subtotal", subtotal);
    fila.find(".subtotal-pedido").text(formatearNumero(subtotal));
    calcularTotalPresupuestoCompra();
});

function cargarListaProveedorPresupuesto(componente){
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

function cargarListaPedidoPresupuesto(componente){
    let data = ejecutarAjax("controladores/pedido_proveedor.php","leer_activo=1");
//    console.log(data);
    if(data === "0"){
        $(componente).html("<option value='0'>Sin Pedido</option>");
    }else{
        let json_data = JSON.parse(data);
        $(componente).html("<option value='0'>Sin Pedido</option>");
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_pedido}" data-proveedor="${item.id_proveedor}">${item.id_pedido} - ${item.nombre_proveedor}</option>`);
        });
    }
}

function agregarProductoPresupuesto(){
    if($("#producto_lst").val() === "0"){
        mensaje_dialogo_info_ERROR("Debes seleccionar un producto","ATENCION");
        return;
    }
    if($("#cantidad").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes ingresar una cantidad","ATENCION");
        return;
    }
    if($("#precio").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes ingresar un precio","ATENCION");
        return;
    }
    if(parseInt($("#cantidad").val()) <= 0){
        mensaje_dialogo_info_ERROR("La cantidad debe ser mayor a cero","ATENCION");
        return;
    }
    if(parseInt($("#precio").val()) <= 0){
        mensaje_dialogo_info_ERROR("El precio debe ser mayor a cero","ATENCION");
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
    let precio = parseInt($("#precio").val());
    let cantidad = parseInt($("#cantidad").val());
    let subtotal = precio * cantidad;
    $("#detalle_tb").append(`
        <tr data-subtotal="${subtotal}">
            <td>${$("#producto_lst").val()}</td>
            <td>${$("#producto_lst option:selected").text()}</td>
            <td>${cantidad}</td>
            <td>${formatearNumero(precio)}</td>
            <td>${formatearNumero(subtotal)}</td>
            <td><button class='btn btn-danger remover-item'>Remover</button></td>
        </tr>
    `);
    calcularTotalPresupuestoCompra();
}

$(document).on("click",".remover-item",function(){
    $(this).closest("tr").remove();
    calcularTotalPresupuestoCompra();
});

function calcularTotalPresupuestoCompra(){
    let total = 0;
    $("#detalle_tb tr").each(function(){
        total += parseInt($(this).data("subtotal"));
    });
    $("#total_presupuesto").text(formatearNumero(total));
}

function guardarPresupuesto(){
    if($("#detalle_tb tr").length === 0){
        mensaje_dialogo_info_ERROR("Debes agregar productos","ATENCION");
        return;
    }
    if($("#proveedor").val() === "0"){
        mensaje_dialogo_info_ERROR("Debes seleccionar un proveedor","ATENCION");
        return;
    }
    if($("#total_presupuesto").text() === "0"){
         mensaje_dialogo_info_ERROR("Debes seleccionar un proveedor","ATENCION");
        return;
    }
    let cabecera = {
        'fecha': $("#fecha").val(),
        'observacion': $("#observacion").val(),
        'proveedor': $("#proveedor").val(),
        'total': quitarDecimalesConvertir($("#total_presupuesto").text()),
        'estado':'ACTIVO'
    };
    ejecutarAjax("controladores/presupuesto.php","guardar="+JSON.stringify(cabecera));
    let id = ejecutarAjax("controladores/presupuesto.php","dameUltimoId=1");
    $("#detalle_tb tr").each(function(){
        let precioCelda = $(this).find("td:eq(3)");
        let precioVal = precioCelda.find("input").length ? precioCelda.find("input").val() : precioCelda.text();
        let detalle = {
            'id_presupuesto': id,
            'id_producto': $(this).find("td:eq(0)").text(),
            'cantidad': $(this).find("td:eq(2)").text(),
            'precio': quitarDecimalesConvertir(precioVal)
        };
        ejecutarAjax("controladores/presupuesto.php","guardar_detalle="+JSON.stringify(detalle));
    });
    mensaje_dialogo_info("Guardado Correctamente");
    let cambiar_estado = ejecutarAjax("controladores/pedido_proveedor.php", "cambiar_estado="+ $("#pedido_lst").val());
    mostrarListaPresupuesto();
}

function imprimirPresupuesto(id){
    window.open("paginas/movimientos/compra/presupuesto/imprimir.php?id="+id);
}

$(document).on("click",".imprimir-presupuesto",function(){
    imprimirPresupuesto($(this).closest("tr").find("td:eq(0)").text());
});

$(document).on("click",".anular-presupuesto",function(){
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
            ejecutarAjax("controladores/presupuesto.php","anular="+id);
            cargarTablaPresupuesto();
        }
    });
});

$(document).on("change", ".estado-presupuesto", function(){
    let fila = $(this).closest("tr");
    let id = fila.find("td:eq(0)").text();
    let estado = $(this).val();
    ejecutarAjax("controladores/presupuesto.php", "cambiar_estado="+id+"&estado="+estado);
});

$(document).on("keyup","#buscar-presupuesto",function(){
    filtrarPresupuesto($(this).val());
});
