@extends('layouts.app')

@section('template_title')
    {{ $tipopago->name ?? __('Mostrar') . " " . __('Tipopago') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('Detalle del Tipo de Pago') }}</h4>
                        <a class="btn btn-warning btn-sm" href="{{ route('tipopagos.index') }}">
                            {{ __('Regresar') }}
                        </a>
                    </div>

                    <div class="card-body bg-light">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>{{ __('Tipo Pago') }}</th>
                                <td>{{ $tipopago->tipo_pago }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Monto') }}</th>
                                <td>{{ $tipopago->monto }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

