@extends('layouts.app')

@section('template_title')
    {{ $inscripcion->name ?? __('Show') . " " . __('Inscripcion') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Inscripcion</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('inscripcions.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mb20">
                            <strong>Registro Alumnos Id:</strong>
                            {{ $inscripcion->registro_alumnos_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Grados Id:</strong>
                            {{ $inscripcion->grados_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Seccions Id:</strong>
                            {{ $inscripcion->seccions_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
