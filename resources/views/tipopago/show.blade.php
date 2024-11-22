@extends('layouts.app')

@section('template_title')
    Detalle del Tipo de Pago
@endsection

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-start mb-4">
            <a href="{{ route('tipopagos.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> {{ __('Regresar') }}
            </a>
        </div>

        <!-- Detalle del Tipo de Pago -->
        <div class="card border-0 shadow-lg rounded-lg">
            <div class="card-header bg-primary text-white rounded-top">
                <h5 class="mb-0">
                    <i class="fas fa-wallet me-2"></i> Detalle del Tipo de Pago
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th><i class="fas fa-receipt text-primary me-2"></i> {{ __('Tipo de Pago') }}</th>
                        <td>{{ $tipopago->tipo_pago }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-dollar-sign text-primary me-2"></i> {{ __('Monto') }}</th>
                        <td>{{ $tipopago->monto }}</td>
                    </tr>
                    </tbody>
                </table>
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
    </style>
@endsection
