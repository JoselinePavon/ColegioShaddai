@extends('layouts.app')

@section('template_title')

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
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('Detalle del encargado') }}</h4>
                    </div>
                    <div class="card-body bg-light">
                        <table class="table table-bordered">
                            <tbody>
                            @if ($registroAlumno->encargado)
                                <tr>
                                    <th>{{ __('Nombre Encargado') }}</th>
                                    <td>{{ $registroAlumno->encargado->nombre_encargado }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Dirección') }}</th>
                                    <td>{{ $registroAlumno->encargado->direccion }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Número de telefono 1') }}</th>
                                    <td>{{ $registroAlumno->encargado->num_encargado1 }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Número de telefono 2') }}</th>
                                    <td>{{ $registroAlumno->encargado->num_encargado2 }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Persona de Emergencia') }}</th>
                                    <td>{{ $registroAlumno->encargado->persona_emergencia }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="2">
                                        <p>No se encontró un encargado asignado a este alumno.</p>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                </div>

                </div>
        </div>
    </section>
@endsection
