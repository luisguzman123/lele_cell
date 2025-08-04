function mostrarListarServicio(){
    let contenido = dameContenido("paginas/movimientos/servicios/servicio/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaServicio();
}

function mostrarAgregarServicio(){
    let contenido = dameContenido("paginas/movimientos/servicios/servicio/agregar.php");
    $("#contenido-principal").html(contenido);
    dameFechaActual("fecha_inicio");
    dameFechaActual("fecha_fin");
    cargarListaPresupuestoServicio("#presupuesto_lst");
    cargarListaTecnicoServicio("#tecnico_lst");
    cargarListaRepuestoServicio("#repuesto_lst");
    calcularTotales();
}

function cargarTablaServicio(){
    let data = ejecutarAjax("controladores/servicio.php","leer=1");
    $("#servicio_tb").html("");
    if(data === "0"){
        $("#servicio_tb").html("<tr><td colspan='8'>NO HAY REGISTRO</td></tr>");
    }else{
        let json = JSON.parse(data);
        json.map(function(item){
            $("#servicio_tb").append(`
                <tr>
                    <td>${item.id_servicio}</td>
                    <td>${item.id_presupuesto} - ${item.cliente}</td>
                    <td>${item.tecnico}</td>
                    <td>${item.fecha_inicio}</td>
                    <td>${item.fecha_fin || ''}</td>
                    <td>${item.estado}</td>
                    <td>${item.observaciones || ''}</td>
                    <td>
                        <button class='btn btn-danger anular-servicio'>Anular</button>
                        <button class='btn btn-primary imprimir-servicio'>Imprimir</button>
                    </td>
                </tr>
            `);
        });
    }
}

$(document).on("click",".anular-servicio",function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let estado = $(this).closest("tr").find("td:eq(5)").text();
    if(estado === "ANULADO"){
          mensaje_dialogo_info_ERROR("No puedes anular este registro", "ATENCION");
        return;
    }
    Swal.fire({
    title: '¿Anular servicio?',
    text: "Una vez anulado, no podrás revertir esta acción.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, anular',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      ejecutarAjax("controladores/servicio.php", "anular=" + id);
      cargarTablaServicio();
      Swal.fire(
        '¡Anulado!',
        'El servicio ha sido anulado.',
        'success'
      );
    }
  });
});

$(document).on("click",".imprimir-servicio",function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    imprimirServicio(id);
});

function cargarListaPresupuestoServicio(componente){
    let data = ejecutarAjax("controladores/servicio.php","leer_presupuesto=1");
    if(data === "0"){
        $(componente).html("<option value='0'>Sin presupuestos</option>");
    }else{
        let json = JSON.parse(data);
        $(componente).html("<option value='0'>-- Seleccione un presupuesto --</option>");
        json.map(function(item){
            $(componente).append(`<option value="${item.id_presupuesto_servicio}" data-total="${item.total}">${item.id_presupuesto_servicio} - ${item.cliente}</option>`);
        });
    }
}

$(document).on("change","#presupuesto_lst",function(){
    let total = $(this).find("option:selected").data("total") || 0;
    $("#precio_presupuesto").val(total);
    calcularTotales();
});

function cargarListaTecnicoServicio(componente){
    let data = ejecutarAjax("controladores/tecnico.php","leer_activo=1");
    if(data === "0"){
        $(componente).html("<option value='0'>Sin técnicos</option>");
    }else{
        let json = JSON.parse(data);
        $(componente).html("<option value='0'>-- Seleccione un técnico --</option>");
        json.map(function(item){
            $(componente).append(`<option value="${item.id_tecnico}">${item.nombre_tecnico}</option>`);
        });
    }
}

function cargarListaRepuestoServicio(componente){
    let data = ejecutarAjax("controladores/repuesto.php","leer=1");
    if(data === "0"){
        $(componente).html("<option value='0'>Sin repuestos</option>");
    }else{
        let json = JSON.parse(data);
        $(componente).html("<option value='0'>-- Seleccione un repuesto --</option>");
        json.map(function(item){
            $(componente).append(`<option value="${item.id_repuesto}" data-precio="${item.precio}">${item.nombre_repuesto}</option>`);
        });
    }
}

$(document).on("change","#repuesto_lst",function(){
    let precio = $(this).find("option:selected").data("precio") || 0;
    $("#precio_repuesto").val(precio);
});

function agregarDetalleServicio(){
    if($("#tarea").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Ingrese tarea");
        return;
    }
    if($("#obs_detalle").val().trim().length === 0){
        $("#obs_detalle").val("SIN OBS");
    }
    let horas = parseFloat($("#horas").val()) || 0;
    $("#detalle_servicio_tb").append(`
        <tr>
            <td>${$("#tarea").val()}</td>
            <td>${horas}</td>
            <td>${$("#obs_detalle").val()}</td>
            <td><button class='btn btn-danger remover-item'>Remover</button></td>
        </tr>
    `);
    $("#tarea").val('');
    $("#horas").val(0);
    $("#obs_detalle").val('');
}

$(document).on("click",".remover-item",function(){
    $(this).closest("tr").remove();
});

function agregarRepuestoServicio(){
    if($("#repuesto_lst").val() === "0"){
        mensaje_dialogo_info_ERROR("Seleccione un repuesto");
        return;
    }
    let precio = parseFloat($("#precio_repuesto").val()) || 0;
    let cantidad = parseInt($("#cantidad_repuesto").val()) || 1;
    let subtotal = precio * cantidad;
    let nombre = $("#repuesto_lst option:selected").text();
    let id = $("#repuesto_lst").val();
    $("#repuesto_servicio_tb").append(`
        <tr data-id_repuesto="${id}" data-precio="${precio}" data-cantidad="${cantidad}">
            <td>${nombre}</td>
            <td class="text-end">${formatearNumero(precio)}</td>
            <td class="text-center">${cantidad}</td>
            <td class="text-end subtotal">${formatearNumero(subtotal)}</td>
            <td class="text-center"><input type="checkbox" class="chk-cobrar" checked></td>
            <td><button class='btn btn-danger remover-repuesto'>Remover</button></td>
        </tr>
    `);
    $("#repuesto_lst").val("0");
    $("#precio_repuesto").val("0");
    $("#cantidad_repuesto").val(1);
    calcularTotales();
}

$(document).on("click",".remover-repuesto",function(){
    $(this).closest("tr").remove();
    calcularTotales();
});

$(document).on("change",".chk-cobrar",function(){
    calcularTotales();
});

function guardarServicio(){
    if($("#presupuesto_lst").val() === "0"){
        mensaje_dialogo_info_ERROR("Seleccione un presupuesto");
        return;
    }
    if($("#tecnico_lst").val() === "0"){
        mensaje_dialogo_info_ERROR("Seleccione un técnico");
        return;
    }
    if($("#detalle_servicio_tb tr").length === 0){
        mensaje_dialogo_info_ERROR("Agregue detalle");
        return;
    }
    let cab = {
        id_presupuesto: $("#presupuesto_lst").val(),
        id_tecnico: $("#tecnico_lst").val(),
        fecha_inicio: $("#fecha_inicio").val(),
        fecha_fin: $("#fecha_fin").val(),
        estado: 'En Proceso',
        observaciones: $("#observaciones").val()
    };
    ejecutarAjax("controladores/servicio.php","guardar="+encodeURIComponent(JSON.stringify(cab)));
    let id = ejecutarAjax("controladores/servicio.php","dameUltimoId=1");
    $("#detalle_servicio_tb tr").each(function(){
        let det = {
            id_servicio: id,
            tarea: $(this).find("td:eq(0)").text(),
            horas_trabajadas: $(this).find("td:eq(1)").text(),
            observaciones: $(this).find("td:eq(2)").text()
        };
        ejecutarAjax("controladores/servicio.php","guardar_detalle="+encodeURIComponent(JSON.stringify(det)));
    });
    $("#repuesto_servicio_tb tr").each(function(){
        let rep = {
            id_servicio: id,
            id_repuesto: $(this).data("id_repuesto"),
            cantidad: $(this).data("cantidad")
        };
        ejecutarAjax("controladores/servicio.php","guardar_repuesto="+encodeURIComponent(JSON.stringify(rep)));
    });
    mensaje_dialogo_info("Servicio registrado correctamente","REGISTRADO");
    mostrarListarServicio();
}

function imprimirServicio(id){
    window.open("paginas/movimientos/servicios/servicio/imprimir.php?id="+id);
}

function calcularTotales(){
    let total_repuesto = 0;
    $("#repuesto_servicio_tb tr").each(function(){
        if($(this).find(".chk-cobrar").is(":checked")){
            let precio = parseFloat($(this).data("precio")) || 0;
            let cant = parseInt($(this).data("cantidad")) || 0;
            total_repuesto += precio * cant;
        }
    });
    let presupuesto = parseFloat($("#precio_presupuesto").val()) || 0;
    $("#total_presupuesto").text(formatearNumero(presupuesto));
    $("#total_repuesto").text(formatearNumero(total_repuesto));
    $("#total_general").text(formatearNumero(total_repuesto + presupuesto));
}
