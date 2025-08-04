<div class="container mt-4 p-4 shadow rounded bg-light" style="max-width: 700px;">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Apertura / Cierre de Caja</h2>
        <hr>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label for="caja" class="form-label fs-5">Caja</label>
            <select id="caja" class="form-select">
                <option value="1">Caja 1</option>
                <option value="2">Caja 2</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="monto_apertura" class="form-label fs-5">Monto de Apertura</label>
            <input type="text" id="monto_apertura" class="form-control" value="0" onkeyup="format(this);" />
        </div>
        <div class="col-md-4">
            <label for="efectivo" class="form-label fs-5">Efectivo</label>
            <input type="text" id="efectivo" class="form-control" value="0" onkeyup="format(this);" />
        </div>
        <div class="col-md-4">
            <label for="tarjeta" class="form-label fs-5">Tarjeta</label>
            <input type="text" id="tarjeta" class="form-control" value="0" onkeyup="format(this);" />
        </div>
        <div class="col-md-4">
            <label for="transferencia" class="form-label fs-5">Transferencia</label>
            <input type="text" id="transferencia" class="form-control" value="0" onkeyup="format(this);" />
        </div>
        <div class="col-md-12">
            <label for="total_general" class="form-label fs-5">Total General</label>
            <input type="text" id="total_general" class="form-control" readonly />
        </div>
    </div>

    <div class="row mt-4 g-3">
        <div class="col-md-4">
            <button class="btn btn-success w-100" onclick="abrirCaja();">Abrir Caja</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-danger w-100" onclick="cerrarCaja();">Cerrar Caja</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-secondary w-100" onclick="generarArqueoCaja();">Arqueo de Caja</button>
        </div>
    </div>
</div>
