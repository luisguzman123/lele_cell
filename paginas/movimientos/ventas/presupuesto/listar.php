<div class="row">
    <div class="col-12">
        <h4>PRESUPUESTO</h4>
    </div>
    <div class="col-12">
        <hr>
    </div>
    <div class="col-md-4">
        <button onclick="mostrarNuevoPresupuestoVenta(); return false;" class="btn btn-primary">Nuevo Presupuesto</button>
    </div>
    <div class="col-12">
        <hr>
    </div>
    <div class="col-3">
        <label>Desde</label>
        <input type="date" class="form-control" id="desde">
    </div>
    <div class="col-3">
        <label>Hasta</label>
        <input type="date" class="form-control" id="hasta">
    </div>
    <div class="col-3" style="margin-top: 25px;">
        <button class="btn btn-secondary form-control">Buscar</button>
    </div>
    <div class="col-3">
        <label>Nro Presupuesto</label>
        <input type="text" class="form-control" id="nro_presupuesto_busqueda">
    </div>

    <div class="col-12 mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nro Presupuesto</th>
                    <th>Emisión</th>
                    <th>Vencimiento</th>
                    <th>Cliente</th>
                    <th>Condición</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody id="datos_tb"></tbody>
        </table>
    </div>
</div>
