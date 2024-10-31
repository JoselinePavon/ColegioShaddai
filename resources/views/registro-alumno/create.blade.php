@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Registro Alumno
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-warning text-dark">
                        <h4><i class="fas fa-user"></i>
                            {{ __('Registrar') }} Alumno</h4>
                    </div>

                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('registro-alumnos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('registro-alumno.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
