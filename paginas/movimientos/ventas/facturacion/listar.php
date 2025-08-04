<div class="card mb-4 facturacion-section">
  <div class="card-body">
    <!-- Cabecera -->
    <div class="row align-items-center mb-3">
      <div class="col-md-8">
        <h3 class="text-primary fw-bold">📄 Lista de Facturación</h3>
      </div>
      <div class="col-md-4 text-end">
        <button onclick="mostrarNuevaFactura(); return false;" class="btn btn-success">
          <i class="bi bi-plus-circle me-1"></i> Nueva Factura
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
        <label class="form-label">Nro. Factura</label>
        <input type="text" class="form-control" id="nro_factura_busqueda">
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button id="buscar-factura" class="btn btn-secondary w-100">Buscar</button>
      </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-sm table-bordered table-hover align-middle mb-0">
        <thead class="table-dark text-center">
          <tr>
            <th>#</th>
            <th>Nro Factura</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Condición</th>
            <th>Tipo Pago</th>
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
  .facturacion-section .table th,
  .facturacion-section .table td {
    vertical-align: middle;
  }

  .facturacion-section .badge {
    text-transform: uppercase;
    font-size: 0.75rem;
    padding: 0.25em 0.5em;
  }
</style>
