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


                        <form method="POST" action="{{ route('inscripcions.store') }}" role="form" enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="codigo_correlativo" class="form-label"> {{ __('Codigo Correlativo') }}</label>
                                    <input type="text" name="codigo_correlativo" class="form-control @error('codigo_correlativo') is-invalid @enderror" value="{{ old('codigo_correlativo', $inscripcion?->codigo_correlativo) }}" id="codigo_correlativo" placeholder="Escribe el nombre del grado">
                                    {!! $errors->first('codigo_correlativo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>

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

            </div>
        </div>
    </div>
@endsection
