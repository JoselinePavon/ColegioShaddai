@extends('layouts.app')

@section('template_title')
    Detalle del Alumno
@endsection

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('registro-alumnos.index') }}" class="btn btn-outline-dark btn-sm rounded-pill">
                <i class="fas fa-arrow-left mr-1"></i> {{ __('Regresar') }}
            </a>
        </div>

        <!-- Información del Alumno -->
        <div class="card border-0 shadow-sm mb-4 rounded-lg">
            <div class="card-header bg-light border-bottom-0">
                <h5 class="mb-0 text-muted"><i class="fas fa-user-circle mr-2"></i> Información del Alumno</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                    <tr>
                        <th class="text-dark"><i class="fas fa-signature text-muted mr-2"></i> {{ __('Codigo Personal') }}</th>
                        <td class="text-secondary">{{ $registroAlumno->codigo_personal }}</td>
                    </tr>
                    <tr>
                        <th class="text-dark"><i class="fas fa-signature text-muted mr-2"></i> {{ __('Nombres') }}</th>
                        <td class="text-secondary">{{ $registroAlumno->nombres }}</td>
                    </tr>
                    <tr>
                        <th class="text-dark"><i class="fas fa-signature text-muted mr-2"></i> {{ __('Apellidos') }}</th>
                        <td class="text-secondary">{{ $registroAlumno->apellidos }}</td>
                    </tr>
                    <tr>
                        <th class="text-dark"><i class="fas fa-venus-mars text-muted mr-2"></i> {{ __('Género') }}</th>
                        <td class="text-secondary">{{ $registroAlumno->genero }}</td>
                    </tr>
                    <tr>
                        <th class="text-dark"><i class="fas fa-birthday-cake text-muted mr-2"></i> {{ __('Edad') }}</th>
                        <td class="text-secondary">{{ $registroAlumno->edad }} años</td>
                    </tr>
                    <tr>
                        <th class="text-dark"><i class="fas fa-calendar-alt text-muted mr-2"></i> {{ __('Fecha de Nacimiento') }}</th>
                        <td class="text-secondary">{{ \Carbon\Carbon::parse($registroAlumno->fecha_nacimiento)->format('d/m/Y') }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detalle del Encargado -->
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-light border-bottom-0">
                <h5 class="mb-0 text-muted"><i class="fas fa-user-friends mr-2"></i> Detalle del Encargado</h5>
            </div>
            <div class="card-body">
                @if ($registroAlumno->encargado)
                    <table class="table table-borderless mb-0">
                        <tbody>
                        <tr>
                            <th class="text-dark"><i class="fas fa-user text-muted mr-2"></i> {{ __('Nombre Encargado') }}</th>
                            <td class="text-secondary">{{ $registroAlumno->encargado->nombre_encargado }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark"><i class="fas fa-map-marker-alt text-muted mr-2"></i> {{ __('DPI') }}</th>
                            <td class="text-secondary">{{ $registroAlumno->encargado->dpi }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark"><i class="fas fa-map-marker-alt text-muted mr-2"></i> {{ __('Lugar') }}</th>
                            <td class="text-secondary">{{ $registroAlumno->encargado->lugar->lugar ?? 'No asignado' }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark"><i class="fas fa-map-marker-alt text-muted mr-2"></i> {{ __('Colonia') }}</th>
                            <td class="text-secondary">{{ $registroAlumno->encargado->colonia->nombre ?? 'No asignada' }}</td>
                        </tr>

                        <tr>
                            <th class="text-dark"><i class="fas fa-phone text-muted mr-2"></i> {{ __('Teléfono 1') }}</th>
                            <td class="text-secondary">{{ $registroAlumno->encargado->telefono }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark"><i class="fas fa-exclamation-circle text-muted mr-2"></i> {{ __('Contacto de Emergencia') }}</th>
                            <td class="text-secondary">{{ $registroAlumno->encargado->persona_emergencia }}</td>
                        </tr>
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-light border text-muted">
                        <i class="fas fa-info-circle mr-2"></i> No se encontró un encargado asignado a este alumno.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: scale(1.01);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        }
        .table-borderless tbody tr th {
            font-weight: bold;
            color: #343a40;
        }
        .table-borderless tbody tr td {
            color: #6c757d;
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
@endsection

