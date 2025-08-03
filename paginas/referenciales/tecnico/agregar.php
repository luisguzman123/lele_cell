<?php session_start(); ?>
<div class="container mt-4 p-4 shadow rounded bg-light" style="max-width: 950px;">
    <input type="hidden" id="id_tecnico" value="0">

    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Nuevo Tecnico</h2>
        <hr>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label for="nombre_tecnico" class="form-label fs-5">Nombre</label>
            <input type="text" id="nombre_tecnico" class="form-control form-control-lg" placeholder="Ingrese el nombre">
        </div>
        <div class="col-md-6">
            <label for="cedula" class="form-label fs-5">Cédula</label>
            <input type="text" id="cedula" class="form-control form-control-lg" placeholder="Ingrese la cédula">
        </div>
        <div class="col-md-6">
            <label for="telefono" class="form-label fs-5">Teléfono</label>
            <input type="text" id="telefono" class="form-control form-control-lg" placeholder="Ingrese el teléfono">
        </div>
        <div class="col-md-6">
            <label for="estado" class="form-label fs-5">Estado</label>
            <select id="estado" class="form-select form-select-lg">
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
            </select>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <button class="btn btn-success btn-lg w-100" onclick="guardarTecnico();">
                <i class="bi bi-check-circle"></i> Guardar
            </button>
        </div>
        <div class="col-md-6">
            <button class="btn btn-outline-danger btn-lg w-100" onclick="mostrarListarTecnico();">
                <i class="bi bi-x-circle"></i> Cancelar
            </button>
        </div>
    </div>
</div>

