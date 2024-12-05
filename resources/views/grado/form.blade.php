<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-row">
                            <div class="form-group mb-3">
                                <label for="nombre_grado" class="form-label"> {{ __('Nombre Grado') }}</label>
                                <input type="text" name="nombre_grado" class="form-control @error('nombre_grado') is-invalid @enderror" value="{{ old('nombre_grado', $grado?->nombre_grado) }}" id="nombre_grado" placeholder="Escribe el nombre del grado">
                                {!! $errors->first('nombre_grado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>
            <div class="col-md-6 mb-3">
                <label for="nivels_id" class="form-label">{{ __('Nivel') }}</label>
                <select name="nivels_id" class="form-select @error('nivels_id') is-invalid @enderror" id="nivels_id">
                    <option value="">Seleccione un Nivel</option>
                    @foreach($nivel as $id => $nivel)
                        <option value="{{ $id }}" {{ old('nivels_id', $grado->nivels_id ?? '') == $id ? 'selected' : '' }}>
                            {{ $nivel }}
                        </option>
                    @endforeach
                </select>
                @error('nivels_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

                    </div>
                </div>
            </div>




