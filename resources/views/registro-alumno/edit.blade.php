@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Registro Alumno
@endsection

@section('content')


                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('registro-alumnos.update', $registroAlumno->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('registro-alumno.formedit')

                        </form>
                    </div>

@endsection
