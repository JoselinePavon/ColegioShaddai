@extends('layouts.app')

@section('template_title')

@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="card mb-5">
                <div class="card-body">
                    {{-- SweetAlert para mensajes de éxito --}}
                    @if ($message = Session::get('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: '{{ $message }}',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        </script>
                    @endif
                    <form id="alumnoForm" method="POST" action="{{ route('registro-alumnos.store') }}">
                        @csrf

                        <!-- Row for student and guardian sections side by side -->
                        <div class="row">
                            <div class="col-md-6">
                                <center><h4 class="mb-3" >Datos del Alumno</h4></center>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="codigo_personal" class="form-label"><i class="bi bi-person-fill"></i> Código Personal</label>
                                        <input type="text" name="codigo_personal" class="form-control required-field" id="codigo_personal" placeholder="123456789">
                                        <div class="invalid-feedback">El código personal ya está en uso.</div>
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
                                <center>  <h4 class="mb-3">Datos del Encargado</h4></center>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre_encargado" class="form-label"><i class="bi bi-person-fill"></i> Nombre completo</label>
                                        <input type="text" name="nombre_encargado" class="form-control required-field" id="nombre_encargado" placeholder="Nombre del Encargado">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edad" class="form-label"><i class="bi bi-person-fill"></i> Edad</label>
                                        <input type="number" name="edad" class="form-control required-field" id="edad" placeholder="Ingresa la Edad" min="0" max="120" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="estado_civil" class="form-label"><i class="bi bi-person-fill"></i> Estado Civil</label>
                                        <input type="text" name="estado_civil" class="form-control required-field" id="estado_civil" placeholder="Ingresa tu Estado Civil" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="oficio" class="form-label"> <i class="fas fa-briefcase" style="color: black;"></i> Oficio</label>
                                        <input type="text" name="oficio" class="form-control required-field" id="oficio" placeholder="Ingresa tu Oficio" required>
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
                        <div class="text-center mt-1">
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
                                    <div class="invalid-feedback">El código correlativo ya está en uso.</div>
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
                                    <label for="jornada" class="form-label">Jornada</label>
                                    <select name="jornada" class="form-select" id="jornada">
                                        <option value="">Selecciona género</option>
                                        <option value="Matutina">Matutina</option>
                                        <option value="Vespertina">Vespertina</option>
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

                            <button type="button" id="guardarButton" class="btn btn-dark mt-3">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <!-- Últimos Alumnos Registrados -->
        <div class="col-md-6">
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header  rounded-top">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i> Últimos Alumnos Registrados
                    </h5>
                </div>
                <div class="card-body">
                    @if ($ultimosAlumnos && count($ultimosAlumnos) > 0)
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-arrow-down"></i></th>
                                <th>Código Personal</th>
                                <th>Nombre</th>
                                <th>Género</th>
                                <th>Edad</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($ultimosAlumnos as $index => $alumno)
                                <tr class="{{ $index == 0 ? 'text-success fw-bold' : ($index == 1 ? ' ' : '') }}">
                                    <td>
                                        @if ($index == 1)
                                            <i class="fas fa-arrow-down"></i>
                                        @else
                                            <i class="fas fa-arrow-right"></i>
                                        @endif
                                    </td>
                                    <td>{{ $alumno->codigo_personal }}</td>
                                    <td>{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
                                    <td>{{ $alumno->genero }}</td>
                                    <td>{{ $alumno->edad }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i> No hay alumnos registrados.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Últimos Alumnos Inscritos -->
        <div class="col-md-6">
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header rounded-top">
                    <h5 class="mb-0">
                        <i class="fas fa-book me-2"></i> Últimos Alumnos Inscritos
                    </h5>
                </div>
                <div class="card-body">
                    @if ($ultimasInscripciones && count($ultimasInscripciones) > 0)
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-arrow-down"></i></th>
                                <th>Código Correlativo</th>
                                <th>Nombre</th>
                                <th>Grado</th>
                                <th>Sección</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($ultimasInscripciones as $index => $inscripcion)
                                <tr class="{{ $index == 0 ? 'text-success fw-bold' : ($index == 1 ? ' ' : '') }}">
                                    <td>
                                        @if ($index == 1)
                                            <i class="fas fa-arrow-down"></i>
                                        @else
                                            <i class="fas fa-arrow-right"></i>
                                        @endif
                                    </td>
                                    <td>{{ $inscripcion->codigo_correlativo }}</td>
                                    <td>{{ $inscripcion->registroAlumno->nombres }} {{ $inscripcion->registroAlumno->apellidos }}</td>
                                    <td>{{ $inscripcion->grado->nombre_grado ?? 'N/A' }}</td>
                                    <td>{{ $inscripcion->seccion->seccion ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i> No hay alumnos inscritos.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('alumnoForm');
            const validateButton = document.getElementById('validateButton');
            const guardarButton = document.getElementById('guardarButton');
            const requiredFields = document.querySelectorAll('.required-field');
            const inscripcionSection = document.getElementById('inscripcionSection');
            const existingCodes = @json($existingCodes);
            const existingCorrelativos = @json($existingCorrelativos);
            // alidar campos del alumno (antes de mostrar inscripción)
            const validateAlumnoFields = () => {
                let valid = true;
                requiredFields.forEach(field => {
                    field.classList.remove('is-invalid');
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        valid = false;
                    }
                });
                const codigoField = document.getElementById('codigo_personal');
                if (existingCodes.includes(codigoField.value.trim())) {
                    codigoField.classList.add('is-invalid');
                    valid = false;
                }
                return valid;
            };
            // Validar todos los campos (incluyendo grado y sección)
            const validateAllFields = () => {
                let valid = validateAlumnoFields(); // Reutilizamos la validación de alumno
                // Validar grado
                const gradoField = document.getElementById('grados_id');
                if (!gradoField.value.trim()) {
                    gradoField.classList.add('is-invalid');
                    valid = false;
                } else {
                    gradoField.classList.remove('is-invalid');
                }
                // Validar sección
                const seccionField = document.getElementById('seccions_id');
                if (!seccionField.value.trim()) {
                    seccionField.classList.add('is-invalid');
                    valid = false;
                } else {
                    seccionField.classList.remove('is-invalid');
                }
                // Validar código correlativo
                const correlativoField = document.getElementById('codigo_correlativo');
                if (correlativoField && existingCorrelativos.includes(correlativoField.value.trim())) {
                    correlativoField.classList.add('is-invalid');
                    correlativoField.nextElementSibling.textContent = 'El código correlativo ya está en uso.';
                    valid = false;
                } else if (correlativoField) {
                    correlativoField.classList.remove('is-invalid');
                    correlativoField.nextElementSibling.textContent = '';
                }
                return valid;
            };
            // Evento del botón "Siguiente"
            validateButton.addEventListener('click', () => {
                if (validateAlumnoFields()) {
                    inscripcionSection.style.display = 'block';
                }
            });
            // Evento del botón "Guardar"
            guardarButton.addEventListener('click', (e) => {
                e.preventDefault();
                if (validateAllFields()) {
                    form.submit();
                }
            });
            // Actualizar el listado de colonias al seleccionar un lugar
            const lugarSelect = document.getElementById('lugars_id');
            const coloniaSelect = document.getElementById('colonias_id');
            const coloniasPorLugar = @json($lugares->mapWithKeys(fn($lugar) => [$lugar->id => $colonias->where('lugars_id', $lugar->id)->pluck('nombre', 'id')]));
            lugarSelect.addEventListener('change', () => {
                const lugarId = lugarSelect.value;
                coloniaSelect.innerHTML = '<option value="">Seleccione una colonia</option>';
                coloniaSelect.disabled = true;

                if (coloniasPorLugar[lugarId]) {
                    for (const [id, nombre] of Object.entries(coloniasPorLugar[lugarId])) {
                        const option = new Option(nombre, id);
                        coloniaSelect.add(option);
                    }
                    coloniaSelect.disabled = false;
                }
            });
        });
    </script>
@endsection
