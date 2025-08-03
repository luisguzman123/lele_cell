<div class="row" style="padding: 40px;">
    <div class="col-12">
        <h3>Nueva factura</h3>
    </div>
    <div class="col-12">
        <hr> 
    </div>
    <div class="col-3">
        <label>Fecha</label>
        <input type="date" class="form-control" id="fecha">
    </div>
    <div class="col-3">
        <label>Nro de factura</label>
        <input type="text" class="form-control" id="nro_factura">
    </div>
    <div class="col-3">
        <label>Timbrado</label>
        <input type="text" class="form-control" id="timbrado">
    </div>
    <div class="col-3">
        <label>Condicion</label>
        <select  id="condicion" class="form-control">
            <option value="CONTADO">CONTADO</option>
            <option value="CREDITO">CREDITO</option>
        </select>
    </div>
    <div class="col-12">
        <label>Cliente</label>
        <select  id="cliente" class="form-control">

        </select>
    </div>
    <div class="col-12">
        <hr> 
    </div>
    <div class="col-5">
        <label>Producto</label>
        <select  id="producto" class="form-control">

        </select>
    </div>
    <div class="col-2">
        <label>Cantidad</label>
        <input type="number"   class="form-control" id="cantidad">
    </div>
    <div class="col-2">
        <label>Precio</label>
        <input type="number" readonly class="form-control" id="precio">
    </div>
    <div class="col-3" style="margin-top: 25px;">
        <button onclick="agregarProductoFactura(); return false;" class="btn btn-primary form-control">Agregar</button>
    </div>
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>EXENTA</th>
                    <th>I.V.A. 5%</th>
                    <th>I.V.A. 10%</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody id="datos_tb"></tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total</th>
                    <th id="t_exenta">0</th>
                    <th id="t_iva5">0</th>
                    <th id="t_iva10">0</th>
                </tr>
                <tr>
                    <th>Total de I.V.A.</th>
                    <th><span id="iva5">0</span> (I.V.A 5%)</th>
                    <th><span id="iva10">0</span> (I.V.A 10%)</th>
                    <th id="t_iva">0</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-6">
        <button class="btn btn-success form-control" onclick="guardarFactura(); return false;">Guardar</button>
    </div>
    <div class="col-6">
        <button class="btn btn-danger form-control">Cancelar</button>
    </div>
</div>

