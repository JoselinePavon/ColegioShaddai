@extends('layouts.app')

@section('template_title')
    Registro Alumno
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-warning text-dark">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title" class="h4 font-weight-bold">
                                {{ __('Registro Alumno') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('registro-alumnos.create') }}" class="btn btn-dark btn-sm" data-placement="left">
                                    {{ __('Registrar') }}
                                </a>
                            </div>
                        </div>
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

                    <div class="card-body bg-light">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="thead-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Género</th>
                                    <th>Edad</th>
                                    <th>Fecha Nacimiento</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($registroAlumnos as $registroAlumno)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $registroAlumno->nombres }}</td>
                                        <td>{{ $registroAlumno->apellidos }}</td>
                                        <td>{{ $registroAlumno->genero }}</td>
                                        <td>{{ $registroAlumno->edad }}</td>
                                        <td>{{ $registroAlumno->fecha_nacimiento }}</td>

                                        <td class="text-center">
                                            <form action="{{ route('registro-alumnos.destroy', $registroAlumno->id) }}" method="POST" class="delete-form">
                                                <a class="btn btn-sm btn-primary" href="{{ route('registro-alumnos.show', $registroAlumno->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i> {{ __('') }}
                                                </a>
                                                <a class="btn btn-sm btn-warning" href="{{ route('registro-alumnos.edit', $registroAlumno->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i> {{ __('') }}
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-button">
                                                    <i class="fa fa-fw fa-trash"></i> {{ __('') }}
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
                {!! $registroAlumnos->links() !!}
            </div>
        </div>
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

@endsection

