<?php
session_start();
?>
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 p-5 bg-white">
        <h3 class="mb-4 text-primary fw-bold">NUEVA RECEPCIÓN</h3>
        <hr>

        <form id="formRecepcion" onsubmit="return false;">
            <div class="row g-4 mb-4">
                <!-- Fecha -->
                <div class="col-md-4">
                    <label for="fecha" class="form-label fw-semibold text-dark">Fecha <span class="text-danger">*</span></label>
                    <input type="date" id="fecha" class="form-control" required aria-describedby="fechaHelp" />
                    <div id="fechaHelp" class="form-text text-muted">Selecciona la fecha de recepción</div>
                </div>

                <!-- Cliente -->
                <div class="col-md-4">
                    <label for="cliente_lst" class="form-label fw-semibold text-dark">Cliente <span class="text-danger">*</span></label>
                    <select id="cliente_lst" name="cliente" class="form-select" required aria-describedby="clienteHelp">
                        <option value="">-- Seleccione un cliente --</option>
                        <!-- Opciones cargadas dinámicamente -->
                    </select>
                    <div id="clienteHelp" class="form-text text-muted">El cliente al que pertenece el equipo</div>
                </div>

                <!-- Equipo -->
                <div class="col-md-4">
                    <label for="equipo_lst" class="form-label fw-semibold text-dark">Equipo <span class="text-danger">*</span></label>
                    <select id="equipo_lst" name="equipo" class="form-select" required aria-describedby="equipoHelp">
                        <option value="">-- Seleccione un equipo --</option>
                        <!-- Opciones cargadas dinámicamente -->
                    </select>
                    <div id="equipoHelp" class="form-text text-muted">El equipo que será recepcionado</div>
                </div>
            </div>

            <!-- Problema, Observación y Botón agregar alineados verticalmente -->
            <div class="row g-3 align-items-end mb-5">
                <!-- Problema -->
                <div class="col-md-6">
                    <label for="problema_lst" class="form-label fw-semibold text-dark">Problema <span class="text-danger">*</span></label>
                    <input type="text" id="problema_lst" class="form-control" placeholder="Describe el problema detectado" required aria-describedby="problemaHelp" />
                    <!--<div id="problemaHelp" class="form-text text-muted">Ej: Pantalla rota, no enciende, etc.</div>-->
                </div>

                <!-- Observación -->
                <div class="col-md-4">
                    <label for="obs" class="form-label fw-semibold text-dark">Observación</label>
                    <input type="text" id="obs" class="form-control" placeholder="Detalles adicionales o comentarios" />
                </div>

                <!-- Botón agregar -->
                <div class="col-md-2 text-center">
                    <button 
                        type="button" 
                        class="btn btn-primary w-100 d-flex align-items-center justify-content-center" 
                        onclick="agregarTablaDetalleProblema(); return false;" 
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar problema a la lista">
                        <i class="bi bi-plus-circle me-2 fs-5"></i> Agregar
                    </button>
                </div>
            </div>

            <!-- Tabla de problemas -->
            <div class="mb-5">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Problema</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="detalle_recepcion_tb" class="table-group-divider text-dark">
                        <!-- Filas agregadas dinámicamente -->
                    </tbody>
                </table>
            </div>

            <!-- Botones Guardar y Cancelar -->
            <div class="row g-3">
                <div class="col-md-6 d-grid">
                    <button type="submit" class="btn btn-success btn-lg d-flex align-items-center justify-content-center" onclick="guardarRecepcion();">
                        <i class="bi bi-save2 me-2 fs-5"></i> Guardar
                    </button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button" class="btn btn-danger btn-lg d-flex align-items-center justify-content-center" onclick="mostrarListarRecepcion();">
                        <i class="bi bi-x-circle me-2 fs-5"></i> Cancelar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Inicializar tooltips de Bootstrap 5
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
