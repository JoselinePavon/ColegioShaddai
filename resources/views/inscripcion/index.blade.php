@extends('layouts.app')

@section('template_title')
    Inscripcion
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-warning text-dark">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title" class="h4 font-weight-bold">
                                {{ __('Inscripciones') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('inscripcions.create') }}" class="btn btn-dark btn-sm" data-placement="left">
                                    {{ __('Registrar') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- SweetAlert for success messages --}}
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
                                    <th>Grado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($inscripcions as $inscripcion)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $inscripcion->nombres }}</td>
                                        <td>{{ $inscripcion->apellidos }}</td>
                                        <td>{{ $inscripcion->genero }}</td>
                                        <td>{{ $inscripcion->edad }}</td>
                                        <td>{{ $inscripcion->fecha_nacimiento }}</td>
                                        <td>{{ $inscripcion->grado->nombre_grado }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('inscripcions.destroy', $inscripcion->id) }}" method="POST" class="delete-form">
                                                <a class="btn btn-sm btn-primary" href="{{ route('inscripcions.show', $inscripcion->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i> {{ __('') }}
                                                </a>
                                                <a class="btn btn-sm btn-warning" href="{{ route('inscripcions.edit', $inscripcion->id) }}">
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


