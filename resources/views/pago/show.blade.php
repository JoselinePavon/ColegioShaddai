@extends('layouts.app')

@section('template_title')
    Detalles de los Pagos del Alumno
@endsection

@section('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">


                <!-- Encabezado -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 id="card_title" class="font-weight-bold mb-2">
                            <i class="bi bi-file-earmark-check"></i>
                            {{ __('Pagos Realizados por el Alumno:') }}
                        </h4>
                        <h5 class="text-primary mb-0">
                            <span style="text-decoration: underline;">
                                {{ $registroAlumno->nombres }} {{ $registroAlumno->apellidos }}
                            </span>
                        </h5>
                    </div>
                    <div class="text-right">
                        <h6 class="text-muted mb-2">{{ now()->format('d/m/Y') }}</h6>
                        <a class="btn btn-primary btn-sm" href="{{ route('pagos.index') }}">
                            <i class="fa fa-arrow-left"></i> {{ __('Volver') }}
                        </a>
                    </div>
                </div>


                <!-- Mensaje de éxito -->
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

                <!-- Total Pagado -->
                <div class="alert alert-info mt-3 d-flex justify-content-between align-items-center">
                    <!-- Lado izquierdo: Total pagado -->
                    <div>
                        <strong>Total Pagado por el Alumno:</strong>
                        <span style="color: #006400; font-weight: bold;">
                            Q. {{ number_format($totalPagos, 2) }} </span>
                    </div>

                    <!-- Lado derecho: Filtro de año y botón Excel juntos -->
                    <div class="d-flex gap-2 align-items-center">
                        <form method="GET" action="{{ route('pagos.show', $registro_alumnos_id) }}" class="mb-0">
                            <select name="anio" class="form-select btn btn-outline-dark btn-sm" style="width: 180px;" onchange="this.form.submit()">
                                <option value="">Todos los Años</option>
                                @for($year = 2024; $year <= 2030; $year++)
                                    <option value="{{ $year }}" {{ $anio == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </form>

                        <button id="download-excel" class="btn btn-success btn-sm shadow-sm" style="font-size: 1rem;">
                            <i class="bi bi-download"></i> Descargar Excel
                        </button>
                    </div>
                </div>

                @if($pagos->isEmpty())
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-info-circle"></i>
                        @if($anio)
                            No se encontraron pagos para este alumno en el año {{ $anio }}.
                        @else
                            No se encontraron pagos para este alumno.
                        @endif
                    </div>
                @else
                    <!-- Tabla de Pagos -->
                    <div class="table-responsive">
                        <table id="mediciones" class="table table-striped table-bordered shadow-sm mt-3" style="font-size: 0.75em; margin: 0 auto; text-align: center;">
                            <thead class="text-white" style="background-color: #343a40;">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">No. Boleta</th>
                                <th scope="col">Fecha de Pago</th>
                                <th scope="col">Mes Pagado</th>
                                <th scope="col">Tipo de Pago</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Alumno</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pagos as $index => $pago)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pago->num_serie }}</td>
                                    <td>{{ $pago->fecha_pago }}</td>
                                    <td>{{ $pago->mes->mes ?? 'sin Mes' }}</td>
                                    <td>{{ $pago->tipopago->tipo_pago }}</td>
                                    <td>
                                        @if (in_array($pago->tipopagos_id, [2, 3, 4])) <!-- Colegiatura Regular y Diversificado -->
                                        {{ $pago->abono ? 'Q. ' . number_format($pago->abono, 2) : 'Q. ' . number_format($pago->tipopago->monto, 2) }}
                                        @elseif (in_array($pago->tipopagos_id, [5, 6])) <!-- Computación -->
                                        Q. {{ number_format($pago->abono, 2) }}
                                        @else <!-- Otros Tipos de Pago -->
                                        Q. {{ number_format($pago->tipopago->monto, 2) }}
                                        @endif
                                    </td>

                                    <td>{{ $pago->registroAlumno->nombres }} {{ $pago->registroAlumno->apellidos }}</td>
                                    <td>
                                        @if($pago->estado->id == 1)
                                            <span class="badge bg-success">● Solvente</span>
                                        @elseif($pago->estado->id == 2)
                                            <span class="badge bg-danger">● Insolvente</span>
                                        @elseif($pago->estado->id == 3)
                                            <span class="badge bg-warning">● Cancelado</span>
                                        @elseif($pago->estado->id == 4)
                                            <span class="badge bg-dark">● Pago Incompleto</span>
                                        @else
                                            <span class="badge bg-secondary">● Sin estado</span>
                                        @endif
                                    </td>
                                    <td class="text-center d-flex gap-1 justify-content-center">
                                        <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST" class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-button">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Script DataTable -->
    <script>
        $(document).ready(function() {
            @if(!$pagos->isEmpty())
            $('#mediciones').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ por página",
                    "zeroRecords": "<i class='fas fa-info-circle'></i> No se encontraron datos para el año seleccionado",
                    "emptyTable": "<i class='fas fa-info-circle'></i> No se encontraron datos para el año seleccionado.",
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
                "drawCallback": function(settings) {
                    if (settings.fnRecordsTotal() == 0) {
                        $(this).find('.dataTables_empty').addClass('alert-style');
                    }
                }
            });
            @endif
        });
    </script>

    <script>
        document.getElementById('download-excel').addEventListener('click', function () {
            @if($pagos->isEmpty())
            Swal.fire({
                icon: 'info',
                title: 'No hay datos',
                text: 'No hay pagos para exportar a Excel',
                confirmButtonColor: '#3085d6'
            });
            @else
            // Obtener la tabla que quieres exportar
            var table = document.getElementById('mediciones');

            // Convertir la tabla HTML a un objeto de datos de SheetJS
            var wb = XLSX.utils.table_to_book(table, { sheet: 'Pagos' });

            // Crear y descargar el archivo Excel
            XLSX.writeFile(wb, 'Pagos_Alumno.xlsx');
            @endif
        });
    </script>

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esta acción",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection
