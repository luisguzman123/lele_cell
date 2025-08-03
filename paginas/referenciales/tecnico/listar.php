<div class="container-fluid mt-4 p-4 shadow rounded bg-white">
    <div class="row align-items-center mb-3">
        <div class="col-md-8">
            <h2 class="fw-bold text-secondary mb-0">👨‍🔧 Lista de Tecnicos</h2>
        </div>
        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
            <button class="btn btn-primary btn-lg" onclick="mostrarAgregarTecnico(); return false;">
                <i class="bi bi-plus-circle"></i> Agregar Tecnico
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center fs-5">
            <thead class="table-dark text-white">
                <tr>
                    <th style="min-width: 50px;">#</th>
                    <th style="min-width: 150px;">Nombre</th>
                    <th style="min-width: 100px;">Cédula</th>
                    <th style="min-width: 100px;">Teléfono</th>
                    <th style="min-width: 100px;">Estado</th>
                    <th style="min-width: 180px;">Operaciones</th>
                </tr>
            </thead>
            <tbody id="tecnico_tb">
                <!-- Se cargan los tecnicos aquí -->
            </tbody>
        </table>
    </div>
</div>

