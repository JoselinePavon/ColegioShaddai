@extends('layouts.app')

@section('template_title')
    Pago de Computación
@endsection

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 id="card_title" class="font-weight-bold">
                        <i class="bi bi-laptop"></i> {{ __('Listado de Alumnos - Pagos de Computación') }}
                    </h4>
                </div>

                <form action="{{ route('pagos.indexcompu') }}" method="GET"
                      class="d-flex align-items-center gap-2 mb-4">

                    <select name="grados_id"
                            class="form-select btn btn-outline-dark btn-sm w-25"
                            onchange="this.form.submit()">
                        <option value="">Todos los Grados</option>
                        @foreach ($grado as $id => $nombre_grado)
                            <option value="{{ $id }}" {{ request('grados_id') == $id ? 'selected' : '' }}>
                                {{ $nombre_grado }}
                            </option>
                        @endforeach
                    </select>

                    <select name="seccions_id"
                            class="form-select btn btn-outline-dark btn-sm w-25"
                            onchange="this.form.submit()">
                        <option value="">Todas las secciones</option>
                        @foreach ($seccion as $id => $nombre)
                            <option value="{{ $id }}" {{ request('seccions_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>

                    <select name="anio_escolar_id"
                            class="form-select btn btn-outline-dark btn-sm w-25"
                            onchange="this.form.submit()">
                        <option value="">Todos los Años</option>
                        @foreach ($aniosEscolares as $id => $anio)
                            <option value="{{ $id }}"
                                {{ (request('anio_escolar_id') == $id || (!request()->has('anio_escolar_id') && isset($anioSeleccionado) && $anioSeleccionado == $id)) ? 'selected' : '' }}>
                                {{ $anio }}
                            </option>
                        @endforeach
                    </select>

                    <a href="{{ route('pagos.indexcompu') }}" class="btn btn-outline-secondary btn-sm shadow-sm" style="font-size: 1rem;">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                </form>

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

                <div class="table-responsive">
                    <table id="mediciones" class="table table-striped table-bordered shadow-sm mt-3" style="font-size: 0.75em;">
                        <thead class="text-white" style="background-color: #343a40;">
                        <tr>
                            <th>No</th>
                            <th scope="col">Codigo Personal</th>
                            <th scope="col">Codigo Correlativo</th>
                            <th scope="col">Nombre del Alumno</th>
                            <th scope="col">Fecha de Nacimiento</th>
                            <th scope="col">Nombre del Encargado</th>
                            <th scope="col">Telefono del Encargado</th>
                            <th scope="col">Telefono de Emergencia</th>
                            <th class="text-center">Total Pagado Computación</th>
                            <th class="text-center">Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 0;
                        @endphp

                        @foreach ($registroAlumnos as $registroAlumno)
                            @php
                                // Calcular el total pagado en computación (tipopagos_id = 6)
                                $totalComputacion = $registroAlumno->pagos
                                    ->where('tipopagos_id', 6)
                                    ->sum('abono');

                                $maxComputacion = 500; // Monto máximo de computación
                                $restante = $maxComputacion - $totalComputacion;
                                $completado = $totalComputacion >= $maxComputacion;
                            @endphp
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $registroAlumno->codigo_personal ?? 'Codigo no asignado' }}</td>
                                <td>{{ $registroAlumno->inscripcion->codigo_correlativo ?? 'Codigo no asignado' }}</td>
                                <td>{{ $registroAlumno->apellidos }} {{ $registroAlumno->nombres }}</td>
                                <td>{{ $registroAlumno->fecha_nacimiento }}</td>
                                <td>{{ $registroAlumno->encargado->nombre_encargado ?? 'N/A' }}</td>
                                <td>{{ $registroAlumno->encargado->telefono ?? 'N/A' }}</td>
                                <td>{{ $registroAlumno->encargado->persona_emergencia ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <strong>Q. {{ number_format($totalComputacion, 2) }}</strong>
                                    @if(!$completado)
                                        <br>
                                        <small class="text-muted">Restante: Q. {{ number_format($restante, 2) }}</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($completado)
                                        <button class="btn btn-success btn-sm">
                                            <i class="fas fa-check-circle"></i> Completo
                                        </button>
                                    @else
                                        <a href="{{ route('pagos.create', ['registro_alumnos_id' => $registroAlumno->id, 'tipopagos_id' => 6]) }}"
                                           class="btn btn-warning btn-sm"
                                           title="Registrar pago de computación">
                                            <i class="fas fa-money-bill-wave"></i> Pagar
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#mediciones').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ por página",
                    "zeroRecords": "<i class='fas fa-info-circle'></i> No se encontraron resultados para la búsqueda.",
                    "emptyTable": "<i class='fas fa-info-circle'></i> No hay datos disponibles en la tabla",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar",
                    "paginate": {
                        "first": "Primera",
                        "last": "Última",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "lengthMenu": [[50, 100, 200, 300], [50, 100, 200, 300]],
                "drawCallback": function(settings) {
                    if (settings.fnRecordsTotal() == 0) {
                        $(this).find('.dataTables_empty').addClass('alert-style');
                    }
                }
            });
        });
    </script>

    <style>
        .dataTables_empty {
            background-color: #cff4fc;
            color: #055160;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
        }
    </style>
@endsection
