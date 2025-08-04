<div class="row mb-3">
  <div class="col-md-8">
    <h3 class="text-primary fw-bold">📦 Lista de Entregas</h3>
  </div>
  <div class="col-md-4 text-end">
    <button class="btn btn-success" onclick="mostrarAgregarEntrega(); return false;">
      <i class="bi bi-plus-circle me-1"></i> Agregar Entrega
    </button>
  </div>
</div>
<div class="table-responsive">
  <table class="table table-sm table-bordered table-hover align-middle">
    <thead class="table-dark text-center">
      <tr>
        <th>#</th>
        <th>Servicio</th>
        <th>Monto</th>
        <th>Fecha Entrega</th>
        <th>Usuario</th>
        <th>Estado</th>
        <th>Operaciones</th>
      </tr>
    </thead>
    <tbody id="entrega_tb" class="text-center"></tbody>
  </table>
</div>
