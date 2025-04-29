@extends('layouts.app')

@section('template_title')
    Alumnos Registrados
@endsection

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 id="card_title" class="font-weight-bold"> <i class="bi bi-person-circle"></i> {{ __('Listado de Alumnos Registrados, Inscritos') }}</h4>
                    <a href="{{ route('registro-alumnos.create') }}" class="btn btn-dark btn-sm rounded-pill">
                        <i class="fa fa-plus"></i> {{ __('Registrar Nuevo Alumno') }}
                    </a>
                </div>
                <form action="{{ route('filtro.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-4">
                    <select name="grados_id" class="form-select btn btn-outline-dark btn-sm w-25" onchange="this.form.submit()">
                        <option value="">Todos los Grados y Niveles</option>
                        @foreach($grado as $id => $nombre_grado_nivel)
                            <option value="{{ $id }}" {{ request()->get('grados_id') == $id ? 'selected' : '' }}>
                                {{ $nombre_grado_nivel }}
                            </option>
                        @endforeach
                    </select>

                    <select name="seccions_id" class="form-select btn btn-outline-dark btn-sm w-25" onchange="this.form.submit()">
                        <option value="">Todas las secciones</option>
                        @foreach($seccion as $id => $nombre)
                            <option value="{{ $id }}" {{ request()->get('seccions_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>



                    <button id="download-excel" class="btn btn-success btn-sm shadow-sm ms-auto" style="font-size: 1rem;">
                        <i class="bi bi-download"></i> Descargar Excel
                    </button>
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
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 0; // Inicializar el contador
                        @endphp


                        @foreach ($registroAlumnos as $registroAlumno)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $registroAlumno->codigo_personal ?? 'Codigo no asignado' }}</td>
                                <td>{{ $registroAlumno->inscripcion->codigo_correlativo ?? 'Codigo no asignado' }}</td>
                                <td>{{ $registroAlumno->apellidos }} {{ $registroAlumno->nombres }} </td>
                                <td>{{ $registroAlumno->fecha_nacimiento }}</td>
                                <td>{{ $registroAlumno->encargado->nombre_encargado ?? 'N/A' }}</td>
                                <td>{{ $registroAlumno->encargado->telefono ?? 'N/A' }}</td>
                                <td>{{ $registroAlumno->encargado->persona_emergencia ?? 'N/A' }}</td>
                                <td class="text-center d-flex gap-1">
                                    <a class="btn btn-sm btn-primary" href="{{ route('registro-alumnos.show', $registroAlumno->id) }}">
                                        <i class="fa fa-fw fa-eye"></i>
                                    </a>
                                    <a class="btn btn-sm btn-warning" href="{{ route('registro-alumnos.edit', $registroAlumno->id) }}">
                                        <i class="fa fa-fw fa-edit"></i>
                                    </a>
                                    <form action="{{ route('registro-alumnos.destroy', $registroAlumno->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-button">
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
                "lengthMenu": [[50, 100, 200, 300], [50, 100, 200, 300]], // Cambia los valores del menú
                "drawCallback": function(settings) {
                    if (settings.fnRecordsTotal() == 0) {
                        $(this).find('.dataTables_empty').addClass('alert-style');
                    }
                }
            });
        });
    </script>
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
    @if(session('alerta')=='no')

        <script>
            Swal.fire({
                title: 'No se pudo eliminar! ',
                text:'Este alumno tiene realacion con otros registros, por ende es imposible eliminarlo!',
                icon: 'error',
                width: 600,
                padding: '3em',
                color: '#050404',

            })
        </script>
    @endif
    <script>
        document.getElementById('download-excel').addEventListener('click', function() {
            // Obtén la tabla
            var table = document.getElementById('mediciones');

            // Convierte la tabla a una hoja de trabajo de Excel
            var wb = XLSX.utils.table_to_book(table, { sheet: "Listado de alumnos" });

            // Genera el archivo Excel y lo descarga
            XLSX.writeFile(wb, "listado_alumnos.xlsx");
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
