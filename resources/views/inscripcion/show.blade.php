@extends('layouts.app')

@section('template_title')
    Detalle de la Inscripción
@endsection

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-start mb-4">
            <a href="{{ route('inscripcions.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">
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
                                <th><i class="fas fa-user text-primary me-2"></i> {{ __('Nombre del Alumno') }}</th>
                                <td>{{ $inscripcion->RegistroAlumno->nombres }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-user text-primary me-2"></i> {{ __('Apellido del Alumno') }}</th>
                                <td>{{ $inscripcion->RegistroAlumno->apellidos }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-venus-mars text-primary me-2"></i> {{ __('Género') }}</th>
                                <td>{{ $inscripcion->RegistroAlumno->genero }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-birthday-cake text-primary me-2"></i> {{ __('Edad') }}</th>
                                <td>{{ $inscripcion->RegistroAlumno->edad }} años</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-alt text-primary me-2"></i> {{ __('Fecha de Nacimiento') }}</th>
                                <td>{{ \Carbon\Carbon::parse($inscripcion->RegistroAlumno->fecha_nacimiento)->format('d/m/Y') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Información Académica -->
            <div class="col-md-6">
                <div class="card border-0 shadow-lg mb-4 rounded-lg">
                    <div class="card-header bg-secondary text-white rounded-top">
                        <h5 class="mb-0">
                            <i class="fas fa-graduation-cap me-2"></i> Información Académica
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th><i class="fas fa-graduation-cap text-secondary me-2"></i> {{ __('Grado') }}</th>
                                <td>{{ $inscripcion->grado->nombre_grado }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-users text-secondary me-2"></i> {{ __('Sección') }}</th>
                                <td>{{ $inscripcion->seccion->seccion }}</td>
                            </tr>
                            </tbody>
                        </table>
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

