<div class="container mt-5">
  <div class="card shadow-lg rounded-4 p-5 bg-white">
    <h3 class="mb-4 text-primary fw-bold">NUEVO PRESUPUESTO DE SERVICIO</h3>
    <hr>
    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <label for="fecha" class="form-label fw-semibold text-dark">Fecha <span class="text-danger">*</span></label>
        <input type="date" id="fecha" class="form-control" required />
      </div>
      <div class="col-md-4">
        <label for="diagnostico_lst" class="form-label fw-semibold text-dark">Diagnóstico <span class="text-danger">*</span></label>
        <select id="diagnostico_lst" class="form-select" required>
          <option value="0">-- Seleccione un diagnóstico --</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="validez" class="form-label fw-semibold text-dark">Validez (días)</label>
        <input type="number" id="validez" class="form-control" value="7" />
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
        <label for="concepto" class="form-label fw-semibold text-dark">Concepto <span class="text-danger">*</span></label>
        <input type="text" id="concepto" class="form-control" />
      </div>
      <div class="col-md-2">
        <label for="cantidad" class="form-label fw-semibold text-dark">Cantidad <span class="text-danger">*</span></label>
        <input type="number" id="cantidad" class="form-control" value="1" min="1" />
      </div>
      <div class="col-md-2">
        <label for="precio_unitario" class="form-label fw-semibold text-dark">Precio <span class="text-danger">*</span></label>
        <input type="number" id="precio_unitario" class="form-control" value="0" min="0" />
      </div>
      <div class="col-md-2 text-center">
        <button type="button" class="btn btn-primary w-100" onclick="agregarDetallePresupuestoServicio(); return false;">
          <i class="bi bi-plus-circle me-2 fs-5"></i> Agregar
        </button>
      </div>
    </div>

    <div class="mb-5">
      <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>Concepto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="detalle_presupuesto_servicio_tb" class="table-group-divider text-dark"></tbody>
      </table>
    </div>

    <div class="row mb-4">
      <div class="col-md-12 text-end">
        <h5>Total: <span id="total_presupuesto_servicio">0</span></h5>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-md-6 d-grid">
        <button type="button" class="btn btn-success btn-lg" onclick="guardarPresupuestoServicio();">
          <i class="bi bi-save2 me-2 fs-5"></i> Confirmar
        </button>
      </div>
      <div class="col-md-6 d-grid">
        <button type="button" class="btn btn-danger btn-lg" onclick="mostrarListarPresupuestoServicio();">
          <i class="bi bi-x-circle me-2 fs-5"></i> Cancelar
        </button>
      </div>
    </div>
  </div>
</div>
