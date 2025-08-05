<!--<div class="row">

    <div class="col-md-12">
        <h3>Agregar Pedido</h3>
    </div>
    <div class="col-md-12">
        <hr> 
    </div>

    <div class="col-md-4">
        <label for="">Fecha de Entrada</label>
        <input type="date" id="fecha_entrada" class="form-control">
    </div>

    <div class="col-md-4">
        <label for="doc_ref">Documento de Referencia</label>
        <select id="doc_ref" class="form-control">
            <option value="0">TIPO</option>
            <option value="Entrada">Entrada</option>
            <option value="Salida">Salida</option>
        </select>
    </div>

    <div class="col-md-4">
        <label for="">Observacion</label>
        <input type="text" id="observacion" class="form-control">
    </div>
    
    <div class="col-md-4">
        <label for="">Proveedor</label>
        <select name="proveedor" id="proveedor" class="form-control"></select>
        <input type="text" id="proveedor" class="form-control">
    </div>
    <div class="col-md-6">
        <label for="">Ususario Registro</label>
        <input type="text" id="usu_reg" class="form-control" value="IVAN JAVIER">
    </div>



    <div class="col-md-12">
        <hr> 
    </div>
    <div class="col-md-6">
        <label>Producto</label>
        <select  id="producto_lst" class="form-control">

        </select>
    </div>
    <div class="col-md-3">
        <label>Cantidad</label>
        <input type="number" id="cantidad" class="form-control">
    </div>
    <div class="col-md-3">
        <label>Operaciones</label>
        <button class="btn btn-primary form-control" onclick="agregarTablaEntradaSalida(); return false;">Agregar</button>
    </div>

    <div class="col-md-12" style="margin-top: 30px;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>PRODUCTO</th>
                    <th>CANTIDAD</th>
                    <th>OPERACIONES</th>
                </tr>
            </thead>
            <tbody id="pedido_tb"></tbody>
        </table>
    </div>

    <div class="col-md-12">
        <hr> 
    </div>
    <div class="col-md-6">
        <button class="btn btn-success form-control" onclick="guardarEntradaSalida(); return false;">Confirmar</button>
    </div>
    <div class="col-md-6">
        <button class="btn btn-danger form-control" onclick="cancelarPedidoCompra();">Cancelar</button>
    </div>

</div>-->

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-11 col-lg-10">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-dark text-white">
          <h5 class="mb-0">Agregar Entrada / Salida</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="fecha_entrada" class="form-label">Fecha de Entrada</label>
              <input type="date" id="fecha_entrada" class="form-control">
            </div>

            <div class="col-md-6">
              <label for="doc_ref" class="form-label">Documento de Referencia</label>
              <select id="doc_ref" class="form-select">
                <option value="0">Seleccionar tipo</option>
                <option value="Entrada">Entrada</option>
                <option value="Salida">Salida</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="observacion" class="form-label">Observación</label>
              <input type="text" id="observacion" class="form-control" placeholder="Ej: Compra semanal">
            </div>

<!--            <div class="col-md-6">
              <label for="proveedor" class="form-label">Proveedor</label>
              <select name="proveedor" id="proveedor" class="form-select">
                 Opciones cargadas dinámicamente 
              </select>
            </div>-->

            <div class="col-md-6">
              <label for="usu_reg" class="form-label">Usuario Registro</label>
              <input type="text" id="usu_reg" class="form-control" value="LEANDRO" readonly>
            </div>

            <hr class="my-4">

            <div class="col-md-6">
              <label for="producto_lst" class="form-label">Producto</label>
              <select id="producto_lst" class="form-select">
                <!-- Opciones cargadas dinámicamente -->
              </select>
            </div>

            <div class="col-md-3">
              <label for="cantidad" class="form-label">Cantidad</label>
              <input type="number" id="cantidad" class="form-control" min="1" placeholder="Ej: 10">
            </div>

            <div class="col-md-3 d-flex align-items-end">
              <button class="btn btn-primary w-100" onclick="agregarTablaEntradaSalida(); return false;">
                Agregar
              </button>
            </div>

            <div class="col-md-12 mt-4">
              <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Operaciones</th>
                    </tr>
                  </thead>
                  <tbody id="pedido_tb"></tbody>
                </table>
              </div>
            </div>

            <div class="col-md-12 mt-4 d-flex justify-content-between">
              <button class="btn btn-success w-50 me-2" onclick="guardarEntradaSalida(); return false;">
                Confirmar
              </button>
              <button class="btn btn-danger w-50" onclick="cancelarPedidoCompra();">
                Cancelar
              </button>
            </div>
          </div> <!-- end row -->
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div>
  </div>
</div>
