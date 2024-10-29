@extends('layouts.app')

@section('template_title')
    Encargado
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Encargado') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('encargados.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Nombre Encargado</th>
										<th>Direccion</th>
										<th>Num Encargado1</th>
										<th>Num Encargado2</th>
										<th>Persona Emergencia</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($encargados as $encargado)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $encargado->nombre_encargado }}</td>
											<td>{{ $encargado->direccion }}</td>
											<td>{{ $encargado->num_encargado1 }}</td>
											<td>{{ $encargado->num_encargado2 }}</td>
											<td>{{ $encargado->persona_emergencia }}</td>

                                            <td>
                                                <form action="{{ route('encargados.destroy',$encargado->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('encargados.show',$encargado->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('encargados.edit',$encargado->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $encargados->links() !!}
            </div>
        </div>
    </div>
@endsection
