@extends('layouts.app')

@section('template_title')
    Inscripcion
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Inscripcion') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('inscripcions.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

										<th>Nombre</th>

                                        <th>Apellido</th>
										<th>Grado</th>
										<th>Seccion</th>

                                        <th></th>
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
                                                <form action="{{ route('inscripcions.destroy',$inscripcion->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('inscripcions.show',$inscripcion->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('inscripcions.edit',$inscripcion->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
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
@endsection
