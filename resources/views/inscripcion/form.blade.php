@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Inscripcion
@endsection

@section('content')
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-warning text-dark">
                        <h4>{{ __('Registrar') }} Inscripcion</h4>
                    </div>

                    <div class="card-body">
                        <!-- Formulario de búsqueda -->
                        <form method="GET" action="{{ route('resultados') }}" class="text-center">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Buscar por Nombre o Código de Barra">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="submit">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if(isset($alumnos) && $alumnos->count() > 0)
                        <div class="container">
                            <!-- Muestra la información del alumno -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="alumno_id" class="form-label">ID del Alumno</label>
                                    <input type="text" id="alumno_id" class="form-control" value="{{ $alumno->id }}" readonly>
                                    <!-- Añadir un campo oculto para el ID del alumno -->
                                    <input type="hidden" name="registro_alumnos_id" value="{{ $alumno->id }}">
                                </div>
                                <div class="form-group">
                                    <label for="alumno_nombre" class="form-label">Nombre del Alumno</label>
                                    <input type="text" id="alumno_nombre" class="form-control" value="{{ $alumno->nombres }}" readonly>
                                </div>

                                @if($yaInscrito)
                                    <div class="alert alert-warning" role="alert">
                                        Este alumno ya fue inscrito.
                                    </div>
                                @endif
                            </div>

                            @if(!$yaInscrito) <!-- Solo mostrar el formulario si el alumno no está inscrito -->
                            <!-- Formulario para inscripciones -->
                            <div class="card-body bg-light">
                                <form method="POST" action="{{ route('inscripcions.store') }}" role="form" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Campo oculto para el ID del alumno -->
                                    <input type="hidden" name="registro_alumnos_id" value="{{ $alumno->id }}">

                                    <div class="form-group mb-2">
                                        <label for="grados_id" class="form-label">{{ __('Grado') }}</label>
                                        <select name="grados_id" class="form-control @error('grados_id') is-invalid @enderror" id="grados_id">
                                            <option value="">Seleccione un grado</option>
                                            @foreach($grado as $id => $nombre_grado)
                                                <option value="{{ $id }}" {{ old('grados_id', $inscripcion->grados_id ?? '') == $id ? 'selected' : '' }}>
                                                    {{ $nombre_grado }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('grados_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="seccions_id" class="form-label">{{ __('Sección') }}</label>
                                        <select name="seccions_id" class="form-control @error('seccions_id') is-invalid @enderror" id="seccions_id">
                                            <option value="">Seleccione una sección</option>
                                            @foreach($seccion as $id => $nombre_seccion)
                                                <option value="{{ $id }}" {{ old('seccions_id', $inscripcion->seccions_id ?? '') == $id ? 'selected' : '' }}>
                                                    {{ $nombre_seccion }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('seccions_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>

                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary me-2">{{ __('Guardar') }}</button>
                                        <a href="{{ route('inscripcions.index') }}" class="btn btn-danger">{{ __('Cancelar') }}</a>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    @else
                        <p>No se encontraron resultados para la búsqueda.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection


