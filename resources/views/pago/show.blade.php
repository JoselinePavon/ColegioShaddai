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
                    <table id="mediciones" class="table table-striped table-bordered shadow-sm mt-3">
                        <thead class="text-white" style="background-color: #343a40;">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Num Serie</th>
                            <th scope="col">Fecha Pago</th>
                            <th scope="col">Tipo de Pago</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Alumno</th>
                            <th scope="col">Mes</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Accion</th>
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
