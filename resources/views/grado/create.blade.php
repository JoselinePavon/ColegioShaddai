@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Grado
@endsection

@section('content')
    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="font-weight-bold"> <i class="bi bi-journal-bookmark"></i> {{ __('Registrar') }} Grado</h4>
                </div>

                <!-- Formulario de Grado -->
                <form method="POST" action="{{ route('grados.store') }}" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Incluye el contenido del formulario grado -->
                        @include('grado.form')
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('grados.index') }}" class="btn btn-outline-danger">
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

