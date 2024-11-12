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
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Buscar por Nombre o No. Carnet" value="{{ old('search', request('search')) }}">
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

    <!-- Scripts -->
    <script>
        // Variables
        const alumnoYaPagoColegiatura = @json($alumnoYaPagoColegiatura);
        let alertShown = false; // Control de mensaje único
        const montos = @json($montos);
        const tipoPagosSelect = document.getElementById('tipopagos_id');
        const montoInput = document.getElementById('monto');
        const resumenLista = document.getElementById('resumen-lista');
        const resumenTotal = document.getElementById('resumen-total');

        // Actualizar el monto según el tipo de pago seleccionado y añadir al resumen
        tipoPagosSelect.addEventListener('change', function() {
            const selectedId = this.value;

            // Mostrar mensaje de advertencia si es colegiatura y ya fue pagada
            if (selectedId == '1' && alumnoYaPagoColegiatura && !alertShown) {
                const errorDiv = document.createElement('div');
                errorDiv.classList.add('alert', 'alert-danger');
                errorDiv.textContent = 'El alumno ya ha pagado la colegiatura para este mes.';
                document.querySelector('.card-body').prepend(errorDiv);

                // Restablecer la selección del tipo de pago y marcar la alerta como mostrada
                this.value = '';
                alertShown = true;
                return;
            }

            // Obtener y asignar el monto al campo de monto y al resumen
            const monto = montos[selectedId] || 0;
            montoInput.value = monto;

            // Agregar el elemento al resumen
            const item = document.createElement('li');
            item.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
            item.innerHTML = `${tipoPagosSelect.options[tipoPagosSelect.selectedIndex].text} <span>$${monto}</span>`;
            resumenLista.appendChild(item);

            // Actualizar el total en el resumen
            actualizarTotal();
        });

        // Función para calcular y actualizar el total del resumen
        function actualizarTotal() {
            let total = 0;
            resumenLista.querySelectorAll('li span').forEach(span => {
                total += parseFloat(span.textContent.replace('Q', ''));
            });
            resumenTotal.textContent = `$${total.toFixed(2)}`;
        }
    </script>
@endsection
