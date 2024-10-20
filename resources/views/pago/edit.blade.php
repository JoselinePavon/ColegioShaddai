@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Pago
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-warning text-dark">
                        <h4>{{ __('Editar') }} Pago</h4>
                    </div>

                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('pagos.update', $pago->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('pago.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
