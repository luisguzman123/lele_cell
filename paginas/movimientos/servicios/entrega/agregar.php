<div class="container mt-5">
  <div class="card shadow-lg rounded-4 p-5 bg-white">
    <h3 class="mb-4 text-primary fw-bold">NUEVA ENTREGA</h3>
    <hr>
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <label for="servicio_lst" class="form-label fw-semibold text-dark">Servicio <span class="text-danger">*</span></label>
        <select id="servicio_lst" class="form-select" required>
          <option value="0">-- Seleccione un servicio --</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="fecha_entrega" class="form-label fw-semibold text-dark">Fecha Entrega <span class="text-danger">*</span></label>
        <input type="date" id="fecha_entrega" class="form-control" required />
      </div>
      <div class="col-md-12">
        <label for="firmado_por" class="form-label fw-semibold text-dark">Firmado por</label>
        <input type="text" id="firmado_por" class="form-control" />
      </div>
    </div>
    <div class="row g-3">
      <div class="col-md-6 d-grid">
        <button type="button" class="btn btn-success btn-lg" onclick="guardarEntrega();">
          <i class="bi bi-save2 me-2 fs-5"></i> Confirmar
        </button>
      </div>
      <div class="col-md-6 d-grid">
        <button type="button" class="btn btn-danger btn-lg" onclick="mostrarListarEntrega();">
          <i class="bi bi-x-circle me-2 fs-5"></i> Cancelar
        </button>
      </div>
    </div>
  </div>
</div>
