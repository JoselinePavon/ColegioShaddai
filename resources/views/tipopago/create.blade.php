@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Tipopago
@endsection

@section('content')
    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="font-weight-bold">
                        <i class="bi bi-wallet"></i> {{ __('Registrar') }} Pago
                    </h4>
                </div>

                <!-- Formulario de Pago -->
                <form method="POST" action="{{ route('tipopagos.store') }}" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Incluye el contenido del formulario tipopago -->
                        @include('tipopago.form')
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('tipopagos.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-times"></i> {{ __('Cancelar') }}
                        </a>
                        <button type="submit" class="btn btn-dark">
                            <i class="fas fa-save"></i> {{ __('Guardar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

