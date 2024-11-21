@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Tipopago
@endsection

@section('content')
    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="font-weight-bold">
                        <h4>{{ __('Editar') }} Pago</h4>
                    </h4>
                </div>
                        <form method="POST" action="{{ route('tipopagos.update', $tipopago->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf
                            <div class="row">

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
