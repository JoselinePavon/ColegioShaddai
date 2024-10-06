@extends('layouts.app')

@section('template_title')
    {{ $pago->name ?? __('Mostrar') . " " . __('Pago') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('Detalle del Pago') }}</h4>
                        <a class="btn btn-warning btn-sm" href="{{ route('pagos.index') }}">
                            {{ __('Regresar') }}
                        </a>
                    </div>

                    <div class="card-body bg-light">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>{{ __('Num Serie') }}</th>
                                <td>{{ $pago->num_serie }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Tipo Pago') }}</th>
                                <td>{{ $pago->tipo_pago }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Costo Pago') }}</th>
                                <td>{{ $pago->costo_pago }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Nombre Alumno') }}</th>
                                <td>{{ $pago->nombre_alumno }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Grado') }}</th>
                                <td>{{ $pago->grado }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Fecha Pago') }}</th>
                                <td>{{ $pago->fecha_pago }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
