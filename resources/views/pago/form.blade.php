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
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Buscar por Nombre o No. Correlativo" value="{{ old('search', request('search')) }}"  required>
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
                                        <label for="codigo_personal" class="form-label">Codigo del Alumno</label>
                                        <input type="text" id="codigo_personal" class="form-control" value="{{ old('codigo_personal', $alumno->codigo_personal ?? 'Sin Codigo Asignado') }}" readonly>
                                        <input type="hidden" name="registro_alumnos_id" value="{{ old('registro_alumnos_id', $alumno->id ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="alumno_nombre" class="form-label">Nombre del Alumno</label>
                                        <input type="text" id="alumno_nombre" class="form-control"  value="{{ old('alumno_nombre', ($alumno->nombres ?? '') . ' ' . ($alumno->apellidos ?? '')) }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-end">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="grado" class="form-label">Grado Asignado</label>
                                        <input type="text" id="grado" class="form-control"
                                               value="{{ old('grado', $grado->nombre_grado ?? '') }} - {{ old('grado', $grado->nivel->nivel ?? '') }}" readonly>

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
                                    <label for="tipopagos_id" class="form-label">{{ __('Tipo de Pago') }}</label>
                                    <select name="tipopagos_id" id="tipopagos_id" class="form-select @error('tipopagos_id') is-invalid @enderror">
                                        <option value="" disabled selected>Selecciona un tipo de pago</option>
                                        @if($inscripcionPagada)
                                            <p class="text-muted">El pago de inscripción ya ha sido realizado.</p>
                                        @endif
                                        @foreach($tipos as $id => $tipo_pago)
                                            <option value="{{ $id }}" {{ old('tipopagos_id') == $id ? 'selected' : '' }}>
                                                {{ $tipo_pago }}
                                            </option>
                                        @endforeach
                                        <option value="combinado" class="btn btn-sm btn-warning">Pago Combinado</option>
                                    </select>

                                    {!! $errors->first('tipopagos_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>


                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="fecha_pago" class="form-label">{{ __('Fecha Pago') }}</label>
                                        <input type="date" id="fecha_pago" name="fecha_pago" class="form-control" value="{{ old('fecha_pago', now()->toDateString()) }}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="mes_id" class="form-label">{{ __('Mes') }}</label>
                                    <select name="mes_id" class="form-select @error('mes_id') is-invalid @enderror" id="mes_id">
                                        <option value="">Seleccione un mes</option>
                                        @foreach($mes as $id => $mesNombre)
                                            <option value="{{ $id }}" {{ old('mes_id', $pago->mes_id ?? '') == $id ? 'selected' : '' }}>
                                                {{ $mesNombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="hidden_mes_id" name="mes_id" value="{{ old('mes_id', $pago->mes_id ?? '') }}">
                                    @error('mes_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>


                            <!-- Campo Monto -->
                            <div class="row align-items-end">
                                <div class="col-md-6 mb-3" id="monto-section">
                                    <label for="monto" class="form-label">{{ __('Monto') }}</label>
                                    <input type="text" id="monto" name="monto" class="form-control">
                                </div>
                            </div>

                            <!-- Campo Abono -->
                            <div class="row align-items-end" id="abono-section" style="display: none;">
                                <div class="col-md-6 mb-3">
                                    <label for="abono" class="form-label">{{ __('Abono') }}</label>
                                    <input type="text" id="abono" name="abono" class="form-control"
                                           pattern="^\d+(\.\d{1,2})?$"
                                           title="Ingrese un número válido, por ejemplo: 250.50">
                                </div>
                            </div>



                            <!-- Pagos Combinados -->
                            <!-- Pagos Combinados -->
                            <div id="pago-combinado-section" style="display: none;">
                                <h5>Seleccione los pagos que desea combinar:</h5>
                                <div class="d-flex flex-wrap">
                                    @foreach($tipos as $id => $tipo_pago)
                                        @if(!in_array($id, [5, 6]) && ($id !== 1 || !$inscripcionPagada)) <!-- Excluir inscripción si ya fue pagada -->
                                        <div class="form-check me-3 mb-2">
                                            <input class="form-check-input pago-combinado-checkbox" type="checkbox" name="pagos_combinados[]" value="{{ $id }}" id="pago_combinado_{{ $id }}" data-monto="{{ $montos[$id] }}">
                                            <label class="form-check-label" for="pago_combinado_{{ $id }}">
                                                {{ $tipo_pago }} (Q. {{ number_format($montos[$id], 2) }})
                                            </label>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Campo de monto para mostrar el valor del tipo de pago seleccionado -->


                            <div class="col-md-12 mt-3 text-center">
                                <button type="submit" class="btn btn-primary">{{ __('Realizar Pago') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Columna de Resumen del Pedido -->
            <!-- Columna de Resumen del Pedido -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Resumen del Pago del Alumno</h5>
                        <ul id="resumen-lista" class="list-group list-group-flush"></ul>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total</strong>
                            <strong id="resumen-total">Q. 0.00</strong>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tipoPagosSelect = document.getElementById('tipopagos_id');
            const montoSection = document.getElementById('monto-section');
            const abonoSection = document.getElementById('abono-section');
            const abonoInput = document.getElementById('abono');
            const montoInput = document.getElementById('monto');
            const pagoForm = document.querySelector('form'); // Selecciona el formulario principal

            // Manejar el cambio de selección en el tipo de pago
            tipoPagosSelect.addEventListener('change', () => {
                const tiposConAbono = ['5', '6'];

                if (tiposConAbono.includes(tipoPagosSelect.value)) {
                    montoSection.style.display = 'none'; // Ocultar Monto
                    abonoSection.style.display = 'block'; // Mostrar Abono
                } else {
                    montoSection.style.display = 'block'; // Mostrar Monto
                    abonoSection.style.display = 'none'; // Ocultar Abono
                }
            });


            // Validar entrada numérica en Abono
            abonoInput.addEventListener('input', () => {
                if (!/^\d*(\.\d{0,2})?$/.test(abonoInput.value)) {
                    abonoInput.setCustomValidity("Ingrese un número válido, por ejemplo: 250.50");
                } else {
                    abonoInput.setCustomValidity("");
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tipoPagosSelect = document.getElementById('tipopagos_id');
            const combinadoSection = document.getElementById('pago-combinado-section');
            const checkboxes = document.querySelectorAll('.pago-combinado-checkbox');
            const montoInput = document.getElementById('monto');
            const resumenLista = document.getElementById('resumen-lista');
            const resumenTotal = document.getElementById('resumen-total');
            const montos = @json($montos);

            function limpiarCheckboxes() {
                // Desmarca todos los checkboxes de pagos combinados
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                actualizarResumen(); // Actualiza el resumen al limpiar los checkboxes
            }

            function actualizarResumen() {
                let total = 0;
                resumenLista.innerHTML = ''; // Limpia el resumen

                if (tipoPagosSelect.value === 'combinado') {
                    // Caso de pagos combinados
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            const monto = parseFloat(checkbox.dataset.monto);
                            const tipo = checkbox.nextElementSibling.textContent.trim();
                            total += monto;

                            // Agrega al resumen
                            agregarItemResumen(tipo, monto);
                        }
                    });
                } else if (tipoPagosSelect.value) {
                    // Caso de pago individual
                    const selectedTipoPagoId = tipoPagosSelect.value;
                    if (montos[selectedTipoPagoId]) {
                        const monto = parseFloat(montos[selectedTipoPagoId]);
                        const tipo = tipoPagosSelect.options[tipoPagosSelect.selectedIndex].text.trim();
                        total = monto;

                        // Agrega al resumen
                        agregarItemResumen(tipo, monto);
                    }
                }

                // Actualiza el total
                actualizarTotal(total);
            }

            function agregarItemResumen(tipo, monto) {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.textContent = tipo;
                const span = document.createElement('span');
                span.textContent = `Q. ${monto.toFixed(2)}`;
                li.appendChild(span);
                resumenLista.appendChild(li);
            }

// Actualiza el total mostrado en el resumen
            function actualizarTotal(total) {
                resumenTotal.textContent = `Q. ${total.toFixed(2)}`;
                montoInput.value = total > 0 ? `Q. ${total.toFixed(2)}` : '';
            }


            // Evento para mostrar/ocultar la sección de pagos combinados y limpiar checkboxes
            tipoPagosSelect.addEventListener('change', () => {
                if (tipoPagosSelect.value === 'combinado') {
                    combinadoSection.style.display = 'block';
                } else {
                    combinadoSection.style.display = 'none';
                    limpiarCheckboxes(); // Limpia los checkboxes si no es pago combinado
                }
                actualizarResumen();
            });

            // Evento para actualizar el resumen al seleccionar/deseleccionar checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', actualizarResumen);
            });
        });

    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tipoPagosSelect = document.getElementById('tipopagos_id');
            const combinadoSection = document.getElementById('pago-combinado-section');
            const checkboxes = document.querySelectorAll('.pago-combinado-checkbox');
            const mesSelect = document.getElementById('mes_id');
            const montoInput = document.getElementById('monto');
            const hiddenMesInput = document.getElementById('hidden_mes_id');
            const resumenLista = document.getElementById('resumen-lista');
            const resumenTotal = document.getElementById('resumen-total');
            const alertContainer = document.createElement('div');
            const formContainer = document.querySelector('.card-body');
            const pagosPorMes = @json($pagosPorMes ?? []);
            const montos = @json($montos);


            formContainer.prepend(alertContainer);

            function toggleMesField() {
                if (tipoPagosSelect.value === '1') { // Inscripción
                    hiddenMesInput.value = '13'; // Valor fijo para inscripción
                    mesSelect.style.display = 'none'; // Ocultar campo select
                } else {
                    hiddenMesInput.value = mesSelect.value; // Sincronizar con selección del usuario
                    mesSelect.style.display = ''; // Mostrar campo select
                }
            }

            // Sincronizar al cambiar el tipo de pago
            tipoPagosSelect.addEventListener('change', toggleMesField);

            // Sincronizar al cambiar la selección de mes
            mesSelect.addEventListener('change', () => {
                hiddenMesInput.value = mesSelect.value;
            });

            // Inicializar el comportamiento
            toggleMesField();
            // Función para limpiar checkboxes
            function limpiarCheckboxes() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                actualizarResumen(); // Actualiza el resumen al limpiar los checkboxes
            }

            // Función para actualizar el resumen
            function actualizarResumen() {
                let total = 0;
                resumenLista.innerHTML = ''; // Limpia el resumen

                if (tipoPagosSelect.value === 'combinado') {
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            const monto = parseFloat(checkbox.dataset.monto);
                            const tipo = checkbox.nextElementSibling.textContent.trim();
                            total += monto;

                            // Agregar al resumen
                            agregarItemResumen(tipo, monto);
                        }
                    });
                } else if (tipoPagosSelect.value) {
                    const selectedTipoPagoId = tipoPagosSelect.value;
                    if (montos[selectedTipoPagoId]) {
                        const monto = parseFloat(montos[selectedTipoPagoId]);
                        const tipo = tipoPagosSelect.options[tipoPagosSelect.selectedIndex].text.trim();
                        total = monto;

                        // Agregar al resumen
                        agregarItemResumen(tipo, monto);
                    }
                }

                actualizarTotal(total); // Actualiza el total mostrado
            }

            // Agregar ítem al resumen
            function agregarItemResumen(tipo, monto) {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.textContent = tipo;
                const span = document.createElement('span');
                span.textContent = `Q. ${monto.toFixed(2)}`;
                li.appendChild(span);
                resumenLista.appendChild(li);
            }

            // Actualizar el total en el resumen
            function actualizarTotal(total) {
                resumenTotal.textContent = `Q. ${total.toFixed(2)}`;
                montoInput.value = total > 0 ? `Q. ${total.toFixed(2)}` : '';
            }

            // Mostrar alertas
            function showAlert(message) {
                const alertDiv = document.createElement('div');
                alertDiv.classList.add('alert', 'alert-danger', 'mt-3');
                alertDiv.textContent = message;
                alertContainer.appendChild(alertDiv);
            }

            // Limpiar alertas
            function clearAlert() {
                alertContainer.innerHTML = '';
            }

            // Validar pagos
            function validarPagos() {
                const selectedTipoPagoId = tipoPagosSelect.value;
                const selectedMesId = mesSelect.value;

                if (!selectedMesId || selectedTipoPagoId === 'combinado') {
                    actualizarMonto();
                    return;
                }

                clearAlert();

                const yaPagado = pagosPorMes.some(pago =>
                    parseInt(pago.mes_id) === parseInt(selectedMesId) &&
                    parseInt(pago.tipopagos_id) === parseInt(selectedTipoPagoId)
                );

                if (yaPagado) {
                    showAlert('El pago seleccionado ya ha sido realizado para este mes.');
                    tipoPagosSelect.value = '';
                    actualizarMonto();
                } else {
                    actualizarMonto();
                }
            }

            function actualizarMonto() {
                let total = 0;

                if (tipoPagosSelect.value === 'combinado') {
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            total += parseFloat(checkbox.dataset.monto);
                        }
                    });
                } else {
                    const selectedTipoPagoId = tipoPagosSelect.value;
                    if (selectedTipoPagoId && montos[selectedTipoPagoId]) {
                        total = parseFloat(montos[selectedTipoPagoId]); // Asegurarse de convertir el valor a número
                    }
                }

                montoInput.value = total > 0 ? ` ${total.toFixed(2)}` : '';
            }

// Evento para limpiar checkboxes y validar al cambiar el mes
            mesSelect.addEventListener('change', () => {
                limpiarCheckboxes(); // Limpia los checkboxes al cambiar el mes
                clearAlert(); // Limpia las alertas
                actualizarResumen();
            });
            // Validar pagos combinados
            function validarPagosCombinados() {
                const selectedMesId = mesSelect.value;

                if (!selectedMesId) return;

                clearAlert();

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const yaPagado = pagosPorMes.some(pago =>
                            parseInt(pago.mes_id) === parseInt(selectedMesId) &&
                            parseInt(pago.tipopagos_id) === parseInt(checkbox.value)
                        );

                        if (yaPagado) {
                            showAlert(`El tipo de pago seleccionado (${checkbox.nextElementSibling.innerText}) ya ha sido realizado para este mes.`);
                            checkbox.checked = false;
                        }
                    }
                });

                actualizarMonto();
            }


            // Mostrar/ocultar pagos combinados
            tipoPagosSelect.addEventListener('change', () => {
                if (tipoPagosSelect.value === 'combinado') {
                    combinadoSection.style.display = 'block';
                } else {
                    combinadoSection.style.display = 'none';
                    limpiarCheckboxes();
                }
                actualizarResumen();
            });
            // Validar pagos combinados al seleccionar o deseleccionar checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', validarPagosCombinados);
            });

            // Eventos adicionales
            mesSelect.addEventListener('change', validarPagos);
            tipoPagosSelect.addEventListener('change', validarPagos);
            checkboxes.forEach(checkbox => checkbox.addEventListener('change', validarPagosCombinados));
        });

    </script>


@endsection
