<div class="row align-items-center mb-3">
    <div class="col-md-8">
        <h3 class="text-primary fw-bold">📋 Lista de Diagnósticos</h3>
    </div>
    <div class="col-md-4 text-end">
        <button class="btn btn-success" onclick="mostrarAgregarDiagnostico(); return false;">
            <i class="bi bi-plus-circle me-1"></i> Agregar Nuevo Diagnóstico
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Recepción</th>
                <th>Fecha</th>
                <th>Costo Estimado</th>
                <th>Estado</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody id="diagnostico_tb" class="text-center">
        </tbody>
    </table>
</div>
