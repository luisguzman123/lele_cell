<div class="row align-items-center mb-3">
  <div class="col-md-8">
    <h3 class="text-primary fw-bold">📋 Lista de Servicios</h3>
  </div>
  <div class="col-md-4 text-end">
    <button class="btn btn-success" onclick="mostrarAgregarServicio(); return false;">
      <i class="bi bi-plus-circle me-1"></i> Agregar Nuevo Servicio
    </button>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-sm table-bordered table-hover align-middle">
    <thead class="table-dark text-center">
      <tr>
        <th>#</th>
        <th>Presupuesto</th>
        <th>Técnico</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Estado</th>
        <th>Observaciones</th>
        <th>Operaciones</th>
      </tr>
    </thead>
    <tbody id="servicio_tb" class="text-center"></tbody>
  </table>
</div>
