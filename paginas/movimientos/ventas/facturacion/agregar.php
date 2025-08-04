<div class="container my-4 nueva-factura-section">
  <div class="card shadow">
    <div class="card-body">
      <h3 class="text-primary fw-bold mb-3"><i class="bi bi-receipt-cutoff me-2"></i>Nueva Factura</h3>
      <hr>

      <!-- Cabecera de factura -->
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Fecha</label>
          <input type="date" class="form-control" id="fecha">
        </div>
        <div class="col-md-3">
          <label class="form-label">Nro de Factura</label>
          <input type="text" class="form-control" id="nro_factura">
        </div>
        <div class="col-md-3">
          <label class="form-label">Timbrado</label>
          <input type="text" class="form-control" id="timbrado">
        </div>
        <div class="col-md-3">
          <label class="form-label">Condición</label>
          <select id="condicion" class="form-select">
            <option value="CONTADO">CONTADO</option>
            <option value="CREDITO">CRÉDITO</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Cliente</label>
          <select id="cliente" class="form-select"></select>
        </div>
        <div class="col-md-6" id="tipo_pago_group">
          <label class="form-label">Tipo de Pago</label>
          <select id="tipo_pago" class="form-select">
            <option value="0">Seleccione</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Tarjeta">Tarjeta</option>
            <option value="Transferencia">Transferencia</option>
          </select>
        </div>
      </div>

      <hr class="my-4">

      <!-- Agregar producto -->
      <div class="row g-3">
        <div class="col-md-5">
          <label class="form-label">Producto</label>
          <select id="producto" class="form-select"></select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Cantidad</label>
          <input type="number" class="form-control" id="cantidad">
        </div>
        <div class="col-md-2">
          <label class="form-label">Precio</label>
          <input type="number" class="form-control" id="precio" readonly>
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <button onclick="agregarProductoFactura(); return false;" class="btn btn-primary w-100">
            <i class="bi bi-plus-circle me-1"></i>Agregar
          </button>
        </div>
      </div>

      <!-- Tabla de productos -->
      <div class="table-responsive mt-4">
        <table class="table table-bordered table-hover align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Descripción</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>EXENTA</th>
              <th>IVA 5%</th>
              <th>IVA 10%</th>
              <th>Operaciones</th>
            </tr>
          </thead>
          <tbody id="datos_tb"></tbody>
          <tfoot class="table-light">
            <tr>
              <th colspan="4" class="text-end">Total</th>
              <th id="t_exenta">0</th>
              <th id="t_iva5">0</th>
              <th id="t_iva10">0</th>
              <th></th>
            </tr>
            <tr>
              <th colspan="2">Total IVA</th>
              <th><span id="iva5">0</span> (5%)</th>
              <th><span id="iva10">0</span> (10%)</th>
              <th colspan="2" id="t_iva">0</th>
              <th colspan="2"></th>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Botones -->
      <div class="row mt-4">
        <div class="col-md-6">
          <button class="btn btn-success w-100" onclick="guardarFactura(); return false;">
            <i class="bi bi-check-circle me-1"></i>Guardar
          </button>
        </div>
        <div class="col-md-6">
          <button class="btn btn-danger w-100">
            <i class="bi bi-x-circle me-1"></i>Cancelar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-plan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Plan de Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Fecha Venc.</label>
                        <input type="date" id="pp-fecha" class="form-control">
                    </div>
                    <div class="col-6">
                        <label>Monto</label>
                        <input type="number" id="pp-monto" class="form-control">
                    </div>
                    <div class="col-12 mt-2">
                        <button class="btn btn-primary" id="pp-agregar">Agregar cuota</button>
                    </div>
                </div>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vencimiento</th>
                            <th>Monto</th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <tbody id="pp-detalle"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="pp-confirmar">Confirmar</button>
            </div>
        </div>
    </div>
</div>

