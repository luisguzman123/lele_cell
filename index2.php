<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sistema</title>
        <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
        <script src="jquery-3.7.1.min.js"> </script>
        <script src="persona.js"></script>
    </head>
    <body>
        <div class="row">
            <div class="col-6">
                <label>Nombre</label>
                <input type="text" id="nombre" class="form-control">
            </div>
            <div class="col-6">
                <label>Apellido</label>
                <input type="text" id="apellido" class="form-control">
            </div>
            <div class="col-6">
                <label>Fecha de nacimiento</label>
                <input type="date" id="fecha" class="form-control">
            </div>
            <div class="col-6">
                <label>Color favorito</label>
                <input type="color" id="color" class="form-control">
            </div>
            <div class="col-6" style="margin-top: 40px;">
                <button onclick="guardar(); return false;" class="btn btn-success form-control">Guardar</button>
            </div>
            <div class="col-6" style="margin-top: 40px;">
                <button class="btn btn-danger form-control">Cancelar</button>
            </div>
            
            <div class="col-12 mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha Nac</th>
                            <th>Color</th>
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
