//mostrar Lista
function mostrarListarCliente() {
    let contenido = dameContenido("paginas/referenciales/cliente/listar.php");
    $("#contenido-principal").html(contenido);
    
    //poner el cargar tabla aca
    cargarTablaClientes();
}


//MOstrar Agregar
function mostrarAgregarCliente() {
    let contenido = dameContenido("paginas/referenciales/cliente/agregar.php");
    $("#contenido-principal").html(contenido);
}


//cargarTabla
function cargarListaClientes(componente){
    let data  = ejecutarAjax("controladores/cliente.php",
    "leer=1");
    console.log(data);
    
    if(data === "0"){
        $(componente).html("");
    }else{
        let json_data =  JSON.parse(data);
        $(componente).html("<option value='0'>Selecciona un cliente</option>");
        json_data.map(function (item) {
            $(componente).append(`
<option value="${item.id_cliente}">${item.razon_social} | ${item.ruc}</option>`);
        });
    }
}


//guardar

function guardarClientes(){
    if($("#nombre").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un nombre", "ERROR");
        return;
    }
    if($("#apellido").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un apellido", "ERROR");
        return;
    }
    if($("#telefono").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un teléfono", "ERROR");
        return;
    }
    if($("#cedula").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar una cedula", "ERROR");
        return;
    }
    
    if($("#correo").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un correo", "ERROR");
        return;
    }
    
        
    let data = {
      'nombre': $("#nombre").val(),  
      'apellido': $("#apellido").val(),  
      'cedula': $("#cedula").val(),  
      'correo': $("#correo").val(),
      'telefono': $("#telefono").val(),
      'estado': "ACTIVO"
    };
    console.log(data);
    
     if ($("#id_cliente").val() === "0"){
    
    let guardar = ejecutarAjax("controladores/cliente.php", "guardar="+JSON.stringify(data));
    console.log(guardar);
    mensaje_dialogo_info("Guardado correctamente");
    }else{
        data = {...data, "id_cliente": $("#id_cliente").val()};
        res = ejecutarAjax("controladores/cliente.php",
        "actualizar=" + JSON.stringify(data));
        console.log(res);
        mensaje_dialogo_info("Actualizado Correctamente");
        $("#id_cliente").text("");
        $("#btn_guardar").text("Guardar");
        
    }
    
    
    mostrarListarCliente();
}


$(document).on("click", ".eliminar-cliente", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    console.log(id);
    
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/cliente.php",
        data: "eliminar="+id,
        success: function(datos){
            console.log(datos);
            mensaje_dialogo_info("Eliminado");
            cargarTablaClientes();
        }
    });
});

$(document).on("click", ".editar-cliente", function(evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
  
    let contenido=dameContenido("paginas/referenciales/cliente/agregar.php");
    $("#contenido-principal").html(contenido);
    
    let data = ejecutarAjax("controladores/cliente.php", "leer_cliente_id="+id);
 
    
    let json_data = JSON.parse(data);
    
    $("#nombre").val(json_data.nombre);
    $("#apellido").val(json_data.apellido);
    $("#telefono").val(json_data.telefono);
    $("#cedula").val(json_data.cedula);
    $("#correo").val(json_data.correo);
    $("#estado").val(json_data.estado);
    
    
    
    $("#id_cliente").val(id);
    
});

//cargartabla
function cargarTablaClientes(){
     let data = ejecutarAjax("controladores/cliente.php", "leer_cliente=1");
    console.log(data);
    if(data === "0"){
        
    }else{
        let json_data = JSON.parse(data);
        $("#cliente_tb").html("");
        json_data.map(function (item) {
            
            $("#cliente_tb").append(`
                        <tr>
                            <td>${item.id_cliente}</td>
                            <td>${item.nombre}</td>
                            <td>${item.apellido}</td>
                            <td>${item.cedula}</td>
                            <td>${item.telefono}</td>
                            <td>${item.correo}</td>
                            <td>${item.estado}</td>
                            <td>
                              <button class="btn btn-warning editar-cliente">Editar</button>
                              <button class="btn btn-danger eliminar-cliente">Eliminar</button>
                            </td>
                        </tr>
            `);
        });
    }
}