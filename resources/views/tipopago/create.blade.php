@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Tipopago
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-warning text-dark">
                        <h4>{{ __('Registrar') }} Pago</h4>
                    </div>

                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('tipopagos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('tipopago.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
