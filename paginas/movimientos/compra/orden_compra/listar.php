<!--<div class="row orden-compra-section">
  <div class="col-md-9 d-flex align-items-center">
    <h3>Listado Orden de Compra</h3>
  </div>
  <div class="col-md-3">
    <button class="btn btn-success form-control" onclick="mostrarAgregarOrdenCompra(); return false;">Agregar</button>
  </div>
  <div class="col-md-12">
    <hr>
  </div>
  <div class="col-md-12 mt-4">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Fecha</th>
          <th>Proveedor</th>
          <th>Total</th>
          <th>Estado</th>
          <th>Operaciones</th>
        </tr>
      </thead>
      <tbody id="orden_compra_tb"></tbody>
    </table>
  </div>
</div>-->
<div class="card mb-4 orden-compra-section">
  <div class="card-body">
    <!-- Cabecera con diseño de “Lista de Recepciones” -->
    <div class="row align-items-center mb-3">
      <div class="col-md-8">
        <h3 class="text-primary fw-bold">🛒 Lista de Órdenes de Compra</h3>
      </div>
      <div class="col-md-4 text-end">
        <button class="btn btn-success" onclick="mostrarAgregarOrdenCompra(); return false;">
          <i class="bi bi-plus-circle me-1"></i> Agregar Nueva Orden
        </button>
      </div>
    </div>

    <!-- Buscador alineado a la derecha -->
    <div class="row mb-3">
      <div class="col-md-4 ms-auto">
        <input type="text"
               id="buscar-orden-compra"
               class="form-control"
               placeholder="Buscar Orden de Compra">
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
        <tbody id="orden_compra_tb" class="text-center">
          <!-- Aquí van las filas generadas dinámicamente -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
  /* Centrar verticalmente celdas */
  .orden-compra-section .table th,
  .orden-compra-section .table td {
    vertical-align: middle;
  }
  /* Badges compactos y uppercase */
  .orden-compra-section .badge {
    text-transform: uppercase;
    font-size: 0.75rem;
    padding: 0.25em 0.5em;
  }
</style>
