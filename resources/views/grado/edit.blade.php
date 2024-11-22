@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Grado
@endsection

@section('content')
    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="font-weight-bold"> <i class="bi bi-pencil-fill"></i>
                        {{ __('Editar') }} Grado</h4>
                </div>

                <!-- Formulario de Grado -->
                <form method="POST" action="{{ route('grados.update', $grado->id) }}" role="form" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="row">
                        <!-- Incluye el contenido del formulario grado -->
                        @include('grado.form')
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('grados.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-times"></i> {{ __('Cancelar') }}
                        </a>
                        <button type="submit" class="btn btn-dark">
                            <i class="fas fa-save"></i> {{ __('Actualizar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

