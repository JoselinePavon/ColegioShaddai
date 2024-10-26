@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Pago
@endsection

@section('content')
    <div class="card-body">
        <!-- Formulario de búsqueda -->
        <form method="GET" action="{{ route('resultadosp') }}" class="text-center">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" id="search" name="search" placeholder="Buscar por Nombre o Código de Barra">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>

        @if(isset($alumnos) && $alumnos->count() === 0)
            <p class="text-danger mt-3">No se encontraron resultados para la búsqueda.</p>
        @endif

        <form method="POST" action="{{ route('pagos.store') }}">
            @csrf

            <input type="hidden" name="registro_alumnos_id" value="{{ $alumno->id ?? '' }}">
            <input type="hidden" name="fecha_pago" value="{{ now()->toDateString() }}">
            <div class="form-group">
                <label for="alumno_id" class="form-label">ID del Alumno</label>
                <input type="text" id="alumno_id" class="form-control" value="{{ $alumno->id ?? '' }}" readonly>
                <input type="hidden" name="registro_alumnos_id" value="{{ $alumno->id ?? '' }}">
            </div>

            <div class="form-group">
                <label for="alumno_nombre" class="form-label">Nombre del Alumno</label>
                <input type="text" id="alumno_nombre" class="form-control" value="{{ $alumno->nombres ?? '' }}" readonly>
            </div>

            <div class="form-group">
                <label for="grado" class="form-label">Grado Asignado</label>
                <input type="text" id="grado" class="form-control" value="{{ $grado->nombre_grado ?? 'Sin asignar' }}" readonly>
            </div>

            <div class="row padding-1 p-1">
                <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="num_serie" class="form-label">{{ __('Num Serie') }}</label>
            <input type="text" name="num_serie" class="form-control @error('num_serie') is-invalid @enderror" value="{{ old('num_serie', $pago?->num_serie) }}" id="num_serie" placeholder="Num Serie">
            {!! $errors->first('num_serie', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

                    <div class="form-group mb-3">
                        <label for="fecha_pago" class="form-label">{{ __('Fecha Pago') }}</label>
                        <input type="date" id="fecha_pago" name="fecha_pago" class="form-control" value="{{ now()->toDateString() }}" readonly>
                    </div>

                    <div class="form-group mb-2 mb20">
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

                    <div class="form-group mb-2 mb20">
                        <label for="monto" class="form-label">{{ __('Monto') }}</label>
                        <input type="text" id="monto" class="form-control" readonly>
                    </div>

                    <div class="col-md-12 mt20 mt-2">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
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
