@extends('layouts.app')

@section('template_title')
    {{ __('Registro de Pago') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-warning text-dark">
                        <h4>{{ __('Registro de Pago') }}</h4>
                    </div>

                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('pagos.store') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="num_serie" class="form-label">{{ __('Num Serie') }}</label>
                                <input type="text" name="num_serie" class="form-control @error('num_serie') is-invalid @enderror" value="{{ old('num_serie', $pago?->num_serie) }}" id="num_serie" placeholder="Num Serie">
                                {!! $errors->first('num_serie', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="tipo_pago" class="form-label">{{ __('Tipo Pago') }}</label>
                                <input type="text" name="tipo_pago" class="form-control @error('tipo_pago') is-invalid @enderror" value="{{ old('tipo_pago', $pago?->tipo_pago) }}" id="tipo_pago" placeholder="Ej. Mensualidad - Enero">
                                {!! $errors->first('tipo_pago', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="costo_pago" class="form-label">{{ __('Costo Pago') }}</label>
                                <input type="text" name="costo_pago" class="form-control @error('costo_pago') is-invalid @enderror" value="{{ old('costo_pago', $pago?->costo_pago) }}" id="costo_pago" placeholder="Costo Pago">
                                {!! $errors->first('costo_pago', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="nombre_alumno" class="form-label">{{ __('Nombre Alumno') }}</label>
                                <input type="text" name="nombre_alumno" class="form-control @error('nombre_alumno') is-invalid @enderror" value="{{ old('nombre_alumno', $pago?->nombre_alumno) }}" id="nombre_alumno" placeholder="Nombre Alumno">
                                {!! $errors->first('nombre_alumno', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="grado" class="form-label">{{ __('Grado') }}</label>
                                <input type="text" name="grado" class="form-control @error('grado') is-invalid @enderror" value="{{ old('grado', $pago?->grado) }}" id="grado" placeholder="Grado">
                                {!! $errors->first('grado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="fecha_pago" class="form-label">{{ __('Fecha Pago') }}</label>
                                <input type="date" name="fecha_pago" class="form-control @error('fecha_pago') is-invalid @enderror" value="{{ old('fecha_pago', $pago?->fecha_pago) }}" id="fecha_pago">
                                {!! $errors->first('fecha_pago', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                                    <a href="{{ route('pagos.index') }}" class="btn btn-danger">{{ __('Cancelar') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
