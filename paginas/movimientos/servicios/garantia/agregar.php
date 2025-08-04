<div class="container mt-5">
  <div class="card shadow-lg rounded-4 p-5 bg-white">
    <h3 class="mb-4 text-primary fw-bold">NUEVA GARANTÍA DE SERVICIO</h3>
    <hr>
    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <label for="servicio_lst" class="form-label fw-semibold text-dark">Servicio <span class="text-danger">*</span></label>
        <select id="servicio_lst" class="form-select" required>
          <option value="0">-- Seleccione un servicio --</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="fecha_inicio" class="form-label fw-semibold text-dark">Fecha Inicio <span class="text-danger">*</span></label>
        <input type="date" id="fecha_inicio" class="form-control" required />
      </div>
      <div class="col-md-4">
        <label for="duracion" class="form-label fw-semibold text-dark">Duración (días)</label>
        <input type="number" id="duracion" class="form-control" value="30" />
      </div>
    </div>
    <div class="row g-3">
      <div class="col-md-6 d-grid">
        <button type="button" class="btn btn-success btn-lg" onclick="guardarGarantia();">
          <i class="bi bi-save2 me-2 fs-5"></i> Confirmar
        </button>
      </div>
      <div class="col-md-6 d-grid">
        <button type="button" class="btn btn-danger btn-lg" onclick="mostrarListarGarantia();">
          <i class="bi bi-x-circle me-2 fs-5"></i> Cancelar
        </button>
      </div>
    </div>
  </div>
</div>
