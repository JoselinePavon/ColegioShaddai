@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Registro Alumno
@endsection

@section('content')
    <div class="container mt-2">

                        <form method="POST" action="{{ route('registro-alumnos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('registro-alumno.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
