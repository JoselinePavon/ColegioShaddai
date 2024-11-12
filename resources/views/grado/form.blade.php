<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-row">
                            <div class="form-group mb-3">
                                <label for="nombre_grado" class="form-label"> {{ __('Nombre Grado') }}</label>
                                <input type="text" name="nombre_grado" class="form-control @error('nombre_grado') is-invalid @enderror" value="{{ old('nombre_grado', $grado?->nombre_grado) }}" id="nombre_grado" placeholder="Escribe el nombre del grado">
                                {!! $errors->first('nombre_grado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>


                    </div>
                </div>
            </div>




