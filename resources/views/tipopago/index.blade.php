@extends('layouts.app')

@section('template_title')
    Tipopago
@endsection

@section('content')
    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 id="card_title" class="font-weight-bold"> <i class="bi bi-wallet-fill"></i>
                        {{ __('Tipos de Pago') }}</h4>
                    <a href="{{ route('tipopagos.create') }}" class="btn btn-dark btn-sm rounded-pill">
                        <i class="fa fa-plus"></i> {{ __('Registrar Nuevo Tipo de Pago') }}
                    </a>
                </div>

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
                    <table id="mediciones" class="table table-striped table-bordered shadow-sm mt-3">
                        <thead class="text-white" style="background-color: #343a40;">
                        <tr>
                            <th>No</th>
                            <th>Tipo Pago</th>
                            <th>Monto</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tipopagos as $tipopago)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $tipopago->tipo_pago }}</td>
                                <td>Q. {{ $tipopago->monto }} </td>
                                <td class="text-center d-flex gap-1 justify-content-center">
                                    <a class="btn btn-sm btn-primary" href="{{ route('tipopagos.show', $tipopago->id) }}">
                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                    </a>
                                    <a class="btn btn-sm btn-warning" href="{{ route('tipopagos.edit', $tipopago->id) }}">
                                        <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                    </a>
                                    <form action="{{ route('tipopagos.destroy', $tipopago->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-button">
                                            <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
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
        {!! $tipopagos->links() !!}
    </div>

    {{-- SweetAlert para confirmación de eliminación --}}
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

    <style>
        .dataTables_empty {
            background-color: #cff4fc;
            color: #055160;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
        }
    </style>

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
    @if(session('alerta')=='no')

        <script>
            Swal.fire({
                title: 'No se pudo eliminar! ',
                text:'Este tipo de pago tiene realacion con otros registros, por ende es imposible eliminarlo!',
                icon: 'error',
                width: 600,
                padding: '3em',
                color: '#050404',

            })
        </script>
    @endif
@endsection
