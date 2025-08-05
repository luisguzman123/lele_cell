function mostrarListarEntradaSalida() {
    let contenido = dameContenido("paginas/referenciales/entrada_salida/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaEntradaSalida();
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function cargarTablaEntradaSalida(){
    let data =  ejecutarAjax("controladores/entrada_salida.php", "leer=1");
    console.log(data);
    let fila = "";
    if(data === "0"){
        fila = "NO HAY REGISTROS";
    }else{
        let json_data = JSON.parse(data);
        json_data.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.id_entrada}</td>`;
            fila += `<td>${item.fecha_entrada}</td>`;
            fila += `<td>${item.documento_referencia}</td>`;
            fila += `<td>${item.observaciones}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td class="btn-group" role="group">
                        <button class="btn btn-danger anular-pedido">Anular</button>
                        <button class="btn btn-primary imprimir-pedido">Imprimir</button>
                    </td>`;
            fila += `</tr>`;
        });
    }
    $("#entrada_salida_tb").html(fila);
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function mostrarAgregarEntradaSalida() {
    let contenido = dameContenido("paginas/referenciales/entrada_salida/agregar.php");
    $("#contenido-principal").html(contenido);
    
    dameFechaActual("fecha_entrada");

   
    cargarListaProducto("#producto_lst");
    cargarListaProveedor("#proveedor");

}
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------

function agregarTablaEntradaSalida() {
    if ($("#producto_lst").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes seleccionar un producto", "ATENCION");
        return;
    }

    if ($("#cantidad").val().trim().length === 0) {
        mensaje_dialogo_info_ERROR("Debes ingresar una cantidad", "ATENCION");
        return;
    }

    if (parseInt($("#cantidad").val().trim()) <= 0) {
        mensaje_dialogo_info_ERROR("La cantidad debe ser mayor a cero.", "ATENCION");
        return;
    }

    let repetido = false;

    $("#pedido_tb tr").each(function (evt) {
        if ($("#producto_lst").val() === $(this).find("td:eq(0)").text()) {
            repetido = true;
        }
    });

    if (repetido) {
        mensaje_dialogo_info_ERROR("El registro ya ha sido agregado anteriormente", "ATENCION");
        return;
    }

    $("#pedido_tb").append(`
        <tr>
            <td>${$("#producto_lst").val()}</td>
            <td>${$("#producto_lst option:selected").html().split(" | ")[0]}</td>
            <td>${$("#cantidad").val()}</td>
            <td><button class='btn btn-danger remover-item-pedido'>Remover</button></td>
        </tr>
    `);
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
$(document).on("click", ".remover-item-pedido", function (evt) {
    let tr = $(this).closest("tr");
    Swal.fire({
        title: "Eliminar",
        text: "Estas seguro de eliminar el registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si"
    }).then((result) => {
        if (result.isConfirmed) {
            $(tr).remove();
        }
    });
});
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
//-------------------------------------------------------------------------
function guardarEntradaSalida() {
    
     if ($("#pedido_tb").html().trim().length === 0) {
        mensaje_dialogo_info_ERROR("Debes agregar productos en la tabla", "ATENCION");
        return;
    }
    
    if ($("doc_ref").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes seleccionar un tipo", "ATENCION");
        return;
    }

    if ($("#observacion").val().trim().length === 0) {
        mensaje_dialogo_info_ERROR("Debes ingresar una observacion", "ATENCION");
        return;
    }
    
    if ($("proveedor").val() === "0") {
        mensaje_dialogo_info_ERROR("Debes seleccionar un proveedor", "ATENCION");
        return;
    }
    
   

    let cabecera = {
        'fecha_entrada': $("#fecha_entrada").val(),
        'proveedor': 1,
        'documento_referencia': $("#doc_ref").val(),
        'observaciones': $("#observacion").val(),
        'usuario_registro': $("#usu_reg").val(),
        'estado': 'PENDIENTE'
    };

    // Guardar cabecera y obtener el ID generado
    let response = ejecutarAjax("controladores/entrada_salida.php", "guardar=" + JSON.stringify(cabecera));

    console.log("ID Cabecera:", response);

//    // Aquí suponemos que 'response' es el ID insertado
//    let id_entrada = response.trim();
//
//    if (!id_entrada || isNaN(id_entrada)) {
//        mensaje_dialogo_info_ERROR("Error al guardar la cabecera del pedido", "ERROR");
//        return;
//    }
    let id = ejecutarAjax("controladores/entrada_salida.php", "dameUltimoId=1");
    // Recorrer cada fila para guardar detalle con el id_entrada correcto
    $("#pedido_tb tr").each(function () {
    let detalle = {
        id_entrada: id,
        id_producto: parseInt($(this).find("td:eq(0)").text()),
        cantidad: parseInt($(this).find("td:eq(2)").text())
    };

    console.log("Detalle que se enviará:", detalle);

    let responseDetalle = ejecutarAjax("controladores/entrada_salida.php", 
        "guardar_detalle=" + JSON.stringify(detalle));

    console.log("Respuesta del servidor:", responseDetalle) ;
    });

    mensaje_dialogo_info("EXITOSO", "Guardado Correctamente");
    mostrarListarEntradaSalida();
}

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//----------------------------------------------------------------------------
function imprimirEntradaSalida(id){
    window.open("paginas/referenciales/entrada_salida/imprimir.php?id="+id);
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
$(document).on("click", ".imprimir-pedido", function (evt) {
    imprimirEntradaSalida($(this).closest("tr").find("td:eq(0)").text());
});
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
$(document).on("click", ".anular-pedido", function (evt) {
     let id = $(this).closest("tr").find("td:eq(0)").text();
    Swal.fire({
        title: "Anulacion",
        text: "Estas seguro de anular el registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si"
    }).then((result) => {
        if (result.isConfirmed) {
            let response = ejecutarAjax("controladores/entrada_salida.php", "anular=" + id);
            console.log(response);
            mensaje_dialogo_info("Anulado Correctamente", "Anulado");
            cargarTablaEntradaSalida();
        }
    });
});
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function cargarTablaBusquedaEntradaSalidaCompra(){
    let data =  ejecutarAjax("controladores/pedido.php", "leer_busqueda="+$("#b_pedido").val());
    console.log(data);
    let fila = "";
    if(data === "0"){
        fila = "NO HAY REGISTROS";
    }else{
        let json_data = JSON.parse(data);
        json_data.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.id_pedido_cabecera}</td>`;
            fila += `<td>${item.fecha}</td>`;
            fila += `<td>${item.observacion}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class="btn btn-warning imprimir-pedido">Imprimir</button>
                        <button class="btn btn-danger anular-pedido">Anular</button>
                    </td>`;
            fila += `</tr>`;
        });
    }
    $("#pedido_tb").html(fila);
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//-----------------------------------------------------------------------------
 function cancelarEntradaSalidaCompra(){
     Swal.fire({
        title: "Cancelar",
        text: "Estas seguro de cancelar el pedido?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si"
    }).then((result) => {
        if (result.isConfirmed) {
            mostrarListarEntradaSalida();
        }
    });
 }
 
 //--------------------------------------------------------------------------
 //--------------------------------------------------------------------------
 //--------------------------------------------------------------------------
 function cargarListaEntradaSalidaPendiente(componente){
     let data = ejecutarAjax("controladores/pedido.php", 
        "leer_pendiente=1");
        console.log(data);
        let fila = "";
        if (data === "0") {
            fila += `<option value='0'>No hay EntradaSalidas</option>`;
        } else {
            let json_data = JSON.parse(data);
            fila += `<option value='0'>Selecciona un EntradaSalida</option>`;
            json_data.map(function (item) {
               fila += `<option value='${item.id_pedido_cabecera}'>${item.id_pedido_cabecera} |
               ${item.fecha} | ${item.observacion}</option>`;
            });
        }

        $(componente).html(fila);
 }
 
 function cargarListaProducto(componente){
    let data  = ejecutarAjax("controladores/producto.php",
    "leer=1");
    
    if(data === "0"){
        $(componente).html("");
    }else{
        let json_data =  JSON.parse(data);
        $(componente).html("<option value='0'>Selecciona un Producto</option>");
        json_data.map(function (item) {
            $(componente).append(`
<option value="${item.id_producto}">${item.nombre} </option>`);
        });
    }
}


 function cargarListaProveedor(componente){
    let data  = ejecutarAjax("controladores/proveedor_proyecto.php",
    "leer_activo=1");
    
    if(data === "0"){
        $(componente).html("");
    }else{
        let json_data =  JSON.parse(data);
        $(componente).html("<option value='0'>Selecciona un proveedor</option>");
        json_data.map(function (item) {
            $(componente).append(`
<option value="${item.id_proveedor}">${item.nombre_proveedor} </option>`);
        });
    }
}



