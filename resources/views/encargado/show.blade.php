@extends('layouts.app')

@section('template_title')
    {{ $encargado->name ?? __('Show') . " " . __('Encargado') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Encargado</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('encargados.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre Encargado:</strong>
                            {{ $encargado->nombre_encargado }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Direccion:</strong>
                            {{ $encargado->direccion }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Num Encargado1:</strong>
                            {{ $encargado->num_encargado1 }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Num Encargado2:</strong>
                            {{ $encargado->num_encargado2 }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Persona Emergencia:</strong>
                            {{ $encargado->persona_emergencia }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
