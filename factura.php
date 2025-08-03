<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Facturacion</title>
        <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
        <script src="jquery-3.7.1.min.js"></script>
        <script src="vistas/util.js"></script>
        <script src="vistas/cliente.js"></script>
        <script src="vistas/productos.js"></script>
        <script src="vistas/factura.js"></script>

    </head>
    <body style="padding: 40px;">

        <script>
            window.onload = function (evt) {
                cargarTablaFacturas();
            }
        </script>
        <div class="row">
            <div class="col-12">
                <h4>FACTURACION</h4>
            </div>
            <div class="col-12">
                <hr> 
            </div>
            <div class="col-md-4">
                <button onclick="mostrarNuevaFactura(); return false;" class="btn btn-primary">Nueva Factura</button>
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
                <label>Nro Factura</label>
                <input type="text" class="form-control" id="nro_factura_busqueda">
            </div>

            <div class="col-12 mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nro factura</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Condicion</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <tbody id="datos_tb"></tbody>
                </table>
            </div>
        </div>
    </body>
</html>

