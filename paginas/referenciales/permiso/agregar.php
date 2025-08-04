<?php session_start(); ?>
<div class="container mt-4 p-4 shadow rounded bg-light" style="max-width: 600px;">
    <input type="hidden" id="id_permiso" value="0">

    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Nuevo Permiso</h2>
        <hr>
    </div>

    <div class="row g-3">
        <div class="col-md-12">
            <label for="descripcion" class="form-label fs-5">Descripción</label>
            <input type="text" id="descripcion" class="form-control form-control-lg" placeholder="Ingrese la descripción">
        </div>
        <div class="col-md-12">
            <label for="estado" class="form-label fs-5">Estado</label>
            <select id="estado" class="form-select form-select-lg">
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
            </select>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <button class="btn btn-success btn-lg w-100" onclick="guardarPermiso();">
                <i class="bi bi-check-circle"></i> Guardar
            </button>
        </div>
        <div class="col-md-6">
            <button class="btn btn-outline-danger btn-lg w-100" onclick="mostrarListarPermiso();">
                <i class="bi bi-x-circle"></i> Cancelar
            </button>
        </div>
    </div>
</div>

