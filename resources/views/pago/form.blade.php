@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Pago
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4"> <i class="bi bi-cash"></i> Formulario de Pago</h1>
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Información del Alumno</h5>

                        <!-- Mostrar el mensaje de error si el alumno no fue encontrado -->
                        @if(isset($error))
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endif

                        <!-- Formulario de búsqueda del alumno -->
                        <form method="GET" action="{{ route('resultadosp') }}" class="mb-3">
                            <div class="row align-items-end">
                                <div class="mb-3">
                                    <div class="input-group input-group-ml">
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Buscar por Nombre o No. Correlativo" value="{{ old('search', request('search')) }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-ml" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Datos del alumno encontrados -->
                            <div class="row align-items-end">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="alumno_id" class="form-label">ID del Alumno</label>
                                        <input type="text" id="alumno_id" class="form-control" value="{{ old('alumno_id', $alumno->id ?? '') }}" readonly>
                                        <input type="hidden" name="registro_alumnos_id" value="{{ old('registro_alumnos_id', $alumno->id ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="alumno_nombre" class="form-label">Nombre del Alumno</label>
                                        <input type="text" id="alumno_nombre" class="form-control" value="{{ old('alumno_nombre', $alumno->nombres ?? '') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-end">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="grado" class="form-label">Grado Asignado</label>
                                        <input type="text" id="grado" class="form-control" value="{{ old('grado', $grado->nombre_grado ?? '') }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="seccion" class="form-label">Sección Asignada</label>
                                        <input type="text" id="seccion" class="form-control" value="{{ old('seccion', $seccion->seccion ?? '') }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Formulario de pago -->
                        <h5 class="card-title">Información de Pago</h5>
                        <form method="POST" action="{{ route('pagos.store') }}" class="mb-3">
                            @csrf

                            <input type="hidden" name="registro_alumnos_id" value="{{ old('registro_alumnos_id', $alumno->id ?? '') }}">
                            <input type="hidden" name="fecha_pago" value="{{ old('fecha_pago', now()->toDateString()) }}">

                            <!-- Campos del formulario de pago -->
                            <div class="row align-items-end">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="num_serie" class="form-label">Número de boleta</label>
                                        <input type="text" name="num_serie" class="form-control @error('num_serie') is-invalid @enderror" value="{{ old('num_serie', $pago?->num_serie) }}" id="num_serie" placeholder="Número de Boleta">
                                        {!! $errors->first('num_serie', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="mes_id" class="form-label">{{ __('Mes') }}</label>
                                    <select name="mes_id" class="form-select @error('mes_id') is-invalid @enderror" id="mes_id">
                                        <option value="">Seleccione una sección</option>
                                        @foreach($mes as $id => $mes)
                                            <option value="{{ $id }}" {{ old('mes_id', $pago->mes_id ?? '') == $id ? 'selected' : '' }}>
                                                {{ $mes }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('seccions_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="fecha_pago" class="form-label">{{ __('Fecha Pago') }}</label>
                                        <input type="date" id="fecha_pago" name="fecha_pago" class="form-control" value="{{ old('fecha_pago', now()->toDateString()) }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Selector de tipo de pago -->
                            <div class="row align-items-end">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="tipopagos_id" class="form-label">{{ __('Tipo de Pago') }}</label>
                                        <select name="tipopagos_id" id="tipopagos_id" class="form-control @error('tipopagos_id') is-invalid @enderror">
                                            <option value="" disabled selected>Selecciona un tipo de pago</option>
                                            @foreach($tipos as $id => $tipo_pago)
                                                <option value="{{ $id }}" {{ old('tipopagos_id') == $id ? 'selected' : '' }}>
                                                    {{ $tipo_pago }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('tipopagos_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>
                                </div>

                                <!-- Campo de monto para mostrar el valor del tipo de pago seleccionado -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="monto" class="form-label">{{ __('Monto') }}</label>
                                        <input type="text" id="monto" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 text-center">
                                <button type="submit" class="btn btn-primary">{{ __('Realizar Pago') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Columna de Resumen del Pedido -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Resumen del Pedido</h5>
                        <ul id="resumen-lista" class="list-group list-group-flush"></ul>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total</strong>
                            <strong id="resumen-total">$0.00</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Variables
        const pagosPorMes = @json($pagosPorMes ?? []); // [{mes_id: 1, tipopagos_id: 1}, ...]
        let alertShown = false; // Control de mensaje único
        const montos = @json($montos);
        const tipoPagosSelect = document.getElementById('tipopagos_id');
        const mesSelect = document.getElementById('mes_id');
        const montoInput = document.getElementById('monto');
        const resumenLista = document.getElementById('resumen-lista');
        const resumenTotal = document.getElementById('resumen-total');

        // Función para validar el tipo de pago y mes seleccionado
        function validarPago() {
            const selectedTipoPagoId = tipoPagosSelect.value;
            const selectedMesId = mesSelect.value;

            // Limpiar mensajes previos
            const existingError = document.querySelector('.alert-danger');
            if (existingError) existingError.remove();
            alertShown = false;

            // Mostrar mensaje de advertencia si es colegiatura y el mes ya fue pagado
            if (selectedTipoPagoId === '1' && selectedMesId) {
                const yaPagado = pagosPorMes.some(pago =>
                    parseInt(pago.mes_id) === parseInt(selectedMesId) &&
                    parseInt(pago.tipopagos_id) === parseInt(selectedTipoPagoId)
                );

                if (yaPagado) {
                    const errorDiv = document.createElement('div');
                    errorDiv.classList.add('alert', 'alert-danger');
                    errorDiv.textContent = 'El alumno ya ha pagado la colegiatura para este mes.';
                    document.querySelector('.card-body').prepend(errorDiv);

                    // Restablecer la selección del tipo de pago
                    tipoPagosSelect.value = '';
                    alertShown = true;
                    return false; // Detener el proceso
                }
            }

            // Actualizar el monto si todo está en orden
            actualizarMonto();
            return true; // Continuar el proceso
        }

        // Función para calcular y actualizar el total del resumen
        function actualizarMonto() {
            const selectedTipoPagoId = tipoPagosSelect.value;
            const monto = montos[selectedTipoPagoId] || 0;
            montoInput.value = monto;
        }

        // Event listeners para cambios en el tipo de pago y mes
        tipoPagosSelect.addEventListener('change', validarPago);
        mesSelect.addEventListener('change', validarPago);
    </script>

@endsection
