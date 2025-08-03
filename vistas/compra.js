let listaCompras = [];
function mostrarListaCompra(){
    let contenido = dameContenido("paginas/movimientos/compra/registro_compra/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaCompra();
}

function mostrarAgregarCompra(){
    let contenido = dameContenido("paginas/movimientos/compra/registro_compra/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaProductoCompra("#producto_lst");
    cargarListaProveedorCompra("#proveedor");
    cargarListaOrdenRegistro("#orden_lst");
    dameFechaActual("fecha");
}

function cargarTablaCompra(filtro=""){
    let data = ejecutarAjax("controladores/compra.php","leer=1");
    $("#compra_tb").html("");
    if(data === "0"){
        $("#compra_tb").html("<tr><td colspan='6'>NO HAY REGISTRO</td></tr>");
    }else{
        listaCompras = JSON.parse(data);
        filtrarCompra(filtro);
    }
}

function filtrarCompra(texto=""){
    $("#compra_tb").html("");
    let datos = listaCompras;
    if(texto.trim().length){
        texto = texto.toLowerCase();
        datos = datos.filter(it=> (it.nombre_proveedor || '').toLowerCase().includes(texto) || String(it.id_compra).includes(texto));
    }
    if(datos.length===0){
        $("#compra_tb").html("<tr><td colspan='6'>SIN RESULTADOS</td></tr>");
        return;
    }
    datos.map(function(item){
            $("#compra_tb").append(`
                <tr>
                    <td>${item.id_compra}</td>
                    <td>${item.fecha}</td>
                    <td>${item.nombre_proveedor || ''}</td>
                    <td>${formatearNumero(item.total)}</td>
                    <td>${item.estado}</td>
                    <td class="btn-group" role="group">
                        <button class="btn btn-danger anular-compra">Anular</button>
                        <button class="btn btn-primary imprimir-compra">Imprimir</button>
                    </td>
                </tr>
            `);
    });
}

//function cargarListaProductoCompra(componente){
//    let data  = ejecutarAjax("controladores/producto.php","leer=1");
//    if(data === "0"){
//        $(componente).html("");
//    }else{
//        let json_data = JSON.parse(data);
//        $(componente).html("<option value='0'>Selecciona un Producto</option>");
//        json_data.map(function(item){
//            $(componente).append(`<option value="${item.id_producto}" data-precio="${item.precio}" data-iva="${item.iva}">${item.nombre}</option>`);
//        });
//    }
//}
//
//function cargarListaProveedorCompra(componente){
//    let data = ejecutarAjax("controladores/proveedor_proyecto.php","leer_activo=1");
//    if(data === "0"){
//        $(componente).html("");
//    }else{
//        let json_data = JSON.parse(data);
//        $(componente).html("<option value='0'>Selecciona un proveedor</option>");
//        json_data.map(function(item){
//            $(componente).append(`<option value="${item.id_proveedor}">${item.nombre_proveedor}</option>`);
//        });
//    }
//}

function cargarListaOrdenRegistro(componente){
    let data = ejecutarAjax("controladores/orden_compra.php","leer_aprobado=1");
    if(data === "0"){
        $(componente).html("<option value='0'>Sin Orden</option>");
    }else{
        let json_data = JSON.parse(data);
        $(componente).html("<option value='0'>Sin Orden</option>");
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_orden}" data-proveedor="${item.id_proveedor}">${item.id_orden} - ${item.nombre_proveedor}</option>`);
        });
    }
}

$(document).on("change","#producto_lst",function(){
    let precio = $(this).find("option:selected").data("precio") || 0;
    $("#precio").val(precio);
});

$(document).on("change","#orden_lst",function(){
    if($(this).val() === "0"){
        $("#detalle_tb").html("");
        $("#proveedor").val("0");
        calcularTotalCompra();
        return;
    }
    let id = $(this).val();
    let data = ejecutarAjax("controladores/orden_compra.php","leer_detalle="+id);
    $("#detalle_tb").html("");
    if(data !== "0"){
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            let subtotal = parseInt(item.cantidad) * parseInt(item.precio);
            $("#detalle_tb").append(`
                <tr data-subtotal="${subtotal}" data-iva="${item.iva}">
                    <td>${item.id_producto}</td>
                    <td>${item.nombre}</td>
                    <td>${item.cantidad}</td>
                    <td>${formatearNumero(item.precio)}</td>
                    <td>${formatearNumero(subtotal)}</td>
                    <td><button class='btn btn-danger remover-item'>Remover</button></td>
                </tr>
            `);
        });
    }
    $("#proveedor").val($(this).find("option:selected").data("proveedor"));
    calcularTotalCompra();
});

function agregarProductoCompra(){
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
    let iva = $("#producto_lst option:selected").data("iva") || 0;
    let subtotal = precio * cantidad;
    $("#detalle_tb").append(`
        <tr data-subtotal="${subtotal}" data-iva="${iva}">
            <td>${$("#producto_lst").val()}</td>
            <td>${$("#producto_lst option:selected").text()}</td>
            <td>${cantidad}</td>
            <td>${formatearNumero(precio)}</td>
            <td>${formatearNumero(subtotal)}</td>
            <td><button class='btn btn-danger remover-item'>Remover</button></td>
        </tr>
    `);
    calcularTotalCompra();
}

$(document).on("click",".remover-item",function(){
    $(this).closest("tr").remove();
    calcularTotalCompra();
});

function calcularTotalCompra(){
    let exenta=0, cinco=0, diez=0;
    $("#detalle_tb tr").each(function(){
        let subtotal = parseInt($(this).data("subtotal"));
        let iva = parseInt($(this).data("iva"));
        if(iva===0){exenta += subtotal;}else if(iva===5){cinco += subtotal;}else if(iva===10){diez += subtotal;}
    });
    $("#t_exenta").text(formatearNumero(exenta));
    $("#t_5").text(formatearNumero(cinco));
    $("#t_10").text(formatearNumero(diez));
    $("#total_compra").text(formatearNumero(exenta+cinco+diez));
}

function guardarCompra(){
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
        'id_proveedor': $("#proveedor").val(),
        'id_orden': $("#orden_lst").val(),
        'total_exenta': quitarDecimalesConvertir($("#t_exenta").text()),
        'total_iva5': quitarDecimalesConvertir($("#t_5").text()),
        'total_iva10': quitarDecimalesConvertir($("#t_10").text()),
        'total': quitarDecimalesConvertir($("#total_compra").text()),
        'estado':'ACTIVO'
    };
    ejecutarAjax("controladores/compra.php","guardar="+JSON.stringify(cabecera));
    let id = ejecutarAjax("controladores/compra.php","dameUltimoId=1");
    $("#detalle_tb tr").each(function(){
        let detalle = {
            'id_compra': id,
            'id_producto': $(this).find("td:eq(0)").text(),
            'cantidad': $(this).find("td:eq(2)").text(),
            'precio': quitarDecimalesConvertir($(this).find("td:eq(3)").text())
        };
        ejecutarAjax("controladores/compra.php","guardar_detalle="+JSON.stringify(detalle));
    });
    mensaje_dialogo_info("Guardado Correctamente");
     let cambiar = ejecutarAjax("controladores/orden_compra.php", "cambiar_estado_utilizado="+ $("#orden_lst").val());
    mostrarListaCompra();
}

$(document).on("click",".anular-compra",function(){
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
            ejecutarAjax("controladores/compra.php","anular="+id);
            cargarTablaCompra();
        }
    });
});

function imprimirCompra(id){
    window.open("paginas/compra/registro_compra/imprimir.php?id="+id);
}

$(document).on("click",".imprimir-compra",function(){
    imprimirCompra($(this).closest("tr").find("td:eq(0)").text());
});

$(document).on("keyup","#buscar-compra",function(){
    filtrarCompra($(this).val());
});
