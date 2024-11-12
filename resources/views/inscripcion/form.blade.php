@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Inscripcion
@endsection

@section('content')
    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="font-weight-bold"><i class="bi bi-person-circle"></i> {{ __('Registrar') }} Inscripción</h4>
                </div>

                <!-- Formulario de búsqueda -->
                <form method="GET" action="{{ route('resultados') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Buscar por Nombre o Código del alumno">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </form>

                @if(isset($alumnos) && $alumnos->count() > 0)
                    <!-- Información del Alumno -->
                    <div class="bg-light p-4 rounded mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="alumno_id" class="form-label">ID del Alumno</label>
                                <input type="text" id="alumno_id" class="form-control" value="{{ $alumno->id }}" readonly>
                                <input type="hidden" name="registro_alumnos_id" value="{{ $alumno->id }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="alumno_nombre" class="form-label">Nombre del Alumno</label>
                                <input type="text" id="alumno_nombre" class="form-control" value="{{ $alumno->nombres }}" readonly>
                            </div>
                        </div>

                        @if($yaInscrito)
                            <div class="alert alert-warning" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> Este alumno ya fue inscrito.
                            </div>
                        @endif
                    </div>

                    @if(!$yaInscrito)
                        <!-- Formulario de Inscripción -->
                        <form method="POST" action="{{ route('inscripcions.store') }}" role="form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="registro_alumnos_id" value="{{ $alumno->id }}">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="grados_id" class="form-label">{{ __('Grado') }}</label>
                                    <select name="grados_id" class="form-select @error('grados_id') is-invalid @enderror" id="grados_id">
                                        <option value="">Seleccione un grado</option>
                                        @foreach($grado as $id => $nombre_grado)
                                            <option value="{{ $id }}" {{ old('grados_id', $inscripcion->grados_id ?? '') == $id ? 'selected' : '' }}>
                                                {{ $nombre_grado }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('grados_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="seccions_id" class="form-label">{{ __('Sección') }}</label>
                                    <select name="seccions_id" class="form-select @error('seccions_id') is-invalid @enderror" id="seccions_id">
                                        <option value="">Seleccione una sección</option>
                                        @foreach($seccion as $id => $nombre_seccion)
                                            <option value="{{ $id }}" {{ old('seccions_id', $inscripcion->seccions_id ?? '') == $id ? 'selected' : '' }}>
                                                {{ $nombre_seccion }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('seccions_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2 justify-content-end mt-4">
                                <a href="{{ route('inscripcions.index') }}" class="btn btn-outline-dark">
                                    <i class="fas fa-times"></i> {{ __('Cancelar') }}
                                </a>
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-save"></i> {{ __('Guardar') }}
                                </button>
                            </div>
                        </form>
                    @endif
                @else
                    <div class="alert alert-info text-center" role="alert">
                        <i class="fas fa-info-circle"></i> No se encontraron resultados para la búsqueda.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
