@extends('layouts.app')

@section('template_title')
    {{ __('Crear Pago') }}
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="card mb-5">
                <div class="card-body">
                    <form method="POST" action="{{ route('registro-alumnos.store') }}">
                        @csrf

                        <!-- Row for student and guardian sections side by side -->
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-3">Datos del Alumno</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="codigo_personal" class="form-label"><i class="bi bi-person-fill"></i> Código Personal</label>
                                        <input type="text" name="codigo_personal" class="form-control required-field" id="codigo_personal" placeholder="123456789">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nombres" class="form-label"><i class="bi bi-person-fill"></i> Nombres</label>
                                        <input type="text" name="nombres" class="form-control required-field" id="nombres" placeholder="Nombres">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label"><i class="bi bi-person-fill"></i> Apellidos</label>
                                        <input type="text" name="apellidos" class="form-control required-field" id="apellidos" placeholder="Apellidos">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="genero" class="form-label"><i class="bi bi-people-fill"></i> Género</label>
                                        <select name="genero" class="form-control required-field" id="genero">
                                            <option value="">Selecciona género</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edad" class="form-label"><i class="bi bi-calendar-date"></i> Edad</label>
                                        <input type="number" name="edad" class="form-control required-field" id="edad" placeholder="Edad">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_nacimiento" class="form-label"><i class="bi bi-calendar-date"></i> Fecha de nacimiento</label>
                                        <input type="date" name="fecha_nacimiento" class="form-control required-field" id="fecha_nacimiento">
                                    </div>
                                </div>
                            </div>

                            <!-- Datos del Encargado -->
                            <div class="col-md-6">
                                <h4 class="mb-3">Datos del Encargado</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre_encargado" class="form-label"><i class="bi bi-person-fill"></i> Nombre completo</label>
                                        <input type="text" name="nombre_encargado" class="form-control required-field" id="nombre_encargado" placeholder="Nombre del Encargado">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="dpi" class="form-label"><i class="bi bi-house-door-fill"></i> Número de DPI</label>
                                        <input type="number" name="dpi" class="form-control required-field" id="dpi" placeholder="1234 1232 1234">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lugars_id" class="form-label"><i class="bi bi-geo-alt-fill"></i> Lugar</label>
                                        <select name="lugars_id" id="lugars_id" class="form-control required-field">
                                            <option value="">Seleccione un lugar</option>
                                            @foreach($lugares as $lugar)
                                                <option value="{{ $lugar->id }}">{{ $lugar->lugar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="colonias_id" class="form-label"><i class="bi bi-map-fill"></i> Colonia</label>
                                        <select name="colonias_id" id="colonias_id" class="form-control required-field" disabled>
                                            <option value="">Seleccione una colonia</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label"><i class="bi bi-telephone-fill"></i> Teléfono</label>
                                        <input type="text" name="telefono" class="form-control required-field" id="telefono" placeholder="Número de Teléfono">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="persona_emergencia" class="form-label"><i class="bi bi-telephone-fill"></i> Persona de Emergencia</label>
                                        <input type="text" name="persona_emergencia" class="form-control required-field" id="persona_emergencia" placeholder="Persona de Emergencia">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de Validación -->
                        <div class="text-center mt-3">
                            <button type="button" id="validateButton" class="btn btn-dark"><i class="fas fa-check"></i> Siguiente</button>
                        </div>

                        <!-- Sección de Inscripción, inicialmente oculta -->
                        <div id="inscripcionSection" class="mt-4" style="display: none;">
                            <h4 class="mb-3">Datos para Inscripción</h4>
                            <div class="row">
                                <input type="hidden" name="registro_alumnos_id" id="registro_alumnos_id" value="">

                                <div class="col-md-6 mb-3">
                                    <label for="codigo_correlativo" class="form-label">Código Correlativo</label>
                                    <input type="text" name="codigo_correlativo" class="form-control" id="codigo_correlativo" placeholder="Escribe el código">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="grados_id" class="form-label">Grado</label>
                                    <select name="grados_id" class="form-select" id="grados_id">
                                        <option value="">Seleccione un grado</option>
                                        @foreach($grado as $id => $nombre_grado)
                                            <option value="{{ $id }}">{{ $nombre_grado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="seccions_id" class="form-label">Sección</label>
                                    <select name="seccions_id" class="form-select" id="seccions_id">
                                        <option value="">Seleccione una sección</option>
                                        @foreach($seccion as $id => $nombre_seccion)
                                            <option value="{{ $id }}">{{ $nombre_seccion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark mt-3">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('validateButton').addEventListener('click', function () {
            const requiredFields = document.querySelectorAll('.required-field');
            let allFieldsFilled = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    allFieldsFilled = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (allFieldsFilled) {
                document.getElementById('inscripcionSection').style.display = 'block';
            }
        });

        // Script para cargar colonias basado en el lugar seleccionado
        const coloniasPorLugar = {
            @foreach($lugares as $lugar)
                {{ $lugar->id }}: [
                    @foreach($colonias->where('lugars_id', $lugar->id) as $colonia)
                { id: {{ $colonia->id }}, nombre: "{{ $colonia->nombre }}" },
                @endforeach
            ],
            @endforeach
        };

        const lugarSelect = document.getElementById('lugars_id');
        const coloniaSelect = document.getElementById('colonias_id');

        lugarSelect.addEventListener('change', function () {
            const lugarId = this.value;
            coloniaSelect.innerHTML = '<option value="">Seleccione una colonia</option>';
            coloniaSelect.disabled = true;

            if (coloniasPorLugar[lugarId]) {
                coloniasPorLugar[lugarId].forEach(colonia => {
                    const option = document.createElement('option');
                    option.value = colonia.id;
                    option.textContent = colonia.nombre;
                    coloniaSelect.appendChild(option);
                });
                coloniaSelect.disabled = false;
            }
        });
    </script>
@endsection
