@extends('layouts.app')

@section('template_title')
    {{ $inscripcion->name ?? __('Mostrar') . " " . __('Inscripción') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('Detalle de la Inscripción') }}</h4>
                        <a class="btn btn-warning btn-sm" href="{{ route('inscripcions.index') }}">
                            {{ __('Regresar') }}
                        </a>
                    </div>

                    <div class="card-body bg-light">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>{{ __('Nombre del alumno') }}</th>
                                <td>{{ $inscripcion->RegistroAlumno->nombres}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Apellido del alumno') }}</th>
                                <td>{{ $inscripcion->RegistroAlumno->apellidos }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Grado') }}</th>
                                <td>{{ $inscripcion->grado->nombre_grado}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Sección') }}</th>
                                <td>{{ $inscripcion->seccion->seccion}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
