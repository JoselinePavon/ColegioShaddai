@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Inscripcion
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
                        <form method="POST" action="{{ route('inscripcions.update', $inscripcion->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('inscripcion.form')

                        </form>
                    </div>
                </div>

@endsection
