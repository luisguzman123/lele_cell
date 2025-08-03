<div class="card mb-4 compra-section">
  <div class="card-body">
    <!-- Cabecera con diseño “Lista de Recepciones” -->
    <div class="row align-items-center mb-3">
      <div class="col-md-8">
        <h3 class="text-primary fw-bold">🛍️ Registro de Compras</h3>
      </div>
      <div class="col-md-4 text-end">
        <button class="btn btn-success" onclick="mostrarAgregarCompra(); return false;">
          <i class="bi bi-plus-circle me-1"></i> Agregar Nueva Compra
        </button>
      </div>
    </div>

    <!-- Buscador alineado a la derecha -->
    <div class="row mb-3">
      <div class="col-md-4 ms-auto">
        <input type="text"
               id="buscar-compra"
               class="form-control"
               placeholder="Buscar Compra">
      </div>
    </div>

    <!-- Tabla con estilo table-dark y centrado -->
    <div class="table-responsive">
      <table class="table table-sm table-bordered table-hover align-middle mb-0">
        <thead class="table-dark text-center">
          <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Proveedor</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Operaciones</th>
          </tr>
        </thead>
        <tbody id="compra_tb" class="text-center">
          <!-- Aquí se insertan dinámicamente las filas -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
  /* Asegura que celdas queden centradas verticalmente */
  .compra-section .table th,
  .compra-section .table td {
    vertical-align: middle;
  }
  /* Badges compactos y uppercase */
  .compra-section .badge {
    text-transform: uppercase;
    font-size: 0.75rem;
    padding: 0.25em 0.5em;
  }
</style>
