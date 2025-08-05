<div class="card mb-4 ajuste-stock-section">
  <div class="card-body">
    <!-- Cabecera -->
    <div class="row align-items-center mb-3">
      <div class="col-md-8">
        <h3 class="text-primary fw-bold">📦 Ajuste de Stock</h3>
      </div>
      <div class="col-md-4 text-end">
        <button class="btn btn-success" onclick="mostrarAgregarEntradaSalida(); return false;">
          <i class="bi bi-plus-circle me-1"></i> Agregar Ajuste
        </button>
      </div>
    </div>

    <!-- Buscador (opcional) -->
    <div class="row mb-3">
      <div class="col-md-4 ms-auto">
        <input type="text" id="buscar-ajuste" class="form-control" placeholder="Buscar ajuste">
      </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-sm table-bordered table-hover align-middle mb-0">
        <thead class="table-dark text-center">
          <tr>
            <th style="width: 5%;">#</th>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Observaciones</th>
            <th>Estado</th>
            <th class="text-end" style="width: 15%;">Operaciones</th>
          </tr>
        </thead>
        <tbody id="entrada_salida_tb" class="text-center">
          <!-- Filas dinámicas -->
        </tbody>
      </table>
    </div>
  </div>
</div>
