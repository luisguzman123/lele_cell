<?php session_start(); ?>
<div class="container mt-4 p-4 shadow rounded bg-light" style="max-width: 600px;">
    <input type="hidden" id="id_usuario" value="0">

    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Nuevo Usuario</h2>
        <hr>
    </div>

    <div class="row g-3">
        <div class="col-md-12">
            <label for="usuario" class="form-label fs-5">Usuario</label>
            <input type="text" id="usuario" class="form-control form-control-lg" placeholder="Ingrese el usuario">
        </div>
        <div class="col-md-12">
            <label for="password" class="form-label fs-5">Contraseña</label>
            <input type="password" id="password" class="form-control form-control-lg" placeholder="Ingrese la contraseña">
        </div>
        <div class="col-md-12">
            <label for="cargo_id" class="form-label fs-5">Cargo</label>
            <select id="cargo_id" class="form-select form-select-lg">
                <option value="0">Seleccione un cargo</option>
            </select>
        </div>
        <div class="col-md-12">
            <label for="permiso_id" class="form-label fs-5">Permiso</label>
            <select id="permiso_id" class="form-select form-select-lg">
                <option value="0">Seleccione un permiso</option>
            </select>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <button class="btn btn-success btn-lg w-100" onclick="guardarUsuario();">
                <i class="bi bi-check-circle"></i> Guardar
            </button>
        </div>
        <div class="col-md-6">
            <button class="btn btn-outline-danger btn-lg w-100" onclick="mostrarListarUsuario();">
                <i class="bi bi-x-circle"></i> Cancelar
            </button>
        </div>
    </div>
</div>
