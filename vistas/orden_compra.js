let listaOrdenesCompra = [];
function mostrarListaOrdenCompra(){
    let contenido = dameContenido("paginas/movimientos/compra/orden_compra/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaOrdenCompra();
}

function mostrarAgregarOrdenCompra(){
    let contenido = dameContenido("paginas/movimientos/compra/orden_compra/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaProductoOrdenCompra("#producto_lst");
    cargarListaProveedorCompra("#proveedor");
    cargarListaPresupuestoOC("#presupuesto_lst");
    dameFechaActual("fecha");
}

function cargarTablaOrdenCompra(filtro=""){
    let data = ejecutarAjax("controladores/orden_compra.php","leer=1");
    $("#orden_compra_tb").html("");
    if(data === "0"){
        $("#orden_compra_tb").html("<tr><td colspan='6'>NO HAY REGISTRO</td></tr>");
    }else{
        listaOrdenesCompra = JSON.parse(data);
        filtrarOrdenCompra(filtro);
    }
}

function filtrarOrdenCompra(texto=""){
    $("#orden_compra_tb").html("");
    let datos = listaOrdenesCompra;
    if(texto.trim().length){
        texto = texto.toLowerCase();
        datos = datos.filter(it=>it.nombre_proveedor.toLowerCase().includes(texto) || String(it.id_orden).includes(texto));
    }
    if(datos.length===0){
        $("#orden_compra_tb").html("<tr><td colspan='6'>SIN RESULTADOS</td></tr>");
        return;
    }
    datos.map(function(item){
            $("#orden_compra_tb").append(`
                <tr>
                    <td>${item.id_orden}</td>
                    <td>${item.fecha}</td>
                    <td>${item.nombre_proveedor}</td>
                    <td>${formatearNumero(item.total)}</td>
                    <td>
                        <select class="form-select form-select-sm estado-orden" data-id="${item.id_orden}">
                            <option value="ACTIVO" ${item.estado === 'ACTIVO' ? 'selected' : ''}>ACTIVO</option>
                            <option value="APROBADO" ${item.estado === 'APROBADO' ? 'selected' : ''}>APROBADO</option>
                            <option value="ANULADO" ${item.estado === 'ANULADO' ? 'selected' : ''}>ANULADO</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-danger anular-orden-compra">Anular</button>
                        <button class="btn btn-primary imprimir-orden-compra">Imprimir</button>
                    </td>
                </tr>
            `);
    });
}

function cargarListaProductoOrdenCompra(componente){
    let data  = ejecutarAjax("controladores/producto.php","leer=1");
    if(data === "0"){
        $(componente).html("");
    }else{
        let json_data = JSON.parse(data);
        $(componente).html("<option value='0'>Selecciona un Producto</option>");
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_producto}" data-precio="${item.precio}">${item.nombre}</option>`);
        });
    }
}

function cargarListaProveedorOrdenCompra(componente){
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

function cargarListaPresupuestoOC(componente){
    let data = ejecutarAjax("controladores/presupuesto.php","leer_aprobado=1");
    if(data === "0"){
        $(componente).html("<option value='0'>Sin Presupuesto</option>");
    }else{
        let json_data = JSON.parse(data);
        $(componente).html("<option value='0'>Sin Presupuesto</option>");
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_presupuesto}" data-proveedor="${item.id_proveedor}">${item.id_presupuesto} - ${item.nombre_proveedor}</option>`);
        });
    }
}

$(document).on("change","#producto_lst",function(){
    let precio = $(this).find("option:selected").data("precio") || 0;
    $("#precio").val(precio);
});

$(document).on("change","#presupuesto_lst",function(){
    if($(this).val() === "0"){
        $("#detalle_tb").html("");
        $("#proveedor").val("0");
        calcularTotalOrdenCompra();
        return;
    }
    let id = $(this).val();
    let data = ejecutarAjax("controladores/presupuesto.php","leer_detalle="+id);
    $("#detalle_tb").html("");
    if(data !== "0"){
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            let subtotal = parseInt(item.cantidad) * parseInt(item.precio);
            $("#detalle_tb").append(`
                <tr data-subtotal="${subtotal}">
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
    calcularTotalOrdenCompra();
});

function agregarProductoOrdenCompra(){
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
    calcularTotalOrdenCompra();
}

$(document).on("click",".remover-item",function(){
    $(this).closest("tr").remove();
    calcularTotalOrdenCompra();
});

function calcularTotalOrdenCompra(){
    let total = 0;
    $("#detalle_tb tr").each(function(){
        total += parseInt($(this).data("subtotal"));
    });
    $("#total_orden").text(formatearNumero(total));
}

function guardarOrdenCompra(){
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
        'total': quitarDecimalesConvertir($("#total_orden").text()),
        'presupuesto': $("#presupuesto_lst").val(),
        'estado':'ACTIVO'
    };
    ejecutarAjax("controladores/orden_compra.php","guardar="+JSON.stringify(cabecera));
    let id = ejecutarAjax("controladores/orden_compra.php","dameUltimoId=1");
    $("#detalle_tb tr").each(function(){
        let detalle = {
            'id_orden': id,
            'id_producto': $(this).find("td:eq(0)").text(),
            'cantidad': $(this).find("td:eq(2)").text(),
            'precio': quitarDecimalesConvertir($(this).find("td:eq(3)").text())
        };
        ejecutarAjax("controladores/orden_compra.php","guardar_detalle="+JSON.stringify(detalle));
    });
    mensaje_dialogo_info("Guardado Correctamente");
    let cambiar = ejecutarAjax("controladores/presupuesto.php", "cambiar_estado_utilizado="+ $("#presupuesto_lst").val());
    mostrarListaOrdenCompra();
}

$(document).on("click",".anular-orden-compra",function(){
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
            ejecutarAjax("controladores/orden_compra.php","anular="+id);
            cargarTablaOrdenCompra();
        }
    });
});

function imprimirOrdenCompra(id){
    window.open("paginas/compra/orden_compra/imprimir.php?id="+id);
}

$(document).on("click",".imprimir-orden-compra",function(){
    imprimirOrdenCompra($(this).closest("tr").find("td:eq(0)").text());
});

$(document).on("keyup","#buscar-orden-compra",function(){
    filtrarOrdenCompra($(this).val());
});

$(document).on("change", ".estado-orden", function(){
    let id = $(this).data("id");
    let estado = $(this).val();
    ejecutarAjax("controladores/orden_compra.php", "cambiar_estado="+id+"&estado="+estado);
});
