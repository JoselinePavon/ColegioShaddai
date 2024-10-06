@extends('layouts.app')

@section('template_title')
    {{ __('Registro de Grados') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-warning text-dark">
                        <h4>{{ __('Registro de Grados') }}</h4>
                    </div>

                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('grados.store') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="nombre_grado" class="form-label">{{ __('Nombre Grado') }}</label>
                                <input type="text" name="nombre_grado" class="form-control @error('nombre_grado') is-invalid @enderror" value="{{ old('nombre_grado', $grado?->nombre_grado) }}" id="nombre_grado" placeholder="Nombre Grado">
                                {!! $errors->first('nombre_grado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                                    <a href="{{ route('grados.index') }}" class="btn btn-danger">{{ __('Cancelar') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



