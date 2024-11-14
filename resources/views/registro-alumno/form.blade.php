@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Pago
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
                                <h4 class="mb-3" style="background-color: #343a40; color: white; padding: 10px; border-radius: 5px;">Datos del Alumno</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="codigo_personal" class="form-label fs-5"><i class="bi bi-person-fill"></i> codigo_personal</label>
                                            <input type="text" name="codigo_personal" class="form-control" value="{{ old('codigo_personal', $registroAlumno?->codigo_personal) }}" id="codigo_personal" placeholder="123456789">
                                            {!! $errors->first('codigo_personal', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="nombres" class="form-label fs-5"><i class="bi bi-person-fill"></i> Nombres</label>
                                            <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $registroAlumno?->nombres) }}" id="nombres" placeholder="Nombres">
                                            {!! $errors->first('nombres', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="apellidos" class="form-label fs-5"><i class="bi bi-person-fill"></i> Apellidos</label>
                                            <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $registroAlumno?->apellidos) }}" id="apellidos" placeholder="Apellidos">
                                            {!! $errors->first('apellidos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="genero" class="form-label fs-5"><i class="bi bi-people-fill"></i> Género</label>
                                            <select name="genero" class="form-control" id="genero">
                                                <option value="">Selecciona género</option>
                                                <option value="Masculino" {{ old('genero', $registroAlumno?->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                <option value="Femenino" {{ old('genero', $registroAlumno?->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                            </select>
                                            {!! $errors->first('genero', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="edad" class="form-label fs-5"><i class="bi bi-calendar-date"></i> Edad</label>
                                            <input type="number" name="edad" class="form-control" value="{{ old('edad', $registroAlumno?->edad) }}" id="edad" placeholder="Edad">
                                            {!! $errors->first('edad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_nacimiento" class="form-label fs-5"><i class="bi bi-calendar-date"></i> Fecha de nacimiento</label>
                                        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $registroAlumno?->fecha_nacimiento) }}" id="fecha_nacimiento">
                                        {!! $errors->first('fecha_nacimiento', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>
                                </div>
                            </div>

                            <!-- Guardian Information (Right Side) -->
                            <div class="col-md-6">
                                <h4 class="mb-3" style="background-color: #05027b; color: white; padding: 10px; border-radius: 5px;">Datos del Encargado</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="nombre_encargado" class="form-label fs-5"><i class="bi bi-person-fill"></i> Nombre completo</label>
                                            <input type="text" name="nombre_encargado" class="form-control" value="{{ old('nombre_encargado', $encargado?->nombre_encargado) }}" id="nombre_encargado" placeholder="Nombre del Encargado">
                                            {!! $errors->first('nombre_encargado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="dpi" class="form-label fs-5"><i class="bi bi-house-door-fill"></i> Numero de Dpi</label>
                                        <input type="number" name="dpi" class="form-control" value="{{ old('dpi', $encargado?->dpi) }}" id="dpi" placeholder="1234 1232 1234">
                                        {!! $errors->first('dpi', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="lugars_id" class="form-label fs-5"><i class="bi bi-geo-alt-fill"></i> Lugar</label>
                                        <select name="lugars_id" id="lugars_id" class="form-control">
                                            <option value="">Seleccione un lugar</option>
                                            @foreach($lugares as $lugar)
                                                <option value="{{ $lugar->id }}" {{ old('lugars_id', $encargado?->lugars_id) == $lugar->id ? 'selected' : '' }}>
                                                    {{ $lugar->lugar}}
                                                </option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('lugars_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="colonias_id" class="form-label fs-5"><i class="bi bi-map-fill"></i> Colonia</label>
                                        <select name="colonias_id" id="colonias_id" class="form-control" disabled>
                                            <option value="">Seleccione una colonia</option>
                                        </select>
                                        {!! $errors->first('colonias_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label fs-5"><i class="bi bi-telephone-fill"></i> Teléfono</label>
                                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $encargado?->telefono) }}" id="telefono" placeholder="Número de Teléfono">
                                        {!! $errors->first('telefono', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="persona_emergencia" class="form-label fs-5"><i class="bi bi-telephone-fill"></i> Persona de Emergencia</label>
                                        <input type="text" name="persona_emergencia" class="form-control" value="{{ old('persona_emergencia', $encargado?->persona_emergencia) }}" id="persona_emergencia" placeholder="Nombre de Persona de Emergencia">
                                        {!! $errors->first('persona_emergencia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-dark px-5"><i class="fas fa-save me-2"></i> Guardar</button>
                                    <a href="{{ route('encargados.index') }}" class="btn btn-danger px-5 ms-3"><i class="fas fa-times me-2"></i> Cancelar</a>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Script para cargar colonias dinámicamente basado en el lugar -->
    <script>
        // Objeto de colonias organizado por lugar
        const coloniasPorLugar = {
            @foreach($lugares as $lugar)
                {{ $lugar->id }}: [
                    @foreach($colonias->where('lugars_id', $lugar->id) as $colonia)
                { id: {{ $colonia->id }}, nombre: "{{ $colonia->nombre }}" },
                @endforeach
            ],
            @endforeach
        };

        // Selección de elementos del DOM
        const lugarSelect = document.getElementById('lugars_id');
        const coloniaSelect = document.getElementById('colonias_id');

        // Evento al cambiar el lugar seleccionado
        lugarSelect.addEventListener('change', function () {
            const lugarId = this.value;

            // Limpiar el selector de colonia y deshabilitar por defecto
            coloniaSelect.innerHTML = '<option value="">Seleccione una colonia</option>';
            coloniaSelect.disabled = true;

            // Si hay colonias para el lugar seleccionado, habilitar y cargar opciones
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
