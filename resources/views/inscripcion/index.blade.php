@extends('layouts.app')

@section('template_title')
    Inscripción
@endsection

@section('content')
    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 id="card_title" class="font-weight-bold"><i class="bi bi-person-circle"></i> {{ __('Listado de Alumnos Inscritos') }}</h4>

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
                    <table id="mediciones" class="table table-striped table-bordered shadow-sm mt-3" style="font-size: 0.75em;">
                        <thead class="text-white" style="background-color: #343a40;">
                        <tr>
                            <th>No</th>
                            <th scope="col">Codigo Correlativo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Grado</th>
                            <th scope="col">Sección</th>
                            <th scope="col">Jornada</th>
                            <th scope="col">Edad</th>
                            <th scope="col">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($inscripcions as $inscripcion)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{$inscripcion->codigo_correlativo}}</td>
                                <td>{{ $inscripcion->RegistroAlumno->nombres ?? 'N/A' }}</td>
                                <td>{{ $inscripcion->RegistroAlumno->apellidos ?? 'N/A' }}</td>
                                <td>{{ $inscripcion->grado->nombre_grado ?? 'N/A' }}</td>
                                <td>{{ $inscripcion->seccion->seccion ?? 'N/A' }}</td>
                                <td>{{ $inscripcion->jornada ?? 'N/A' }}</td>
                                <td>{{ $inscripcion->RegistroAlumno->edad ?? 'N/A' }}</td>

                                <td class="d-flex gap-1">
                                    <a class="btn btn-sm btn-primary" href="{{ route('inscripcions.show', $inscripcion->id) }}">
                                        <i class="fa fa-fw fa-eye"></i>
                                    </a>
                                    <a class="btn btn-sm btn-warning" href="{{ route('inscripcions.edit', $inscripcion->id) }}">
                                        <i class="fa fa-fw fa-edit"></i>
                                    </a>

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

    @if(session('alerta')=='si')

        <script>
            Swal.fire({
                title: 'No se puede eliminar la categoria ',
                text:'Esta categoria ya esta ligado a  un customer, por ende es imposible eliminarlo',
                width: 600,
                padding: '3em',
                color: '#050404',
                background: '#fff url(/images/trees.png)',
                backdrop: `#F82D23`
            })
        </script>
    @endif

@endsection
