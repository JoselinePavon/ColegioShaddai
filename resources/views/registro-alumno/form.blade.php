@extends('layouts.app')

@section('template_title')
    Registro de Alumnos
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Contenedor Principal --}}
        <div class="row">
            {{-- Formulario --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
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
                    <form method="POST" action="{{ route('registro-alumnos.store') }}">
                        @csrf

                        {{-- Datos del Alumno --}}
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <h6 class="text-primary mb-3 text-center"><i class="bi bi-person-fill"></i> Datos del Alumno</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label for="codigo_personal" class="form-label">
                                            Código Personal
                                        </label>
                                        <input type="text" name="codigo_personal" class="form-control form-control-sm" id="codigo_personal" placeholder="123456789">
                                        <span id="codigo_personal_error" class="text-danger" style="font-size: 0.875em;"></span>
                                    </div>
                                    <div class="col-6">
                                        <label for="nombres" class="form-label">
                                            Nombres <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="nombres" class="form-control form-control-sm" id="nombres" placeholder="Ingrese los nombres" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="apellidos" class="form-label">
                                            Apellidos <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="apellidos" class="form-control form-control-sm" id="apellidos" placeholder="Ingrese los apellidos" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="genero" class="form-label">
                                            Género <span class="text-danger">*</span>
                                        </label>
                                        <select name="genero" class="form-control form-control-sm" id="genero" required>
                                            <option value="">Seleccione</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="edad" class="form-label">
                                            Edad <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="edad" class="form-control form-control-sm" id="edad" placeholder="Edad" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="fecha_nacimiento" class="form-label">
                                            Fecha de Nacimiento <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="fecha_nacimiento" class="form-control form-control-sm" id="fecha_nacimiento" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Datos del Encargado --}}
                            <div class="col-lg-6 col-md-12">
                                <h6 class="text-primary mb-3 text-center"><i class="bi bi-person-check-fill"></i> Datos del Encargado</h6>
                                <div class="row g-2">
                                    <div class="col-9">
                                        <label for="nombre_encargado" class="form-label">
                                            Nombre Completo <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="nombre_encargado" class="form-control form-control-sm" id="nombre_encargado" placeholder="Nombre del Encargado" required>
                                    </div>
                                    <div class="col-3">
                                        <label for="edad_encargado" class="form-label">
                                            Edad <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="edad_encargado" class="form-control form-control-sm" id="edad_encargado" placeholder="Edad" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="dpi" class="form-label">
                                            DPI <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="dpi" class="form-control form-control-sm" id="dpi" placeholder="Número de DPI" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="oficio" class="form-label">
                                            Oficio <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="oficio" class="form-control form-control-sm" id="oficio" placeholder="Oficio del encargado" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="estado_civil" class="form-label">
                                            Estado Civil <span class="text-danger">*</span>
                                        </label>
                                        <select name="estado_civil" class="form-control form-control-sm" id="estado_civil" required>
                                            <option value="">Seleccione</option>
                                            <option value="Casado(a)">Casado(a)</option>
                                            <option value="Soltero(a)">Soltero(a)</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="lugars_id" class="form-label">
                                            Lugar <span class="text-danger">*</span>
                                        </label>
                                        <select name="lugars_id" class="form-control form-control-sm" id="lugars_id" required>
                                            <option value="">Seleccione un lugar</option>
                                            @foreach($lugares as $lugar)
                                                <option value="{{ $lugar->id }}">{{ $lugar->lugar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="colonias_id" class="form-label">
                                            Colonia <span class="text-danger">*</span>
                                        </label>
                                        <select name="colonias_id" class="form-control form-control-sm" id="colonias_id" required>
                                            <option value="">Seleccione una colonia</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="telefono" class="form-label">
                                            Teléfono <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="telefono" class="form-control form-control-sm" id="telefono" placeholder="Número de teléfono" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="persona_emergencia" class="form-label">
                                            Teléfono de Emergencia <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="persona_emergencia" class="form-control form-control-sm" id="persona_emergencia" placeholder="Número de emergencia" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Inscripción --}}
                        <h6 class="text-primary mb-3 mt-4 text-center"><i class="bi bi-card-list"></i> Inscripción</h6>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="codigo_correlativo" class="form-label">
                                    Código Correlativo <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="codigo_correlativo" class="form-control form-control-sm" id="codigo_correlativo" placeholder="Código correlativo" required>
                                <span id="codigo_correlativo_error" class="text-danger" style="font-size: 0.875em;"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="grados_id" class="form-label">
                                    Grado<span class="text-danger">*</span>
                                </label>
                                <select name="grados_id" class="form-control form-control-sm" id="grados_id" required>
                                    <option value="">Seleccione el grado</option>
                                    @foreach($grado as $id => $nombre_grado)
                                        <option value="{{ $id }}">{{ $nombre_grado }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="jornada" class="form-label">
                                    Jornada<span class="text-danger">*</span>
                                </label>
                                <select name="jornada" class="form-control form-control-sm" id="jornada" required>
                                    <option value="">Seleccione la jornada</option>
                                    <option value="Matutina">Matutina</option>
                                    <option value="Vespertina">Vespertina</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="seccions_id" class="form-label">
                                    Sección<span class="text-danger">*</span>
                                </label>
                                <select name="seccions_id" class="form-control form-control-sm" id="seccions_id" required>
                                    <option value="">Seleccione la sección</option>
                                    @foreach($seccion as $id => $nombre_seccion)
                                        <option value="{{ $id }}">{{ $nombre_seccion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Botón de guardar --}}
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-save"></i> Guardar
                            </button>
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
                                    <td>{{ $alumno->codigo_personal ?? 'SIN CODGO PERSONAL' }}</td>
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
    </script>
    <script>
        const codigoPersonalInput = document.getElementById('codigo_personal');
        const codigoPersonalError = document.getElementById('codigo_personal_error');
        const codigoCorrelativoInput = document.getElementById('codigo_correlativo');
        const codigoCorrelativoError = document.getElementById('codigo_correlativo_error');

        // Función para validar el código en el servidor
        const validarCodigo = (input, errorElement, routeName) => {
            const codigo = input.value;

            if (codigo) {
                fetch(routeName, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ codigo }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.existe) {
                            errorElement.textContent = 'Este código ya está registrado. Por favor, utiliza uno diferente.';
                            input.classList.add('is-invalid'); // Marca el campo con borde rojo
                        } else {
                            errorElement.textContent = ''; // Limpia el mensaje si es válido
                            input.classList.remove('is-invalid');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                errorElement.textContent = ''; // Limpia el mensaje si está vacío
                input.classList.remove('is-invalid');
            }
        };

        // Eventos de validación para Código Personal
        codigoPersonalInput.addEventListener('blur', () => {
            validarCodigo(codigoPersonalInput, codigoPersonalError, '{{ route('validar-codigo') }}');
        });

        // Eventos de validación para Código Correlativo
        codigoCorrelativoInput.addEventListener('blur', () => {
            validarCodigo(codigoCorrelativoInput, codigoCorrelativoError, '{{ route('validar-codigo-correlativo') }}');
        });
    </script>
    <script>
        // Función para formatear números con guiones cada 4 dígitos
        const formatWithHyphen = (input) => {
            let value = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
            if (value.length > 8) {
                value = value.slice(0, 8); // Limitar a 8 dígitos
            }
            value = value.match(/.{1,4}/g)?.join('-') || ''; // Agrupar cada 4 caracteres y unir con guiones
            input.value = value;
        };

        const telefonoInput = document.getElementById('telefono');
        const emergenciaInput = document.getElementById('persona_emergencia');

        // Aplicar la función en cada evento de entrada
        telefonoInput.addEventListener('input', () => formatWithHyphen(telefonoInput));
        emergenciaInput.addEventListener('input', () => formatWithHyphen(emergenciaInput));

        // Validación al enviar el formulario (opcional, para asegurar que no tenga menos de 8 números)
        document.querySelector('form').addEventListener('submit', (event) => {
            const telefonoRaw = telefonoInput.value.replace(/[-\s]/g, '');
            const emergenciaRaw = emergenciaInput.value.replace(/[-\s]/g, '');

            if (telefonoRaw.length !== 8) {
                event.preventDefault();
                alert('El número de teléfono debe tener exactamente 8 dígitos.');
                telefonoInput.focus();
                return;
            }
        });
    </script>
@endsection
