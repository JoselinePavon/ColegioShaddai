@extends('layouts.app')

@section('template_title')
    Detalles de los Pagos del Alumno
@endsection

@section('content')
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
                {{ $pagos->first()->registroAlumno->nombres ?? '' }} {{ $pagos->first()->registroAlumno->apellidos ?? '' }}
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
                <div class="alert alert-info mt-3">
                    <strong>Total Pagado por el Alumno:</strong>
                    <span style="color: #006400; font-weight: bold;">
                        Q. {{ number_format($totalPagos, 2) }}
                    </span>
                </div>

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
                                <td>{{ $pago->mes->mes }}</td>
                                <td>{{ $pago->tipopago->tipo_pago }}</td>
                                <td>Q. {{ $pago->tipopago->monto }}.00</td>
                                <td>{{ $pago->registroAlumno->nombres }} {{ $pago->registroAlumno->apellidos }}</td>
                                <td>
                                    @if($pago->estado->id == 1)
                                        <span class="badge bg-success">● Solvente</span>
                                    @elseif($pago->estado->id == 2)
                                        <span class="badge bg-danger">● Insolvente</span>
                                    @elseif($pago->estado->id == 3)
                                        <span class="badge bg-warning">● Cancelado</span>
                                    @else
                                        <span class="badge bg-secondary">● Sin estado</span>
                                    @endif
                                </td>
                                <td class="text-center d-flex gap-1 justify-content-center">
                                    <a class="btn btn-sm btn-warning" href="{{ route('pagos.edit', $pago->id) }}">
                                        <i class="fa fa-fw fa-edit"></i>
                                    </a>
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
            </div>
        </div>
    </div>

    <!-- Script DataTable -->
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
                "drawCallback": function(settings) {
                    if (settings.fnRecordsTotal() == 0) {
                        $(this).find('.dataTables_empty').addClass('alert-style');
                    }
                }
            });
        });
    </script>
@endsection
