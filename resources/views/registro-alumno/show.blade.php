@extends('layouts.app')

@section('template_title')
    {{ $registroAlumno->name ?? __('Mostrar') . " " . __('Registro Alumno') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('Detalle del Registro del Alumno') }}</h4>
                        <a class="btn btn-warning btn-sm" href="{{ route('registro-alumnos.index') }}">
                            {{ __('Regresar') }}
                        </a>
                    </div>

                    <div class="card-body bg-light">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>{{ __('Nombres') }}</th>
                                <td>{{ $registroAlumno->nombres }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Apellidos') }}</th>
                                <td>{{ $registroAlumno->apellidos }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Género') }}</th>
                                <td>{{ $registroAlumno->genero }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Edad') }}</th>
                                <td>{{ $registroAlumno->edad }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Fecha de Nacimiento') }}</th>
                                <td>{{ $registroAlumno->fecha_nacimiento }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

