@extends('layouts.app')

@section('template_title')
    Pago
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-lg">

                    <div class="card-header bg-warning text-dark">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title" class="h4 font-weight-bold">
                                {{ __('Pagos') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('pagos.create') }}" class="btn btn-dark btn-sm" data-placement="left">
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
                                    <th>No</th>
                                    <th>Num Serie</th>
                                    <th>Tipo Pago</th>
                                    <th>Costo</th>
                                    <th>Nombre Alumno</th>
                                    <th>Grado</th>
                                    <th>Fecha</th>
                                  
                                    <th class="text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($pagos as $pago)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $pago->num_serie }}</td>
                                        <td>{{ $pago->tipo_pago }}</td>
                                        <td>Q.{{ $pago->costo_pago }}</td>
                                        <td>{{ $pago->nombre_alumno }}</td>
                                        <td>{{ $pago->grado }}</td>
                                        <td>{{ $pago->fecha_pago }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST" class="delete-form">
                                                <a class="btn btn-sm btn-primary" href="{{ route('pagos.show', $pago->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i> {{ __('') }}
                                                </a>
                                                <a class="btn btn-sm btn-warning" href="{{ route('pagos.edit', $pago->id) }}">
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
                {!! $pagos->links() !!}
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

