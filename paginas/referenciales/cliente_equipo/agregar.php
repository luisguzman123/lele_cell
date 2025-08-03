<?php session_start(); ?>
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 p-4 mx-auto" style="max-width: 950px;">
        <input type="hidden" id="id_cliente_equipo" value="0">

        <!-- Título -->
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-box-arrow-in-down me-2"></i>Registrar Ingreso de Equipo
            </h2>
            <p class="text-muted">Asociá un cliente con su equipo recibido para reparación o revisión</p>
            <hr>
        </div>

        <!-- Cliente y Equipo -->
        <div class="row g-4">
            <!-- Cliente -->
            <div class="col-md-6">
                <label for="cliente_id" class="form-label fs-5">
                    <i class="bi bi-person-circle me-1"></i>Cliente
                </label>
                <select id="cliente_id" class="form-control form-control-lg">
                    <option value="0">Seleccione un cliente</option>
                    <!-- Opciones cargadas dinámicamente -->
                </select>
            </div>

            <!-- Equipo -->
            <div class="col-md-6">
                <label for="equipo_id" class="form-label fs-5">
                    <i class="bi bi-phone me-1"></i>Equipo
                </label>
                <select id="equipo_id" class="form-control form-control-lg">
                    <option value="0">Seleccione un equipo</option>
                    <!-- Opciones cargadas dinámicamente -->
                </select>
            </div>
        </div>

        <!-- Bloqueo y Contraseña -->
        <div class="row g-4 mt-3">
            <!-- Tipo de bloqueo -->
            <div class="col-md-6">
                <label for="tipo_bloqueo" class="form-label fs-5">
                    <i class="bi bi-lock-fill me-1"></i>Tipo de bloqueo
                </label>
                <select id="tipo_bloqueo" class="form-control form-control-lg">
                    <option value="PATRON">Patrón</option>
                    <option value="CONTRASEÑA">Contraseña</option>
                    <option value="SIN BLOQUEO">Sin bloqueo</option>
                </select>
            </div>

            <!-- Contraseña / Patrón -->
            <div class="col-md-6">
                <label for="clave_equipo" class="form-label fs-5">
                    <i class="bi bi-key-fill me-1"></i>Contraseña / Patrón
                </label>
                <input type="text" id="clave_equipo" class="form-control form-control-lg" placeholder="Ej: 1234, Z-patrón...">
            </div>
        </div>

        <!-- IMEI -->
        <div class="row mt-4">
            <div class="col-md-12">
                <label for="imei" class="form-label fs-5">
                    <i class="bi bi-upc-scan me-1"></i>IMEI
                </label>
                <input type="text" id="imei" class="form-control form-control-lg" placeholder="Ej: 359875654321456">
            </div>
        </div>

        <!-- Botones -->
        <div class="row mt-5">
            <div class="col-md-6 d-grid">
                <button class="btn btn-success btn-lg" onclick="guardarClienteEquipo();">
                    <i class="bi bi-save2-fill me-2"></i>Guardar
                </button>
            </div>
            <div class="col-md-6 d-grid">
                <button class="btn btn-outline-secondary btn-lg" onclick="mostrarListarClienteEquipo();">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
