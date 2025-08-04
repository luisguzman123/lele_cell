<?php
session_start();
?>
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 p-5 bg-white">
        <h3 class="mb-4 text-primary fw-bold">NUEVO DIAGNÓSTICO</h3>
        <hr>

        <form id="formDiagnostico" onsubmit="return false;">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label for="fecha" class="form-label fw-semibold text-dark">Fecha <span class="text-danger">*</span></label>
                    <input type="date" id="fecha" class="form-control" required />
                </div>
                <div class="col-md-4">
                    <label for="recepcion_lst" class="form-label fw-semibold text-dark">Recepción <span class="text-danger">*</span></label>
                    <select id="recepcion_lst" class="form-select" required>
                        <option value="0">-- Seleccione una recepción --</option>
                    </select>
                </div>
                <div class="col-md-4">
                 <label for="recepcion_lst" class="form-label fw-semibold text-dark">Técnico <span class="text-danger">*</span></label>
                    <select id="tecnico_lst" class="form-select" required>
                        <option value="0">-- Seleccione un técnico --</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="observaciones" class="form-label fw-semibold text-dark">Observaciones</label>
                    <input type="text" id="observaciones" class="form-control" />
                </div>
                 <div class="col-md-6">
                    <label for="observaciones" class="form-label fw-semibold text-dark">Costo</label>
                    <input type="text" id="costo" class="form-control" value="0" />
                </div>
            </div>

            <div class="row g-3 align-items-end mb-5">
                <div class="col-md-4">
                    <label for="descripcion_prueba" class="form-label fw-semibold text-dark">Descripción de Prueba <span class="text-danger">*</span></label>
                    <input type="text" id="descripcion_prueba" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label for="resultado" class="form-label fw-semibold text-dark">Resultado</label>
                    <input type="text" id="resultado" class="form-control" />
                </div>
                <div class="col-md-2">
                    <label for="obs_detalle" class="form-label fw-semibold text-dark">Observación</label>
                    <input type="text" id="obs_detalle" class="form-control" />
                </div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-primary w-100" onclick="agregarDetalleDiagnostico(); return false;" data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar prueba">
                        <i class="bi bi-plus-circle me-2 fs-5"></i> Agregar
                    </button>
                </div>
            </div>

            <div class="mb-5">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Descripción</th>
                            <th>Resultado</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="detalle_diagnostico_tb" class="table-group-divider text-dark">
                    </tbody>
                </table>
            </div>

            <div class="row g-3">
                <div class="col-md-6 d-grid">
                    <button type="submit" class="btn btn-success btn-lg" onclick="guardarDiagnostico();">
                        <i class="bi bi-save2 me-2 fs-5"></i> Guardar
                    </button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button" class="btn btn-danger btn-lg" onclick="mostrarListarDiagnostico();">
                        <i class="bi bi-x-circle me-2 fs-5"></i> Cancelar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
