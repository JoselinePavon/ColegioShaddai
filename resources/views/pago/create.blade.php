@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Pago
@endsection

@section('content')
    <div class="container">
                        <form method="POST" action="{{ route('pagos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('pago.form')

                        </form>
                    </div>



@endsection
