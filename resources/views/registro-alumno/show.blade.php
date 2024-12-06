@extends('layouts.app')

@section('template_title')
    Detalle del Alumno
@endsection

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-start mb-4">
            <a href="{{ route('registro-alumnos.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> {{ __('Regresar') }}
            </a>
        </div>

        <!-- Tablas lado a lado -->
        <div class="row">
            <!-- Información del Alumno -->
            <div class="col-md-6">
                <div class="card border-0 shadow-lg mb-4 rounded-lg">
                    <div class="card-header bg-primary text-white rounded-top">
                        <h5 class="mb-0">
                            <i class="fas fa-user-circle me-2"></i> Información del Alumno
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th><i class="fas fa-id-card text-primary me-2"></i> {{ __('Código Personal') }}</th>
                                <td>{{ $registroAlumno->codigo_personal }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-signature text-primary me-2"></i> {{ __('Nombres') }}</th>
                                <td>{{ $registroAlumno->nombres }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-signature text-primary me-2"></i> {{ __('Apellidos') }}</th>
                                <td>{{ $registroAlumno->apellidos }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-venus-mars text-primary me-2"></i> {{ __('Género') }}</th>
                                <td>{{ $registroAlumno->genero }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-birthday-cake text-primary me-2"></i> {{ __('Edad') }}</th>
                                <td>{{ $registroAlumno->edad }} años</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-alt text-primary me-2"></i> {{ __('Fecha de Nacimiento') }}</th>
                                <td>{{ \Carbon\Carbon::parse($registroAlumno->fecha_nacimiento)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-graduation-cap text-primary me-2"></i> {{ __('Grado') }}</th>
                                <td>{{ ($registroAlumno->inscripcion->grado->nombre_grado)}} - {{ $registroAlumno->inscripcion->grado->nivel->nivel }} </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-chalkboard-teacher text-primary me-2"></i> {{ __('Seccion') }}</th>
                                <td>{{ ($registroAlumno->inscripcion->seccion->seccion)}}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-clock text-primary me-2"></i> {{ __('Jornada') }}</th>
                                <td>{{ ($registroAlumno->inscripcion->jornada)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Detalle del Encargado -->
            <div class="col-md-6">
                <div class="card border-0 shadow-lg mb-4 rounded-lg">
                    <div class="card-header bg-secondary text-white rounded-top">
                        <h5 class="mb-0">
                            <i class="fas fa-user-friends me-2"></i> Detalle del Encargado
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($registroAlumno->encargado)
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <th><i class="fas fa-user text-secondary me-2"></i> {{ __('Nombre Encargado') }}</th>
                                    <td>{{ $registroAlumno->encargado->nombre_encargado }}</td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-person-badge text-secondary me-2"></i>{{ __('Edad') }}</th>
                                    <td>{{ $registroAlumno->encargado->edad_encargado }} años</td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-people-fill text-secondary me-2"></i>{{ __('Estado Civil') }}</th>
                                    <td>{{ $registroAlumno->encargado->estado_civil }}</td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-briefcase-fill text-secondary me-2"></i> {{ __('Oficio') }}</th>
                                    <td>{{ $registroAlumno->encargado->oficio }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-id-card text-secondary me-2"></i> {{ __('DPI') }}</th>
                                    <td>{{ $registroAlumno->encargado->dpi }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-map-marker-alt text-secondary me-2"></i> {{ __('Lugar') }}</th>
                                    <td>{{ $registroAlumno->encargado->lugar->lugar ?? 'No asignado' }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-map-marker-alt text-secondary me-2"></i> {{ __('Colonia') }}</th>
                                    <td>{{ $registroAlumno->encargado->colonia->nombre ?? 'No asignada' }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-phone text-secondary me-2"></i> {{ __('Teléfono') }}</th>
                                    <td>{{ $registroAlumno->encargado->telefono }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-exclamation-circle text-secondary me-2"></i> {{ __('Contacto de Emergencia') }}</th>
                                    <td>{{ $registroAlumno->encargado->persona_emergencia }}</td>
                                </tr>
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-info-circle me-2"></i> No se encontró un encargado asignado a este alumno.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: scale(1.01);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        th {
            font-weight: 600;
            color: #343a40;
        }
        td {
            font-size: 1rem;
            color: #6c757d;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }
        .bg-primary {
            background-color: #007bff !important;
        }
        .bg-secondary {
            background-color: #6c757d !important;
        }
    </style>
@endsection
