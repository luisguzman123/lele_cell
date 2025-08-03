<div class="container mt-5">
    <div class="card shadow-lg rounded-4 p-4 bg-light">
        <!-- Encabezado -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary m-0">
                <i class="bi bi-clipboard-data me-2"></i>Listado de Equipos
            </h2>
            <button class="btn btn-primary btn-lg" onclick="mostrarAgregarEquipo(); return false;">
                <i class="bi bi-plus-circle me-2"></i>Agregar Equipo
            </button>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Operaciones</th>
                    </tr>
                </thead>
                <tbody id="equipo_tb" class="table-group-divider text-dark"></tbody>
            </table>
        </div>
    </div>
</div>
