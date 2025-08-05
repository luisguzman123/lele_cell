<?php
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Reporte de Auditoría</h4>
        <button id="btn-imprimir" class="btn btn-secondary btn-sm">Imprimir</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Tabla</th>
                    <th>ID Registro</th>
                    <th>Detalles</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody id="auditoria_tb"></tbody>
        </table>
    </div>
</div>
<script>
document.getElementById('btn-imprimir').addEventListener('click', function () {
    window.print();
});
</script>
<style>
@media print {
    #btn-imprimir {
        display: none;
    }
}
</style>
