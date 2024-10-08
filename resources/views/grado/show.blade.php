@extends('layouts.app')

@section('template_title')
    {{ $grado->name ?? __('Mostrar') . " " . __('Grado') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('Detalle del Grado') }}</h4>
                        <a class="btn btn-warning btn-sm" href="{{ route('grados.index') }}">
                            {{ __('Regresar') }}
                        </a>
                    </div>

                    <div class="card-body bg-light">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>{{ __('Nombre Grado') }}</th>
                                <td>{{ $grado->nombre_grado }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

