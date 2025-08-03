//mostrarLista
function mostrarListarEquipo() {
    let contenido = dameContenido("paginas/referenciales/equipo/listar.php");
    $("#contenido-principal").html(contenido);
    
    //poner el cargar tabla aca
    cargarTablaEquipo();
}

function mostrarAgregarEquipo() {
    let contenido = dameContenido("paginas/referenciales/equipo/agregar.php");
    $("#contenido-principal").html(contenido);
}

//guardar
function guardarEquipo(){
    if($("#marca").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar una marca", "ERROR");
        return;
    }
    if($("#modelo").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar un modelo", "ERROR");
        return;
    }
    if($("#descripcion").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("Debes de ingresar una descripcion", "ERROR");
        return;
    }
    
        
    let data = {
      'marca': $("#marca").val(),  
      'modelo': $("#modelo").val(),  
      'descripcion': $("#descripcion").val(),
      'estado': "ACTIVO"
    };
    console.log(data);
    
     if ($("#id_equipo").val() === "0"){
    
    let guardar = ejecutarAjax("controladores/equipo.php", "guardar="+JSON.stringify(data));
    console.log(guardar);
    mensaje_dialogo_info("Guardado correctamente");
    }else{
        data = {...data, "id_equipo": $("#id_equipo").val()};
        res = ejecutarAjax("controladores/equipo.php",
        "actualizar=" + JSON.stringify(data));
        console.log(res);
        mensaje_dialogo_info("Actualizado Correctamente");
        $("#id_equipo").text("");
        $("#btn_guardar").text("Guardar");
        
    }
    
    mostrarListarEquipo();
}
$(document).on("click", ".eliminar-equipo", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    console.log(id);
    
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/equipo.php",
        data: "eliminar="+id,
        success: function(datos){
            console.log(datos);
            mensaje_dialogo_info("Eliminado");
            cargarTablaEquipo();
        }
    });
});

$(document).on("click", ".editar-equipo", function(evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
  
    let contenido=dameContenido("paginas/referenciales/equipo/agregar.php");
    $("#contenido-principal").html(contenido);
    
    let data = ejecutarAjax("controladores/equipo.php", "leer_equipo_id="+id);
 
    
    let json_data = JSON.parse(data);
    
    $("#descripcion").val(json_data.descripcion);
    $("#marca").val(json_data.marca);
    $("#modelo").val(json_data.modelo);
    
    
    
    $("#id_equipo").val(id);
    
});


//cargartabla
function cargarTablaEquipo(){
     let data = ejecutarAjax("controladores/equipo.php", "leer_equipo=1");
    console.log(data);
    if(data === "0"){
        
    }else{
        let json_data = JSON.parse(data);
        $("#equipo_tb").html("");
        json_data.map(function (item) {
            
            $("#equipo_tb").append(`
                        <tr>
                            <td>${item.id_equipo}</td>
                            <td>${item.marca}</td>
                            <td>${item.modelo}</td>
                            <td>${item.estado}</td>
                            <td>
                              <button class="btn btn-warning editar-equipo">Editar</button>
                              <button class="btn btn-danger eliminar-equipo">Eliminar</button>
                            </td>
                        </tr>
            `);
        });
    }
}

























function guardar(){
    //JSON
    let data = {
       'nombre' : $("#nombre").val(),
       'apellido' : $("#apellido").val(),
       'fecha' : $("#fecha").val(),
       'color' : $("#color").val(),
       'estado' : "ACTIVO"
    };
   
    console.log(data);
    
    //AJAX
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/persona.php",
        data: "guardar="+JSON.stringify(data),
        success: function (datos) {
            console.log(datos);
            alert("GUARDADO");
        }
    });
}


function cargarTablaPersona(){
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/persona.php",
        data: "leer=1",
        success: function (datos) {
            console.log(datos);
            if(datos === "0"){
                $("#datos_tb").html("NO HAY DATOS");
            }else{
                let json_dato =  JSON.parse(datos);
                $("#datos_tb").html("");
                json_dato.map(function (item) {
                    
                    $("#datos_tb").append(` 
                        <tr>
                            <td>${item.id_persona}</td>
                            <td>${item.nombre}</td>
                            <td>${item.apellido}</td>
                            <td>${item.fecha_nacimiento}</td>
                            <td>${item.color}</td>
                            <td>${item.estado}</td>
                            <td><button class="btn btn-danger eliminar-persona">Eliminar</button></td>
                        </tr>
                    `);
                });
            }
        }
    });
}

window.onload =  function () {
    cargarTablaPersona();
    
};

$(document).on("click", ".eliminar-persona", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    console.log(id);
    
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "controladores/persona.php",
        data: "eliminar="+id,
        success: function (datos) {
            console.log(datos);
            alert("Eliminado");
            cargarTablaPersona();
        }
    });
});