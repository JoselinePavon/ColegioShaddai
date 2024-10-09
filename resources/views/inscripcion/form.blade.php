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
                                <label for="registro_alumnos_id" class="form-label">{{ __('Nombres') }}</label>
                                <select name="registro_alumnos_id" id="registro_alumnos_id" class="form-control @error('registro_alumnos_id') is-invalid @enderror">
                                    <option value="">Seleccione un nombre</option>
                                    @foreach($registro_alumno as $id => $nombres)
                                        <option value="{{ $id }}" {{ old('registro_alumnos_id', $inscripcion->registro_alumnos_id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $nombres }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('registro_alumnos_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="grados_id" class="form-label">{{ __('Grado') }}</label>
                                <select name="grados_id" id="grados_id" class="form-control @error('grados_id') is-invalid @enderror">
                                    <option value="">Seleccione un grado</option>
                                    @foreach($grados as $id => $nombre)
                                        <option value="{{ $id }}" {{ old('grados_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                    @endforeach
                                </select>
                                @error('grados_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="seccions_id" class="form-label">{{ __('Sección') }}</label>
                                <select name="seccions_id" id="seccions_id" class="form-control @error('seccions_id') is-invalid @enderror">
                                    <option value="">Seleccione una seccion</option>
                                    @foreach($seccions as $id => $seccion)
                                        <option value="{{ $id }}" {{ old('seccions_id') == $id ? 'selected' : '' }}>{{ $seccion }}</option>
                                    @endforeach
                                </select>
                                @error('seccions_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
