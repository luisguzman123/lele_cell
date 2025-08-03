<div class="container mt-5">
  <div class="card shadow-lg rounded-4 p-5 bg-white">
    <h3 class="mb-4 text-primary fw-bold">NUEVO PRESUPUESTO</h3>
    <hr>

    <!--<form id="formPresupuesto" onsubmit="return false;">-->
      <!-- Fecha, Observación y Proveedor -->
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <label for="fecha" class="form-label fw-semibold text-dark">
            Fecha <span class="text-danger">*</span>
          </label>
          <input type="date" id="fecha" class="form-control" required />
        </div>
        <div class="col-md-4">
          <label for="observacion" class="form-label fw-semibold text-dark">
            Observación
          </label>
          <input type="text" id="observacion" class="form-control" placeholder="Comentarios adicionales" />
        </div>
        <div class="col-md-4">
          <label for="proveedor" class="form-label fw-semibold text-dark">
            Proveedor <span class="text-danger">*</span>
          </label>
          <select id="proveedor" class="form-select" required>
            <option value="">-- Seleccione un proveedor --</option>
            <!-- Opciones dinámicas -->
          </select>
        </div>
      </div>

      <!-- Pedido -->
      <div class="row g-4 mb-5">
        <div class="col-md-12">
          <label for="pedido_lst" class="form-label fw-semibold text-dark">
            Pedido
          </label>
          <select id="pedido_lst" class="form-select">
            <option value="">-- Seleccione un pedido --</option>
            <!-- Opciones dinámicas -->
          </select>
        </div>
      </div>

      <hr class="mb-4">

      <!-- Producto, Cantidad, Precio y Agregar -->
      <div class="row g-3 align-items-end mb-5">
        <div class="col-md-5">
          <label for="producto_lst" class="form-label fw-semibold text-dark">
            Producto <span class="text-danger">*</span>
          </label>
          <select id="producto_lst" class="form-select" required>
            <option value="">-- Seleccione un producto --</option>
            <!-- Opciones dinámicas -->
          </select>
        </div>
        <div class="col-md-2">
          <label for="cantidad" class="form-label fw-semibold text-dark">
            Cantidad <span class="text-danger">*</span>
          </label>
          <input type="number" id="cantidad" class="form-control" min="1" placeholder="0" required />
        </div>
        <div class="col-md-3">
          <label for="precio" class="form-label fw-semibold text-dark">
            Precio <span class="text-danger">*</span>
          </label>
          <input type="text" id="precio" class="form-control" min="0" step="0.01" required />
        </div>
        <div class="col-md-2 text-center">
          <button
            type="button"
            class="btn btn-primary w-100 d-flex align-items-center justify-content-center"
            onclick="agregarProductoPresupuesto(); return false;"
            title="Agregar producto al presupuesto">
            <i class="bi bi-plus-circle me-2 fs-5"></i> Agregar
          </button>
        </div>
      </div>

      <!-- Tabla de detalle -->
      <div class="mb-5">
        <table class="table table-bordered table-hover align-middle text-center mb-0">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Subtotal</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="detalle_tb" class="table-group-divider text-dark">
            <!-- Filas dinámicas -->
          </tbody>
        </table>
      </div>

      <!-- Total -->
      <div class="row mb-4">
        <div class="col-md-12 text-end">
          <h5>Total: <span id="total_presupuesto">0</span></h5>
        </div>
      </div>

      <!-- Botones Confirmar / Cancelar -->
      <div class="row g-3">
        <div class="col-md-6 d-grid">
          <button
            type="submit"
            class="btn btn-success btn-lg d-flex align-items-center justify-content-center"
            onclick="guardarPresupuesto();">
            <i class="bi bi-save2 me-2 fs-5"></i> Confirmar
          </button>
        </div>
        <div class="col-md-6 d-grid">
          <button
            type="button"
            class="btn btn-danger btn-lg d-flex align-items-center justify-content-center"
            onclick="mostrarListaPresupuesto();">
            <i class="bi bi-x-circle me-2 fs-5"></i> Cancelar
          </button>
        </div>
      </div>
    <!--</form>-->
  </div>
</div>
