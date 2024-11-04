@extends('layouts.app')

@section('template_title')
    Inscripción
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-lg">
                    <div class="card-header  text-dark" style="background-color: #fff2b6;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title" class="h4 font-weight-bold">
                                {{ __('Inscripción de Alumnos') }}
                            </span>
                            <a href="{{ route('inscripcions.create') }}" class="btn btn-dark btn-sm w-auto" style="border-radius: 50px;" data-placement="left">
                                <i class="fa fa-plus"></i> {{ __('Registrar Nueva Inscripcion') }}
                            </a>
                        </div>
                    </div>

                    <!-- Filtros de Grado y Sección debajo del título -->

                    <div class="p-3">
                        <form action="{{ route('inscripcions.index') }}" method="GET" class="d-flex align-items-center justify-content-start">
                            <select name="grados_id" class="form-select me-2 btn btn-outline-dark btn-sm w-25" onchange="this.form.submit()">
                                <option value="">Todos los Grados</option>
                                @foreach($grado as $id => $nombre_grado)
                                    <option value="{{ $id }}" {{ request()->get('grados_id') == $id ? 'selected' : '' }}>
                                        {{ $nombre_grado }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="seccions_id" class="form-select me-2 btn btn-outline-dark btn-sm w-25" onchange="this.form.submit()">
                                <option value="">Todas las secciones</option>
                                @foreach($seccion as $id => $nombre)
                                    <option value="{{ $id }}" {{ request()->get('seccions_id') == $id ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
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

                    <div class="card-body bg-light">
                        <div class="table-responsive">
                            <table class="table  table-hover align-middle text-center">
                                <!-- Cambiamos el color de fondo a un amarillo pálido personalizado -->
                                <thead style="background-color: #ffce94; color: #333;">
                                <tr>
                                    <th>No</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Grado</th>
                                    <th>Sección</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($inscripcions as $inscripcion)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $inscripcion->RegistroAlumno->nombres ?? 'N/A' }}</td>
                                        <td>{{ $inscripcion->RegistroAlumno->apellidos ?? 'N/A' }}</td>
                                        <td>{{ $inscripcion->grado->nombre_grado ?? 'N/A' }}</td>
                                        <td>{{ $inscripcion->seccion->seccion ?? 'N/A' }}</td>
                                        <td>
                                            <form action="{{ route('inscripcions.destroy',$inscripcion->id) }}" method="POST" class="delete-form">
                                                <a class="btn btn-sm btn-primary" href="{{ route('inscripcions.show',$inscripcion->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-warning" href="{{ route('inscripcions.edit',$inscripcion->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i>
                                                </a>
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
                {!! $inscripcions->links() !!}
            </div>
        </div>
    </div>

    {{-- SweetAlert for delete confirmation --}}
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

