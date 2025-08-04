<div class="card mb-4 presupuesto-section">
  <div class="card-body">
    <!-- Cabecera -->
    <div class="row align-items-center mb-3">
      <div class="col-md-8">
        <h3 class="text-primary fw-bold">📝 Lista de Presupuestos</h3>
      </div>
      <div class="col-md-4 text-end">
        <button onclick="mostrarNuevoPresupuestoVenta(); return false;" class="btn btn-success">
          <i class="bi bi-plus-circle me-1"></i> Nuevo Presupuesto
        </button>
      </div>
    </div>

    <!-- Filtros -->
    <div class="row g-2 mb-3">
      <div class="col-md-3">
        <label class="form-label">Desde</label>
        <input type="date" class="form-control" id="desde">
      </div>
      <div class="col-md-3">
        <label class="form-label">Hasta</label>
        <input type="date" class="form-control" id="hasta">
      </div>
      <div class="col-md-3">
        <label class="form-label">Nro. Presupuesto</label>
        <input type="text" class="form-control" id="nro_presupuesto_busqueda">
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-secondary w-100">Buscar</button>
      </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-sm table-bordered table-hover align-middle mb-0">
        <thead class="table-dark text-center">
          <tr>
            <th>#</th>
            <th>Nro Presupuesto</th>
            <th>Emisión</th>
            <th>Vencimiento</th>
            <th>Cliente</th>
            <th>Condición</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Operaciones</th>
          </tr>
        </thead>
        <tbody id="datos_tb" class="text-center">
          <!-- Filas generadas dinámicamente -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Estilos -->
<style>
  .presupuesto-section .table th,
  .presupuesto-section .table td {
    vertical-align: middle;
  }

  .presupuesto-section .badge {
    text-transform: uppercase;
    font-size: 0.75rem;
    padding: 0.25em 0.5em;
  }
</style>
