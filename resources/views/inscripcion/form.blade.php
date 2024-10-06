@extends('layouts.app')

@section('template_title')
    {{ __('Inscripción de Alumnos') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-warning text-dark">
                        <h4>{{ __('Inscripción de Alumnos') }}</h4>
                    </div>

                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('inscripcions.store') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="nombres" class="form-label">{{ __('Nombres') }}</label>
                                <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres', $inscripcion?->nombres) }}" id="nombres" placeholder="Nombres">
                                {!! $errors->first('nombres', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="apellidos" class="form-label">{{ __('Apellidos') }}</label>
                                <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $inscripcion?->apellidos) }}" id="apellidos" placeholder="Apellidos">
                                {!! $errors->first('apellidos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="genero" class="form-label">{{ __('Género') }}</label>
                                <input type="text" name="genero" class="form-control @error('genero') is-invalid @enderror" value="{{ old('genero', $inscripcion?->genero) }}" id="genero" placeholder="Género">
                                {!! $errors->first('genero', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="edad" class="form-label">{{ __('Edad') }}</label>
                                <input type="text" name="edad" class="form-control @error('edad') is-invalid @enderror" value="{{ old('edad', $inscripcion?->edad) }}" id="edad" placeholder="Edad">
                                {!! $errors->first('edad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="fecha_nacimiento" class="form-label">{{ __('Fecha de Nacimiento') }}</label>
                                <input type="date" name="fecha_nacimiento" class="form-control @error('fecha_nacimiento') is-invalid @enderror" value="{{ old('fecha_nacimiento', $inscripcion?->fecha_nacimiento) }}" id="fecha_nacimiento" placeholder="Fecha de Nacimiento">
                                {!! $errors->first('fecha_nacimiento', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <select name="grados_id" class="form-control @error('grados_id') is-invalid @enderror" id="grados_id">
                                    <option value="" disabled selected>Seleccione</option>
                                    @foreach($grado as $id => $nombre_grado)
                                        <option value="{{ $id }}" {{ old('grados_id', $inscripcion?->grados_id) == $id ? 'selected' : '' }}>
                                            {{ $nombre_grado }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>


                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                                    <a href="{{ route('inscripcions.index') }}" class="btn btn-danger">{{ __('Cancelar') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

