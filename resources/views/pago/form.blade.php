@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Pago
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-warning text-dark">
                        <h4>{{ __('Registrar') }} Pago</h4>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card-body bg-light">
        <!-- Formulario de búsqueda -->
                        <form method="GET" action="{{ route('resultadosp') }}" class="mb-3">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <div class="input-group input-group-ml">
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Buscar">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-ml" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="alumno_id" class="form-label">ID del Alumno</label>
                                        <input type="text" id="alumno_id" class="form-control" value="{{ $alumno->id ?? '' }}" readonly>
                                        <input type="hidden" name="registro_alumnos_id" value="{{ $alumno->id ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="alumno_nombre" class="form-label">Nombre del Alumno</label>
                                        <input type="text" id="alumno_nombre" class="form-control" value="{{ $alumno->nombres ?? '' }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="grado" class="form-label">Grado Asignado</label>
                                        <input type="text" id="grado" class="form-control" value="{{ $grado->nombre_grado ?? 'Sin asignar' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if(isset($alumno) && is_null($alumno))
                            <p class="text-danger mt-3">Alumno no encontrado.</p>
                        @endif

        <form method="POST" action="{{ route('pagos.store') }}">
            @csrf

            <input type="hidden" name="registro_alumnos_id" value="{{ $alumno->id ?? '' }}">
            <input type="hidden" name="fecha_pago" value="{{ now()->toDateString() }}">


            <!-- Each Field in Its Own Row -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <label for="num_serie" class="form-label">{{ __('Num Serie') }}</label>
                        <input type="text" name="num_serie" class="form-control @error('num_serie') is-invalid @enderror" value="{{ old('num_serie', $pago?->num_serie) }}" id="num_serie" placeholder="Num Serie">
                        {!! $errors->first('num_serie', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="fecha_pago" class="form-label">{{ __('Fecha Pago') }}</label>
                        <input type="date" id="fecha_pago" name="fecha_pago" class="form-control" value="{{ now()->toDateString() }}" readonly>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <label for="tipopagos_id" class="form-label">{{ __('Tipo de Pago') }}</label>
                        <select name="tipopagos_id" class="form-control @error('tipopagos_id') is-invalid @enderror" id="tipopagos_id">
                            <option value="" disabled selected>Selecciona un tipo de pago</option>
                            @foreach($tipos as $id => $tipo_pago)
                                <option value="{{ $id }}" {{ old('tipopagos_id', $pago?->tipopagos_id) == $id ? 'selected' : '' }}>
                                    {{ $tipo_pago }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('tipopagos_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <label for="monto" class="form-label">{{ __('Monto') }}</label>
                        <input type="text" id="monto" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3 text-center">
                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
        </form>
    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Asegúrate de que la variable montos esté disponible aquí
        const montos = @json($montos); // Convierte el array PHP a JavaScript
        const tipoPagosSelect = document.getElementById('tipopagos_id');
        const montoInput = document.getElementById('monto');

        tipoPagosSelect.addEventListener('change', function() {
            const selectedId = this.value;
            montoInput.value = montos[selectedId] || ''; // Asigna el monto al input
        });
    </script>
@endsection


