<?php session_start(); ?>
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 p-4 mx-auto" style="max-width: 900px;">
        <input type="hidden" id="id_equipo" value="0">

        <!-- Título -->
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary"><i class="bi bi-phone-fill me-2"></i>Agregar Equipo</h2>
            <p class="text-muted">Completá los datos del dispositivo que recibiste</p>
            <hr>
        </div>

        <!-- Formulario -->
        <div class="row g-4">
            <!-- Marca -->
            <div class="col-md-4">
                <label for="marca" class="form-label fs-5">
                    <i class="bi bi-tools me-1"></i>Marca
                </label>
                <input type="text" id="marca" class="form-control form-control-lg" placeholder="Ej: Samsung, Apple, Xiaomi...">
            </div>

            <!-- Modelo -->
            <div class="col-md-4">
                <label for="modelo" class="form-label fs-5">
                    <i class="bi bi-cpu-fill me-1"></i>Modelo
                </label>
                <input type="text" id="modelo" class="form-control form-control-lg" placeholder="Ej: A32, iPhone 11...">
            </div>

            <!-- Descripción -->
            <div class="col-md-4">
                <label for="descripcion" class="form-label fs-5">
                    <i class="bi bi-file-text me-1"></i>Descripción
                </label>
                <input type="text" id="descripcion" class="form-control form-control-lg" placeholder="Ej: Pantalla rota, no carga...">
            </div>
        </div>

        <!-- Botones -->
        <div class="row mt-5">
            <div class="col-md-6 d-grid">
                <button class="btn btn-success btn-lg" onclick="guardarEquipo();">
                    <i class="bi bi-save2-fill me-2"></i>Guardar Equipo
                </button>
            </div>
            <div class="col-md-6 d-grid">
                <button class="btn btn-outline-secondary btn-lg" onclick="mostrarListarEquipo();">
                    <i class="bi bi-x-circle-fill me-2"></i>Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
