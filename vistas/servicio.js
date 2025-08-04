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
    if(confirm("¿Anular servicio?")){
        ejecutarAjax("controladores/servicio.php","anular="+id);
        cargarTablaServicio();
    }
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
            $(componente).append(`<option value="${item.id_presupuesto_servicio}">${item.id_presupuesto_servicio} - ${item.cliente}</option>`);
        });
    }
}

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

function agregarDetalleServicio(){
    if($("#tarea").val().trim().length === 0){
        alert("Ingrese tarea");
        return;
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
    console.log(cab);
    let id = ejecutarAjax("controladores/servicio.php","guardar="+encodeURIComponent(JSON.stringify(cab)));
    $("#detalle_servicio_tb tr").each(function(){
        let det = {
            id_servicio: id,
            tarea: $(this).find("td:eq(0)").text(),
            horas_trabajadas: $(this).find("td:eq(1)").text(),
            observaciones: $(this).find("td:eq(2)").text()
        };
        console.log(det);
        ejecutarAjax("controladores/servicio.php","guardar_detalle="+encodeURIComponent(JSON.stringify(det)));
    });
    mensaje_dialogo_info("Servicio registrado correctamente","REGISTRADO");
    mostrarListarServicio();
}

function imprimirServicio(id){
    window.open("paginas/movimientos/servicios/servicio/imprimir.php?id="+id);
}
