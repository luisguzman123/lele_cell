<div class="container mt-5">
  <div class="card shadow-lg rounded-4 p-5 bg-white">
    <h3 class="mb-4 text-primary fw-bold">NUEVO SERVICIO</h3>
    <hr>
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <label for="fecha_inicio" class="form-label fw-semibold text-dark">Fecha Inicio <span class="text-danger">*</span></label>
        <input type="date" id="fecha_inicio" class="form-control" required />
      </div>
      <div class="col-md-6">
        <label for="fecha_fin" class="form-label fw-semibold text-dark">Fecha Fin <span class="text-danger">*</span></label>
        <input type="date" id="fecha_fin" class="form-control" required />
      </div>
      <div class="col-md-6">
        <label for="presupuesto_lst" class="form-label fw-semibold text-dark">Presupuesto <span class="text-danger">*</span></label>
        <select id="presupuesto_lst" class="form-select" required>
          <option value="0">-- Seleccione un presupuesto --</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="tecnico_lst" class="form-label fw-semibold text-dark">Técnico <span class="text-danger">*</span></label>
        <select id="tecnico_lst" class="form-select" required>
          <option value="0">-- Seleccione un técnico --</option>
        </select>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-md-12">
        <label for="observaciones" class="form-label fw-semibold text-dark">Observaciones</label>
        <input type="text" id="observaciones" class="form-control" />
      </div>
    </div>

    <hr class="mb-4">

    <div class="row g-3 align-items-end mb-5">
      <div class="col-md-6">
        <label for="tarea" class="form-label fw-semibold text-dark">Tarea <span class="text-danger">*</span></label>
        <input type="text" id="tarea" class="form-control" />
      </div>
      <div class="col-md-2">
        <label for="horas" class="form-label fw-semibold text-dark">Horas <span class="text-danger">*</span></label>
        <input type="number" id="horas" class="form-control" value="0" min="0" step="0.5" />
      </div>
      <div class="col-md-3">
        <label for="obs_detalle" class="form-label fw-semibold text-dark">Observaciones</label>
        <input type="text" id="obs_detalle" class="form-control" />
      </div>
      <div class="col-md-1 text-center">
        <button type="button" class="btn btn-primary w-100" onclick="agregarDetalleServicio(); return false;">
          <i class="bi bi-plus-circle me-2 fs-5"></i>
        </button>
      </div>
    </div>

    <div class="mb-5">
      <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>Tarea</th>
            <th>Horas</th>
            <th>Obs.</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="detalle_servicio_tb" class="table-group-divider text-dark"></tbody>
      </table>
    </div>

    <div class="row g-3">
      <div class="col-md-6 d-grid">
        <button type="button" class="btn btn-success btn-lg" onclick="guardarServicio();">
          <i class="bi bi-save2 me-2 fs-5"></i> Confirmar
        </button>
      </div>
      <div class="col-md-6 d-grid">
        <button type="button" class="btn btn-danger btn-lg" onclick="mostrarListarServicio();">
          <i class="bi bi-x-circle me-2 fs-5"></i> Cancelar
        </button>
      </div>
    </div>
  </div>
</div>
