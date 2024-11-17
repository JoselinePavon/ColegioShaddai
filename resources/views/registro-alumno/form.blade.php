@extends('layouts.app')

@section('template_title')
    {{ __('Crear Pago') }}
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="card mb-5">
                <div class="card-body">

                    <!-- Mostrar el mensaje de error si el alumno no fue encontrado -->
                    @if(isset($error))
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endif
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
    <script>

            // Verificar unicidad del código personal si está lleno
            document.getElementById('validateButton').addEventListener('click', function () {
                const requiredFields = document.querySelectorAll('.required-field');
                let allFieldsFilled = true;

                // Obtener la lista de códigos existentes desde el backend
                const existingCodes = @json($existingCodes);

                // Limpiar mensajes de error previos
                requiredFields.forEach(field => {
                    field.classList.remove('is-invalid');
                });

                // Validar que todos los campos requeridos estén llenos
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        allFieldsFilled = false;
                    }
                });

                // Validar código personal
                const codigoPersonalField = document.getElementById('codigo_personal');
                if (existingCodes.includes(codigoPersonalField.value.trim())) {
                    codigoPersonalField.classList.add('is-invalid');
                    allFieldsFilled = false;
                }

                // Mostrar la siguiente sección si todo está correcto
                if (allFieldsFilled) {
                    document.getElementById('inscripcionSection').style.display = 'block';
                } else {
                    document.getElementById('inscripcionSection').style.display = 'none';
                }
            });
    </script>
    <script>
        document.getElementById('guardarButton').addEventListener('click', function (event) {
            // Prevenir el comportamiento predeterminado del formulario
            event.preventDefault();

            // Obtener todos los campos requeridos
            const requiredFields = document.querySelectorAll('.required-field');
            let allFieldsFilled = true;

            // Lista de códigos correlativos existentes (traídos desde el backend)
            const existingCorrelativos = @json($existingCorrelativos);

            // Limpiar mensajes de error previos
            requiredFields.forEach(field => {
                field.classList.remove('is-invalid');
            });

            // Validar que todos los campos requeridos estén llenos
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    allFieldsFilled = false;
                }
            });

            // Validar el código correlativo
            const codigoCorrelativoField = document.getElementById('codigo_correlativo');
            if (existingCorrelativos.includes(codigoCorrelativoField.value.trim())) {
                codigoCorrelativoField.classList.add('is-invalid');
                codigoCorrelativoField.nextElementSibling.textContent = 'El código correlativo ya está en uso.';
                allFieldsFilled = false;
            } else {
                codigoCorrelativoField.classList.remove('is-invalid');
                codigoCorrelativoField.nextElementSibling.textContent = '';
            }
            if (allFieldsFilled) {
                // Aquí podrías enviar el formulario manualmente usando fetch, si lo deseas.
                document.querySelector('form').submit();
            }
        });
    </script>

@endsection
