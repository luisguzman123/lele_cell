<div class="container mt-5">
    <div class="card shadow-lg rounded-4 p-4">
        <!-- Encabezado -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-primary mb-0">
                    <i class="bi bi-box-arrow-in-down me-2"></i>Ingresos de Equipos
                </h2>
                <p class="text-muted mb-0">Listado de todos los equipos ingresados con sus respectivos clientes</p>
            </div>
            <button class="btn btn-primary btn-lg" onclick="mostrarAgregarClienteEquipo(); return false;">
                <i class="bi bi-plus-circle me-2"></i>Agregar Ingreso
            </button>
        </div>

        <hr>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Equipo</th>
                        <th>Tipo de bloqueo</th>
                        <th>Estado</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody id="cliente_equipo_tb" class="table-group-divider">
                    <!-- Datos cargados dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>
</div>
