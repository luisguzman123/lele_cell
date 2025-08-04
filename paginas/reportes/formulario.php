<?php
?>
<div class="container mt-4">
    <h4>Generar reporte</h4>
    <form id="formReporte" action="paginas/reportes/generar.php" method="get" target="_blank">
        <div class="mb-3">
            <label for="tipo_reporte" class="form-label">Tipo de reporte</label>
            <select class="form-select" id="tipo_reporte" name="tipo">
                <option value="compras">Compras</option>
                <option value="ventas">Ventas</option>
                <option value="servicios">Servicios</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="modulo" class="form-label">Módulo</label>
            <select class="form-select" id="modulo" name="modulo"></select>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="desde" class="form-label">Desde</label>
                <input type="date" class="form-control" id="desde" name="desde" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="hasta" class="form-label">Hasta</label>
                <input type="date" class="form-control" id="hasta" name="hasta" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Generar</button>
    </form>
</div>
<script>
const opciones = {
    compras: [
        'Pedido Proveedor',
        'Presupuesto',
        'Orden de Compra',
        'Factura de Compra'
    ],
    ventas: [
        'Apertura Cierre',
        'Facturación',
        'Presupuesto'
    ],
    servicios: [
        'Recepción',
        'Diagnóstico',
        'Presupuesto Servicio',
        'Servicio',
        'Entrega',
        'Garantía'
    ]
};
const tipo = document.getElementById('tipo_reporte');
const modulo = document.getElementById('modulo');
function cargarModulos(){
    modulo.innerHTML='';
    opciones[tipo.value].forEach(m => {
        const opt=document.createElement('option');
        opt.value=m.toLowerCase().replace(/ /g,'_');
        opt.textContent=m;
        modulo.appendChild(opt);
    });
}
tipo.addEventListener('change', cargarModulos);
cargarModulos();
</script>
