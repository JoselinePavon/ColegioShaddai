@extends('layouts.app')

@section('template_title')
    Detalles de los Pagos del Alumno
@endsection

@section('content')
    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 id="card_title" class="font-weight-bold">
                        <i class="bi bi-file-earmark-check"></i> {{ __('Pagos Realizados por el Alumno') }}
                    </h4>
                    <a class="btn btn-primary btn-sm" href="{{ route('pagos.index') }}"> {{ __('Volver') }}</a>
                </div>

                <div class="table-responsive">
                    <table id="pagos" class="table table-striped table-bordered shadow-sm mt-3">
                        <thead class="text-white" style="background-color: #343a40;">
                        <tr>
                            <th>No</th>
                            <th>Num Serie</th>
                            <th>Fecha Pago</th>
                            <th>Tipo de Pago</th>
                            <th>Monto</th>
                            <th>Alumno</th>
                            <th>Mes</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pagos as $index => $pago)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pago->num_serie }}</td>
                                <td>{{ $pago->fecha_pago }}</td>
                                <td>{{ $pago->tipopago->tipo_pago }}</td>
                                <td>{{ $pago->tipopago->monto }}</td>
                                <td>{{ $pago->registroAlumno->nombres }} {{ $pago->registroAlumno->apellidos }}</td>
                                <td>{{ $pago->mes->mes }}</td>
                                <td>
                                    @if($pago->estado->id == 1)
                                        <span style="color: green;">● Solvente</span>
                                    @elseif($pago->estado->id == 2)
                                        <span style="color: red;">● Insolvente</span>
                                    @elseif($pago->estado->id == 3)
                                        <span style="color: blue;">● Cancelado</span>
                                    @else
                                        <span style="color: gray;">● Sin estado</span>
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
                "drawCallback": function(settings) {
                    if (settings.fnRecordsTotal() == 0) {
                        $(this).find('.dataTables_empty').addClass('alert-style');
                    }
                }
            });
        });
    </script>
@endsection
