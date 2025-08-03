<!--<div class="row pedido-proveedor-section">
  <div class="col-md-9 d-flex align-items-center">
    <h3>Listado Pedido a Proveedor</h3>
  </div>
  <div class="col-md-3">
    <button class="btn btn-success form-control" onclick="mostrarAgregarPedidoProveedor(); return false;">Agregar</button>
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
          <th>Estado</th>
          <th>Operaciones</th>
        </tr>
      </thead>
      <tbody id="pedido_proveedor_tb"></tbody>
    </table>
  </div>
</div>-->
<div class="card mb-4 pedido-proveedor-section">
  <div class="card-body">
    <!-- Cabecera con título y botón -->
    <div class="row align-items-center mb-3">
      <div class="col-md-8">
        <h3 class="text-primary fw-bold">📦 Lista de Pedidos a Proveedor</h3>
      </div>
      <div class="col-md-4 text-end">
        <button class="btn btn-success" onclick="mostrarAgregarPedidoProveedor(); return false;">
          <i class="bi bi-plus-circle me-1"></i> Agregar Nuevo Pedido
        </button>
      </div>
    </div>

    <!-- Filtro/Buscador -->
    <div class="row mb-3">
      <div class="col-md-4 ms-auto">
        <input type="text"
               id="buscar-pedido-proveedor"
               class="form-control"
               placeholder="Buscar Pedido">
      </div>
    </div>

    <!-- Tabla estilo Recepciones -->
    <div class="table-responsive">
      <table class="table table-sm table-bordered table-hover align-middle mb-0">
        <thead class="table-dark text-center">
          <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Proveedor</th>
            <th>Estado</th>
            <th>Operaciones</th>
          </tr>
        </thead>
        <tbody id="pedido_proveedor_tb" class="text-center">
          <!-- Aquí van las filas generadas dinámicamente -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
  /* Asegura que celdas queden centradas verticalmente */
  .pedido-proveedor-section .table th,
  .pedido-proveedor-section .table td {
    vertical-align: middle;
  }
  /* Badges en mayúsculas y tamaño compacto */
  .pedido-proveedor-section .badge {
    text-transform: uppercase;
    font-size: 0.75rem;
    padding: 0.25em 0.5em;
  }
</style>
