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
                        <h4 class="mb-0">{{ __('Detalle del Alumno Inscrito') }}</h4>
                        <a class="btn btn-warning btn-sm" href="{{ route('inscripcions.index') }}">
                            {{ __('Regresar') }}
                        </a>
                    </div>

                    <div class="card-body bg-light">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>{{ __('Nombres') }}</th>
                                <td>{{ $inscripcion->nombres }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Apellidos') }}</th>
                                <td>{{ $inscripcion->apellidos }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Género') }}</th>
                                <td>{{ $inscripcion->genero }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Edad') }}</th>
                                <td>{{ $inscripcion->edad }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Fecha de Nacimiento') }}</th>
                                <td>{{ $inscripcion->fecha_nacimiento }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
