@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Inscripcion
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-warning text-dark">
                        <h4>{{ __('Editar') }} Inscripción</h4>
                    </div>

                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('inscripcions.update', $inscripcion->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('inscripcion.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
