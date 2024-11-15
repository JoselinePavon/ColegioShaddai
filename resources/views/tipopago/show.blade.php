@extends('layouts.app')

@section('template_title')
    {{ $tipopago->name ?? __('Mostrar') . " " . __('Tipo de Pago') }}
@endsection

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('tipopagos.index') }}" class="btn btn-outline-dark btn-sm rounded-pill">
                <i class="fas fa-arrow-left mr-1"></i> {{ __('Regresar') }}
            </a>
        </div>

        <!-- Detalle del Tipo de Pago -->
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-light border-bottom-0">
                <h5 class="mb-0 text-muted"><i class="fas fa-wallet mr-2"></i> Detalle del Tipo de Pago</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                    <tr>
                        <th class="text-dark"><i class="fas fa-receipt text-muted mr-2"></i> {{ __('Tipo Pago') }}</th>
                        <td class="text-secondary">{{ $tipopago->tipo_pago }}</td>
                    </tr>
                    <tr>
                        <th class="text-dark"><i class="fas fa-dollar-sign text-muted mr-2"></i> {{ __('Monto') }}</th>
                        <td class="text-secondary">{{ $tipopago->monto }}</td>
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


