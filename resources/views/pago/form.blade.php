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

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- SweetAlert para mensajes de éxito --}}
                        @if ($message = Session::get('success'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: '{{ $message }}',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            </script>
                        @endif

                        @if(session('error'))
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: '{{ session('error') }}',
                                    confirmButtonText: 'OK'
                                });
                            </script>
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
                                            <option value="{{ $id }}" {{ old('tipopagos_id') == $id ? 'selected' : '' }} data-monto="{{ $montos[$id] ?? 0 }}">
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

                            {{-- ★ NUEVA SECCIÓN: Checkbox para incluir mora --}}
                            <div id="mora-section" style="display: none;">
                                <div class="alert alert-info">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="incluir_mora" id="incluir_mora" value="1" {{ old('incluir_mora') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="incluir_mora">
                                            <strong>Incluir mora en este pago</strong>
                                        </label>
                                    </div>
                                    <small class="text-muted mt-2 d-block">
                                        Al marcar esta opción, se agregará el monto de la mora (Q.{{ number_format($montoMoraValue ?? 25, 2) }}) al pago de colegiatura.
                                    </small>
                                </div>

                                {{-- Mostrar información adicional cuando se marca el checkbox --}}
                                <div id="mora-info" class="alert alert-warning" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Colegiatura:</strong> Q.<span id="monto-colegiatura">0.00</span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Mora:</strong> Q.<span id="monto-mora">{{ number_format($montoMoraValue ?? 25, 2) }}</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <strong class="text-primary">Total a Pagar: Q.<span id="total-con-mora">0.00</span></strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo Monto -->
                            <div class="row align-items-end">
                                <div class="col-md-6 mb-3" id="monto-section">
                                    <label for="monto" class="form-label">{{ __('Monto') }}</label>
                                    <input type="text" id="monto" name="monto" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="anio_escolar_id" class="form-label">Año Escolar</label>
                                    <select name="anio_escolar_id" id="anio_escolar_id" class="form-select @error('anio_escolar_id') is-invalid @enderror">
                                        <option value="" disabled>Selecciona un Año Escolar</option>
                                        @foreach($aniosEscolares as $anio)
                                            <option value="{{ $anio->id }}" {{ $anio->nombre == $anioActual ? 'selected' : '' }}>{{ $anio->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('anio_escolar_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                            <div id="pago-combinado-section" style="display: none;">
                                <h5>Seleccione los pagos que desea combinar:</h5>
                                <div class="d-flex flex-wrap">
                                    @foreach($tipos as $id => $tipo_pago)
                                        @if(!in_array($id, [5, 6]) && ($id !== 1 || !$inscripcionPagada))
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
            // Variables del DOM
            const tipoPagosSelect = document.getElementById('tipopagos_id');
            const montoSection = document.getElementById('monto-section');
            const abonoSection = document.getElementById('abono-section');
            const abonoInput = document.getElementById('abono');
            const montoInput = document.getElementById('monto');
            const combinadoSection = document.getElementById('pago-combinado-section');
            const checkboxes = document.querySelectorAll('.pago-combinado-checkbox');
            const mesSelect = document.getElementById('mes_id');
            const hiddenMesInput = document.getElementById('hidden_mes_id');
            const resumenLista = document.getElementById('resumen-lista');
            const resumenTotal = document.getElementById('resumen-total');

            // ★ NUEVAS VARIABLES PARA MORA
            const moraSection = document.getElementById('mora-section');
            const moraCheckbox = document.getElementById('incluir_mora');
            const moraInfo = document.getElementById('mora-info');
            const montoColegiatura = document.getElementById('monto-colegiatura');
            const montoMoraSpan = document.getElementById('monto-mora');
            const totalConMora = document.getElementById('total-con-mora');

            // Constantes
            const MONTO_MORA = {{ $montoMoraValue ?? 25 }};
            const TIPOS_COLEGIATURA = [2, 3, 4, 5]; // IDs de colegiaturas
            const pagosPorMes = @json($pagosPorMes ?? []);
            const montos = @json($montos);

            // Crear contenedor de alertas
            const alertContainer = document.createElement('div');
            const formContainer = document.querySelector('.card-body');
            formContainer.prepend(alertContainer);

            // ★ FUNCIÓN PARA MOSTRAR/OCULTAR SECCIÓN DE MORA
            function toggleMoraSection() {
                const tipoPagoId = parseInt(tipoPagosSelect.value);

                if (TIPOS_COLEGIATURA.includes(tipoPagoId)) {
                    moraSection.style.display = 'block';
                } else {
                    moraSection.style.display = 'none';
                    moraCheckbox.checked = false;
                    toggleMoraInfo();
                }
            }

            // ★ FUNCIÓN PARA MOSTRAR/OCULTAR INFO DE MORA
            function toggleMoraInfo() {
                if (moraCheckbox.checked) {
                    moraInfo.style.display = 'block';
                    actualizarMontoConMora();
                } else {
                    moraInfo.style.display = 'none';
                    restaurarMontoOriginal();
                }
            }

            // ★ FUNCIÓN PARA ACTUALIZAR MONTO CON MORA
            function actualizarMontoConMora() {
                const tipoPagoId = parseInt(tipoPagosSelect.value);
                if (TIPOS_COLEGIATURA.includes(tipoPagoId)) {
                    const montoBase = parseFloat(montos[tipoPagoId]) || 0;
                    const total = montoBase + MONTO_MORA;

                    // Actualizar displays
                    montoColegiatura.textContent = montoBase.toFixed(2);
                    totalConMora.textContent = total.toFixed(2);
                    montoInput.value = total.toFixed(2);

                    // Actualizar resumen
                    actualizarResumen();
                }
            }

            // ★ FUNCIÓN PARA RESTAURAR MONTO ORIGINAL
            function restaurarMontoOriginal() {
                const tipoPagoId = parseInt(tipoPagosSelect.value);
                if (TIPOS_COLEGIATURA.includes(tipoPagoId)) {
                    const montoOriginal = parseFloat(montos[tipoPagoId]) || 0;
                    montoInput.value = montoOriginal.toFixed(2);
                    actualizarResumen();
                }
            }

            // Función para manejar cambio de tipo de pago
            function handleTipoPagoChange() {
                const tiposConAbono = ['5', '6'];
                const tipoPagoValue = tipoPagosSelect.value;

                if (tiposConAbono.includes(tipoPagoValue)) {
                    montoSection.style.display = 'none';
                    abonoSection.style.display = 'block';
                } else {
                    montoSection.style.display = 'block';
                    abonoSection.style.display = 'none';
                }

                // ★ MANEJAR MORA
                toggleMoraSection();

                // Resto de la lógica existente
                if (tipoPagoValue === 'combinado') {
                    combinadoSection.style.display = 'block';
                } else {
                    combinadoSection.style.display = 'none';
                    limpiarCheckboxes();
                }

                toggleMesField();
                actualizarResumen();
            }

            function toggleMesField() {
                if (tipoPagosSelect.value === '1') {
                    hiddenMesInput.value = '13';
                    mesSelect.style.display = 'none';
                    mesSelect.removeAttribute('required');
                } else if (tipoPagosSelect.value === '6') {
                    hiddenMesInput.value = '';
                    mesSelect.style.display = 'none';
                    mesSelect.removeAttribute('required');
                } else {
                    hiddenMesInput.value = mesSelect.value;
                    mesSelect.style.display = '';
                    mesSelect.setAttribute('required', 'required');
                }
            }

            function limpiarCheckboxes() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                actualizarResumen();
            }

            function actualizarResumen() {
                let total = 0;
                resumenLista.innerHTML = '';

                if (tipoPagosSelect.value === 'combinado') {
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            const monto = parseFloat(checkbox.dataset.monto);
                            const tipo = checkbox.nextElementSibling.textContent.trim();
                            total += monto;
                            agregarItemResumen(tipo, monto);
                        }
                    });
                } else if (tipoPagosSelect.value) {
                    const selectedTipoPagoId = tipoPagosSelect.value;
                    if (montos[selectedTipoPagoId]) {
                        let monto = parseFloat(montos[selectedTipoPagoId]);
                        const tipo = tipoPagosSelect.options[tipoPagosSelect.selectedIndex].text.trim();

                        // ★ AGREGAR MORA SI ESTÁ SELECCIONADA
                        if (moraCheckbox.checked && TIPOS_COLEGIATURA.includes(parseInt(selectedTipoPagoId))) {
                            agregarItemResumen(tipo, monto);
                            agregarItemResumen('Mora', MONTO_MORA);
                            total = monto + MONTO_MORA;
                        } else {
                            total = monto;
                            agregarItemResumen(tipo, monto);
                        }
                    }
                }

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

            function actualizarTotal(total) {
                resumenTotal.textContent = `Q. ${total.toFixed(2)}`;
                if (tipoPagosSelect.value !== 'combinado') {
                    montoInput.value = total > 0 ? total.toFixed(2) : '';
                }
            }

            function showAlert(message) {
                const alertDiv = document.createElement('div');
                alertDiv.classList.add('alert', 'alert-danger', 'mt-3');
                alertDiv.textContent = message;
                alertContainer.appendChild(alertDiv);
            }

            function clearAlert() {
                alertContainer.innerHTML = '';
            }

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
                        total = parseFloat(montos[selectedTipoPagoId]);

                        // ★ AGREGAR MORA SI ESTÁ MARCADA
                        if (moraCheckbox.checked && TIPOS_COLEGIATURA.includes(parseInt(selectedTipoPagoId))) {
                            total += MONTO_MORA;
                        }
                    }
                }

                montoInput.value = total > 0 ? total.toFixed(2) : '';
            }

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

            // ★ EVENTOS PARA MORA
            moraCheckbox.addEventListener('change', toggleMoraInfo);

            // Eventos existentes
            tipoPagosSelect.addEventListener('change', handleTipoPagoChange);
            mesSelect.addEventListener('change', () => {
                hiddenMesInput.value = mesSelect.value;
                limpiarCheckboxes();
                clearAlert();
                actualizarResumen();
                validarPagos();
            });

            // Validar entrada numérica en Abono
            abonoInput.addEventListener('input', () => {
                if (!/^\d*(\.\d{0,2})?$/.test(abonoInput.value)) {
                    abonoInput.setCustomValidity("Ingrese un número válido, por ejemplo: 250.50");
                } else {
                    abonoInput.setCustomValidity("");
                }
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    validarPagosCombinados();
                    actualizarResumen();
                });
            });

            // Inicializar
            handleTipoPagoChange();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('/obtener-anios-escolares')
                .then(response => response.json())
                .then(data => {
                    let select = document.getElementById('anio_escolar_id');
                    data.forEach(anio => {
                        let option = document.createElement('option');
                        option.value = anio.id;
                        option.textContent = anio.nombre;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al obtener años escolares:', error));
        });
    </script>

@endsection
