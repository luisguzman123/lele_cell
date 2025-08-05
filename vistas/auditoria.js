function mostrarAuditoria(){
    let contenido = dameContenido("paginas/reportes/auditoria.php");
    $("#contenido-principal").html(contenido);
    cargarTablaAuditoria();
}

function cargarTablaAuditoria(){
    let data = ejecutarAjax("controladores/auditoria.php", "listar=1");
    if(data === "0"){
        $("#auditoria_tb").html("");
    }else{
        let json_data = JSON.parse(data);
        $("#auditoria_tb").html("");
        json_data.map(function(item){
            $("#auditoria_tb").append(`
                <tr>
                    <td>${item.id_auditoria}</td>
                    <td>${item.usuario || ''}</td>
                    <td>${item.accion}</td>
                    <td>${item.tabla}</td>
                    <td>${item.id_registro || ''}</td>
                    <td>${item.detalles || ''}</td>
                    <td>${item.fecha}</td>
                </tr>
            `);
        });
    }
}
