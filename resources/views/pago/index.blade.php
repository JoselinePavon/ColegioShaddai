@extends('layouts.app')

@section('template_title')
    Pago
@endsection

@section('content')
    <div class="container mt-3">
        <div class="card shadow-lg">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 id="card_title" class="font-weight-bold">
                        <i class="bi bi-file-earmark-check"></i> {{ __('Pagos Realizados por el Alumno') }}
                    </h4>
                    <span class="text-muted" id="fecha-actual"></span> <!-- Fecha actual -->
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
                            <th scope="col">Correlativo</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Grado</th>
                            <th scope="col">Sección</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($alumnos as $alumno)
                            <tr data-meses-pagados="{{ json_encode($alumno['mesesPagados']) }}">
                                <td>{{ ++$i }}</td>
                                <td>{{ $alumno['registroAlumno']->inscripcion->codigo_correlativo ?? 'Sin Correlativo' }}</td>
                                <td>{{ $alumno['registroAlumno']->nombres }}</td>
                                <td>{{ $alumno['registroAlumno']->apellidos }}</td>
                                <td>{{ $alumno['registroAlumno']->inscripcion->grado->nombre_grado ?? 'Sin Grado' }}</td>
                                <td>{{ $alumno['registroAlumno']->inscripcion->seccion->seccion ?? 'Sin Sección' }}</td>
                                <td class="estado">
                                    <!-- Esto será actualizado por el script -->
                                    <span style="color: gray;">● Sin estado</span>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-primary" href="{{ route('pagos.show', $alumno['registroAlumno']->id) }}">
                                        <i class="fa fa-fw fa-eye"></i> Mostrar Pagos
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
        // Obtener la fecha actual y mostrarla
        const fechaActual = new Date();
        const mesActual = fechaActual.getMonth() + 1; // Los meses van de 0 a 11
        const hoy = fechaActual.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
        document.getElementById('fecha-actual').innerText = hoy;

        // Actualizar dinámicamente los estados
        document.querySelectorAll('tr[data-meses-pagados]').forEach(row => {
            const mesesPagados = JSON.parse(row.getAttribute('data-meses-pagados')); // Obtener los meses pagados como array
            const estadoCell = row.querySelector('.estado');

            if (mesesPagados.includes(mesActual)) {
                // Si el mes actual está pagado
                estadoCell.innerHTML = `<span style="color: green;">● Solvente</span>`;
            } else {
                // Si el mes actual no está pagado
                estadoCell.innerHTML = `<span style="color: red;">● Insolvente</span>`;
            }
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
