<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-row">
                            <div class="form-group mb-3">
                                <label for="nombre_grado" class="form-label">{{ __('Nombre Grado') }}</label>
                                <input type="text" name="nombre_grado" class="form-control @error('nombre_grado') is-invalid @enderror" value="{{ old('nombre_grado', $grado?->nombre_grado) }}" id="nombre_grado" placeholder="Nombre Grado">
                                {!! $errors->first('nombre_grado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                                    <a href="{{ route('grados.index') }}" class="btn btn-danger">{{ __('Cancelar') }}</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>




