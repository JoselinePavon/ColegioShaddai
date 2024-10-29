
                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('registro-alumnos.store') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="nombres" class="form-label">{{ __('Nombres') }}</label>
                                <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres', $registroAlumno?->nombres) }}" id="nombres" placeholder="Nombres">
                                {!! $errors->first('nombres', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="apellidos" class="form-label">{{ __('Apellidos') }}</label>
                                <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $registroAlumno?->apellidos) }}" id="apellidos" placeholder="Apellidos">
                                {!! $errors->first('apellidos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="genero" class="form-label">{{ __('Género') }}</label>
                                <input type="text" name="genero" class="form-control @error('genero') is-invalid @enderror" value="{{ old('genero', $registroAlumno?->genero) }}" id="genero" placeholder="Género">
                                {!! $errors->first('genero', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="edad" class="form-label">{{ __('Edad') }}</label>
                                <input type="text" name="edad" class="form-control @error('edad') is-invalid @enderror" value="{{ old('edad', $registroAlumno?->edad) }}" id="edad" placeholder="Edad">
                                {!! $errors->first('edad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="fecha_nacimiento" class="form-label">{{ __('Fecha de Nacimiento') }}</label>
                                <input type="date" name="fecha_nacimiento" class="form-control @error('fecha_nacimiento') is-invalid @enderror" value="{{ old('fecha_nacimiento', $registroAlumno?->fecha_nacimiento) }}" id="fecha_nacimiento" placeholder="Fecha de Nacimiento">
                                {!! $errors->first('fecha_nacimiento', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-2 mb20">
                                <label for="nombre_encargado" class="form-label">{{ __('Nombre Encargado') }}</label>
                                <input type="text" name="nombre_encargado" class="form-control @error('nombre_encargado') is-invalid @enderror" value="{{ old('nombre_encargado', $encargado?->nombre_encargado) }}" id="nombre_encargado" placeholder="Nombre Encargado">
                                {!! $errors->first('nombre_encargado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>
                            <div class="form-group mb-2 mb20">
                                <label for="direccion" class="form-label">{{ __('Direccion') }}</label>
                                <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion', $encargado?->direccion) }}" id="direccion" placeholder="Direccion">
                                {!! $errors->first('direccion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>
                            <div class="form-group mb-2 mb20">
                                <label for="num_encargado1" class="form-label">{{ __('Num Encargado1') }}</label>
                                <input type="text" name="num_encargado1" class="form-control @error('num_encargado1') is-invalid @enderror" value="{{ old('num_encargado1', $encargado?->num_encargado1) }}" id="num_encargado1" placeholder="Num Encargado1">
                                {!! $errors->first('num_encargado1', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>
                            <div class="form-group mb-2 mb20">
                                <label for="num_encargado2" class="form-label">{{ __('Num Encargado2') }}</label>
                                <input type="text" name="num_encargado2" class="form-control @error('num_encargado2') is-invalid @enderror" value="{{ old('num_encargado2', $encargado?->num_encargado2) }}" id="num_encargado2" placeholder="Num Encargado2">
                                {!! $errors->first('num_encargado2', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>
                            <div class="form-group mb-2 mb20">
                                <label for="persona_emergencia" class="form-label">{{ __('Persona Emergencia') }}</label>
                                <input type="text" name="persona_emergencia" class="form-control @error('persona_emergencia') is-invalid @enderror" value="{{ old('persona_emergencia', $encargado?->persona_emergencia) }}" id="persona_emergencia" placeholder="Persona Emergencia">
                                {!! $errors->first('persona_emergencia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                                    <a href="{{ route('registro-alumnos.index') }}" class="btn btn-danger">{{ __('Cancelar') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>


