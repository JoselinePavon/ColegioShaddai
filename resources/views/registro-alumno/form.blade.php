<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-lg mt-2">
                <div class="card-body p-4">

                    <form method="POST" action="{{ route('registro-alumnos.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-3">Datos del Estudiante</h4>
                                <div class="mb-3">
                                    <label for="studentName" class="form-label fs-5"><i class="bi bi-person-fill"></i> Nombres</label>
                                    <input type="text" name="nombres" class="form-control form-control-lg @error('nombres') is-invalid @enderror" value="{{ old('nombres', $registroAlumno?->nombres) }}" id="nombres" placeholder="Nombres">
                                    {!! $errors->first('nombres', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="studentName" class="form-label fs-5"><i class="bi bi-person-fill"></i> Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control form-control-lg @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $registroAlumno?->apellidos) }}" id="apellidos" placeholder="Apellidos">
                                    {!! $errors->first('apellidos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="guardianRelation" class="form-label fs-5"><i class="bi bi-people-fill"></i> Genero</label>
                                    <input type="text" name="genero" class="form-control form-control-lg @error('genero') is-invalid @enderror" value="{{ old('genero', $registroAlumno?->genero) }}" id="genero" placeholder="Género">
                                    {!! $errors->first('genero', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="studentDOB" class="form-label fs-5"><i class="bi bi-calendar-date"></i> Edad</label>
                                    <input type="text" name="edad" class="form-control form-control-lg @error('edad') is-invalid @enderror" value="{{ old('edad', $registroAlumno?->edad) }}" id="edad" placeholder="Edad">
                                    {!! $errors->first('edad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="studentDOB" class="form-label fs-5"><i class="bi bi-calendar-date"></i> Fecha de nacimiento</label>
                                    <input type="date" name="fecha_nacimiento" class="form-control form-control-lg @error('fecha_nacimiento') is-invalid @enderror" value="{{ old('fecha_nacimiento', $registroAlumno?->fecha_nacimiento) }}" id="fecha_nacimiento" placeholder="Fecha de Nacimiento">
                                    {!! $errors->first('fecha_nacimiento', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                            </div>

                            <!-- Guardian Data (Right Side) -->
                            <div class="col-md-6">
                                <h4 class="mb-3">Datos del Encargado</h4>
                                <div class="mb-3">
                                    <label for="guardianName" class="form-label fs-5"><i class="bi bi-person-fill"></i> Nombre completo</label>
                                    <input type="text" name="nombre_encargado" class="form-control form-control-lg @error('nombre_encargado') is-invalid @enderror" value="{{ old('nombre_encargado', $encargado?->nombre_encargado) }}" id="Encargado" placeholder="Nombre Encargado">
                                    {!! $errors->first('nombre_encargado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>

                                <div class="mb-3">
                                    <label for="studentAddress" class="form-label fs-5"><i class="bi bi-house-door-fill"></i> Dirección</label>
                                    <input type="text" name="direccion" class="form-control form-control-lg @error('direccion') is-invalid @enderror" value="{{ old('direccion', $encargado?->direccion) }}" id="direccion" placeholder="Direccion">
                                    {!! $errors->first('direccion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>

                                <div class="mb-3">
                                    <label for="guardianPhone" class="form-label fs-5"><i class="bi bi-telephone-fill"></i> Teléfono</label>
                                    <input type="text" name="num_encargado1" class="form-control form-control-lg @error('num_encargado1') is-invalid @enderror" value="{{ old('num_encargado1', $encargado?->num_encargado1) }}" id="num_encargado1" placeholder="Numero de telefono">
                                    {!! $errors->first('num_encargado1', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="guardianPhone" class="form-label fs-5"><i class="bi bi-telephone-fill"></i> Teléfono Alternativo</label>
                                    <input type="text" name="num_encargado2" class="form-control form-control-lg @error('num_encargado2') is-invalid @enderror" value="{{ old('num_encargado2', $encargado?->num_encargado2) }}" id="num_encargado2" placeholder="Numero alternativo">
                                    {!! $errors->first('num_encargado2', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="guardianPhone" class="form-label fs-5"><i class="bi bi-telephone-fill"></i> Telefono de Emergencia</label>
                                    <input type="text" name="persona_emergencia" class="form-control form-control-lg @error('persona_emergencia') is-invalid @enderror" value="{{ old('persona_emergencia', $encargado?->persona_emergencia) }}" id="persona_emergencia" placeholder="Persona en caso de emergencia">
                                    {!! $errors->first('persona_emergencia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5"><i class="fas fa-save me-2"></i>{{ __('Guardar') }}</button>
                                <a href="{{ route('registro-alumnos.index') }}" class="btn btn-danger btn-lg px-5 ms-3"><i class="fas fa-times me-2"></i>{{ __('Cancelar') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
