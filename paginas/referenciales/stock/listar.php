<div class="card mb-4 stock-section">
  <div class="card-body">
    <!-- Cabecera -->
    <div class="row align-items-center mb-3">
      <div class="col-md-8">
        <h3 class="text-primary fw-bold">📦 Stock de Productos</h3>
      </div>
      <div class="col-md-4 text-end">
        <!-- Botón opcional, podés agregar algo útil acá -->
        <!-- <button class="btn btn-success"><i class="bi bi-plus-circle me-1"></i> Agregar Producto</button> -->
      </div>
    </div>

    <!-- Buscador alineado a la derecha -->
    <div class="row mb-3">
      <div class="col-md-4 ms-auto">
        <input type="text" id="buscar-stock" class="form-control" placeholder="Buscar producto">
      </div>
    </div>

    <!-- Tabla de stock -->
    <div class="table-responsive">
      <table class="table table-sm table-bordered table-hover align-middle mb-0" id="tabla_stock">
        <thead class="table-dark text-center">
          <tr>
            <th>#</th>
            <th>Descripción</th>
            <th>Stock</th>
          </tr>
        </thead>
        <tbody id="stock_tb"></tbody>
      </table>
    </div>
  </div>
</div>

<!-- Estilos compartidos -->
<style>
  .stock-section .table th,
  .stock-section .table td {
    vertical-align: middle;
  }

  .stock-section .badge {
    text-transform: uppercase;
    font-size: 0.75rem;
    padding: 0.25em 0.5em;
  }
</style>
